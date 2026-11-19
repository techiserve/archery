<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewArcherRegistrationRequest;
use App\Http\Requests\StoreArcherRegistrationRequest;
use App\Mail\ArcherRegistrationDecisionMail;
use App\Models\Archer;
use App\Models\ArcherRegistration;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class ArcherRegistrationController extends Controller
{
    public function create()
    {
        return view('registrations.create');
    }

    public function store(StoreArcherRegistrationRequest $request)
    {
        try {
            $registration = ArcherRegistration::create($request->safe()->only(ArcherRegistration::PERSONAL_FIELDS));
        } catch (UniqueConstraintViolationException $exception) {
            throw ValidationException::withMessages(['nId' => 'This ID / passport number already has an active registration.']);
        }

        return redirect()->route('archer-registrations.complete')
            ->with('registration_reference', sprintf('REG-%06d', $registration->id));
    }

    public function complete(Request $request)
    {
        if (! $request->session()->has('registration_reference')) {
            return redirect()->route('archer-registrations.create');
        }

        return view('registrations.complete');
    }

    public function index(Request $request)
    {
        $filters = $request->validate([
            'status' => ['sometimes', Rule::in(['pending', 'approved', 'rejected'])],
            'q' => ['nullable', 'string', 'max:100'],
        ]);
        $status = $filters['status'] ?? 'pending';
        $search = trim($filters['q'] ?? '');
        $counts = ArcherRegistration::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $registrations = ArcherRegistration::where('status', $status)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    foreach (['name', 'surname', 'email', 'nId', 'institute'] as $field) {
                        $query->orWhere($field, 'like', '%'.$search.'%');
                    }
                });
            })
            ->latest()->paginate(20)->withQueryString();

        return view('registrations.index', compact('registrations', 'counts', 'status', 'search'));
    }

    public function edit(ArcherRegistration $registration)
    {
        $registration->load(['reviewer', 'archer']);

        return view('registrations.edit', [
            'registration' => $registration,
            'suggestedGroups' => $registration->suggestedAgeGroups(),
            'gradeGroups' => ArcherRegistration::GRADE_GROUPS,
        ]);
    }

    public function update(ReviewArcherRegistrationRequest $request, ArcherRegistration $registration)
    {
        $decision = $request->validated('decision');

        try {
            DB::transaction(function () use ($request, $registration, $decision) {
                $registration = ArcherRegistration::whereKey($registration->id)->lockForUpdate()->firstOrFail();

                if ($registration->status !== 'pending') {
                    throw ValidationException::withMessages(['decision' => 'This registration has already been reviewed.']);
                }

                $registration->fill($request->safe()->only([
                    ...ArcherRegistration::PERSONAL_FIELDS,
                    ...ArcherRegistration::GRADING_FIELDS,
                    'review_notes',
                ]));
                $registration->clubMember = $request->boolean('clubMember');

                if ($decision === 'approve') {
                    $archer = Archer::create([
                        ...$registration->only([...ArcherRegistration::PERSONAL_FIELDS, ...ArcherRegistration::GRADING_FIELDS]),
                        'dob' => $registration->dob->format('Y-m-d'),
                        'clubMember' => $registration->clubMember ? '1' : '0',
                        'createdBy' => $request->user()->id,
                    ]);
                    $prefix = Str::lower(Str::substr($archer->name, 0, 3).Str::substr($archer->surname, 0, 3));
                    $suffix = $archer->id;

                    do {
                        $generatedId = $prefix.str_pad((string) $suffix++, 2, '0', STR_PAD_LEFT);
                    } while (Archer::where('generatedId', $generatedId)->exists());

                    $archer->update(['generatedId' => $generatedId]);
                    $registration->archer_id = $archer->id;
                    $registration->status = 'approved';
                } elseif ($decision === 'reject') {
                    $registration->status = 'rejected';
                    $registration->rejection_reason = $request->validated('rejection_reason');
                }

                if ($decision !== 'save') {
                    $registration->reviewed_by = $request->user()->id;
                    $registration->reviewed_at = now();
                }

                $registration->save();
            });
        } catch (UniqueConstraintViolationException $exception) {
            throw ValidationException::withMessages(['nId' => 'This ID / passport number already has an active registration.']);
        }

        $message = match ($decision) {
            'approve' => 'Registration approved. The archer is now in the archers list.',
            'reject' => 'Registration rejected.',
            default => 'Registration details saved.',
        };

        $emailWarning = null;

        if ($decision !== 'save') {
            try {
                $registration->refresh()->load('archer');

                Mail::to($registration->email)->queue(new ArcherRegistrationDecisionMail(
                    archerName: trim($registration->name.' '.$registration->surname),
                    registrationStatus: $registration->status,
                    reference: sprintf('REG-%06d', $registration->id),
                    archerNumber: $registration->archer?->generatedId,
                    rejectionReason: $registration->rejection_reason,
                ));

                $message .= ' Notification email queued.';
            } catch (Throwable $exception) {
                report($exception);
                $emailWarning = 'The registration decision was saved, but the notification email could not be queued. Please check the queue and email settings.';
            }
        }

        $response = redirect()->route('archer-registrations.edit', $registration)->with('success', $message);

        if ($emailWarning) {
            $response->with('warning', $emailWarning);
        }

        return $response;
    }
}
