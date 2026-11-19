<?php

namespace App\Http\Requests;

use App\Models\ArcherRegistration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreArcherRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        foreach (ArcherRegistration::PERSONAL_FIELDS as $field) {
            if (is_string($this->input($field))) {
                $this->merge([$field => Str::trim($this->input($field))]);
            }
        }

        if (is_string($this->input('nId'))) {
            $this->merge(['nId' => strtoupper(preg_replace('/\s+/u', '', $this->input('nId')))]);
        }

        if (is_string($this->input('email'))) {
            $this->merge(['email' => strtolower(trim($this->input('email')))]);
        }
    }

    protected function personalRules(?ArcherRegistration $registration = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'knownAs' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date_format:Y-m-d', 'before_or_equal:today', 'after:1900-01-01'],
            'nId' => [
                'required', 'string', 'max:50',
                Rule::unique('archers', 'nId'),
                Rule::unique('archer_registrations', 'nId')
                    ->where(fn ($query) => $query->whereIn('status', ['pending', 'approved']))
                    ->ignore($registration?->id),
            ],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'hand' => ['required', Rule::in(['Right', 'Left'])],
            'email' => ['bail', 'required', 'email:rfc,filter', 'max:255'],
            'institute' => ['required', 'string', 'max:255'],
        ];
    }

    public function rules(): array
    {
        $rules = $this->personalRules();

        foreach ([...ArcherRegistration::GRADING_FIELDS, 'status', 'role', 'archer_id', 'generatedId', 'reviewed_by', 'reviewed_at', 'active_identity', 'review_notes', 'rejection_reason', 'decision', 'createdBy', 'updatedBy'] as $field) {
            $rules[$field] = ['prohibited'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return ['name' => 'first name(s)', 'nId' => 'ID / passport number', 'dob' => 'date of birth', 'hand' => 'dominant hand', 'knownAs' => 'preferred name', 'institute' => 'institute / school', 'email' => 'email address'];
    }

    public function messages(): array
    {
        return [
            'required' => 'Please enter your :attribute.',
            'gender.required' => 'Please select your gender.',
            'hand.required' => 'Please select your dominant hand.',
            'email.email' => 'Please enter a valid email address, for example name@example.com.',
            'nId.unique' => 'This ID / passport number already has an active registration or archer record.',
        ];
    }
}
