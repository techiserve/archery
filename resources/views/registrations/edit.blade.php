@extends('template.default')
@section('viewport', 'width=device-width, initial-scale=1')
@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/archer-registrations.css') }}">
@endpush
@section('content')
@php
  $pending = $registration->status === 'pending';
  $groups = ['Cub', 'Junior', 'Adult', 'Too Young'];
  $statusTone = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'][$registration->status];
  $beginnerGrade = ['Cub' => 'CNG', 'Junior' => 'JNG', 'Adult' => 'ANG'][$suggestedGroups['ageCategory']] ?? null;
@endphp
<div class="archer-registration-page container-xxl flex-grow-1 container-p-y">
  <a href="{{ route('archer-registrations.index', ['status' => $registration->status]) }}" class="registration-back d-inline-flex align-items-center mb-3"><i class="icon-base bx bx-arrow-back me-2" aria-hidden="true"></i>Registrations</a>
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <h4 class="mb-0">{{ $pending ? 'Review registration' : 'Registration' }} #{{ $registration->id }}</h4>
    <span class="badge bg-label-{{ $statusTone }}">{{ ucfirst($registration->status) }}</span>
  </div>
  @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
  @if(session('warning'))<div class="alert alert-warning" role="alert">{{ session('warning') }}</div>@endif
  @if($errors->any())
    <div class="alert alert-danger" role="alert"><ul class="mb-0 ps-4">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
  @endif
  @if(!$pending)
    <div class="mb-4">
      <p class="mb-2">{{ ucfirst($registration->status) }} {{ $registration->reviewed_at?->format('d M Y H:i') }}{{ $registration->reviewer ? ' by ' . $registration->reviewer->name : '' }}.</p>
      @if($registration->rejection_reason)<p class="text-danger mb-2">{{ $registration->rejection_reason }}</p>@endif
      @if($registration->archer)
        <div class="registration-result-actions">
          <a class="btn btn-primary btn-sm" href="{{ route('archer.edit', $registration->archer_id) }}"><i class="icon-base bx bx-edit me-2" aria-hidden="true"></i>Edit approved archer</a>
          <a class="btn btn-outline-secondary btn-sm" href="{{ route('achers.index') }}">Archers list</a>
        </div>
      @endif
    </div>
  @endif
  <form method="POST" action="{{ route('archer-registrations.update', $registration) }}" class="bg-white border rounded p-4 p-md-5">
    @csrf
    @method('PUT')
    <fieldset @disabled(!$pending)>
      <legend class="h6 mb-4">Personal details</legend>
      @include('registrations.personal-fields')
      <hr class="my-5">
      <h6 class="mb-4">Grading &amp; proficiency</h6>
      <div class="row g-4">
        @foreach(['ageCategory' => 'Age group', 'agegroupProficiency' => 'Age group proficiency'] as $fieldName => $label)
          <div class="col-md-6">
            <label class="form-label" for="{{ $fieldName }}">{{ $label }}</label>
            <select id="{{ $fieldName }}" name="{{ $fieldName }}" class="form-select @error($fieldName) is-invalid @enderror">
              <option value="">Select group</option>
              @foreach($groups as $group)<option value="{{ $group }}" @selected(old($fieldName, $registration->{$fieldName} ?? ($pending ? $suggestedGroups[$fieldName] : null)) === $group)>{{ $group }}</option>@endforeach
            </select>
            @error($fieldName)<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        @endforeach
        @foreach(['currentGradingDominant' => 'Dominant-hand grading', 'currentGradingWeak' => 'Non-dominant-hand grading', 'currentProficiency' => 'Proficiency'] as $fieldName => $label)
          <div class="col-md-6">
            <label class="form-label" for="{{ $fieldName }}">{{ $label }}</label>
            <select id="{{ $fieldName }}" name="{{ $fieldName }}" class="form-select @error($fieldName) is-invalid @enderror">
              <option value="">Select level</option>
              @foreach($gradeGroups as $group => $levels)
                <optgroup label="{{ $group }}">
                  @foreach($levels as $level)<option value="{{ $level }}" @selected(old($fieldName, $registration->{$fieldName} ?? ($pending ? $beginnerGrade : null)) === $level)>{{ $level }}</option>@endforeach
                </optgroup>
              @endforeach
            </select>
            @error($fieldName)<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        @endforeach
        <div class="col-md-6 d-flex align-items-end pb-2">
          <div class="form-check">
            <input type="checkbox" name="clubMember" value="1" id="clubMember" class="form-check-input" @checked(old('clubMember', $registration->clubMember))>
            <label class="form-check-label" for="clubMember">Club member</label>
          </div>
        </div>
      </div>
      <hr class="my-5">
      <div class="mb-4">
        <label class="form-label" for="review_notes">Internal review notes</label>
        <textarea class="form-control" id="review_notes" name="review_notes" rows="3" maxlength="5000">{{ old('review_notes', $registration->review_notes) }}</textarea>
      </div>
      @if($pending)
        <div class="mb-4">
          <label class="form-label" for="rejection_reason">Rejection reason (required when rejecting)</label>
          <textarea class="form-control @error('rejection_reason') is-invalid @enderror" id="rejection_reason" name="rejection_reason" rows="2" maxlength="2000">{{ old('rejection_reason') }}</textarea>
          @error('rejection_reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="registration-actions pt-3 border-top">
          <button type="submit" name="decision" value="save" class="btn btn-outline-primary"><i class="icon-base bx bx-save me-2" aria-hidden="true"></i>Save changes</button>
          <button type="submit" name="decision" value="approve" class="btn btn-success"><i class="icon-base bx bx-check me-2" aria-hidden="true"></i>Approve archer</button>
          <button type="submit" name="decision" value="reject" class="btn btn-outline-danger"><i class="icon-base bx bx-x me-2" aria-hidden="true"></i>Reject</button>
        </div>
      @endif
    </fieldset>
  </form>
</div>
@endsection
