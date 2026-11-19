@extends('template.default')
@section('viewport', 'width=device-width, initial-scale=1')
@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/archer-registrations.css') }}">
@endpush
@section('content')
<div class="archer-registration-page container-xxl flex-grow-1 container-p-y">
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <h4 class="mb-0">Archer registrations</h4>
    <a href="{{ route('archer-registrations.create') }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
      <i class="icon-base bx bx-link-external me-2" aria-hidden="true"></i>Registration page
    </a>
  </div>
  <nav class="registration-tabs nav nav-tabs mb-4" aria-label="Registration status">
    @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $value => $label)
      <a href="{{ route('archer-registrations.index', ['status' => $value, 'q' => $search]) }}"
        class="nav-link {{ $status === $value ? 'active' : '' }}" @if($status === $value) aria-current="page" @endif>
        {{ $label }} <span class="badge bg-label-secondary ms-1">{{ $counts->get($value, 0) }}</span>
      </a>
    @endforeach
  </nav>
  <form method="GET" action="{{ route('archer-registrations.index') }}" class="row g-2 align-items-end mb-4">
    <input type="hidden" name="status" value="{{ $status }}">
    <div class="col-sm-7 col-md-5">
      <label for="registration-search" class="form-label">Search registrations</label>
      <input id="registration-search" type="search" name="q" value="{{ $search }}" maxlength="100" class="form-control" placeholder="Name, email, ID or institute">
    </div>
    <div class="col-auto d-flex gap-2">
      <button type="submit" class="btn btn-primary" title="Search" aria-label="Search"><i class="icon-base bx bx-search" aria-hidden="true"></i></button>
      @if($search !== '')<a class="btn btn-outline-secondary" href="{{ route('archer-registrations.index', ['status' => $status]) }}">Reset</a>@endif
    </div>
  </form>
  <div class="registration-list table-responsive bg-white border rounded">
    <table class="table table-hover align-middle mb-0" role="table" aria-label="{{ ucfirst($status) }} archer registrations">
      <thead><tr><th>Name</th><th>Email</th><th>Date of birth</th><th>Hand</th><th>Institute</th><th>Submitted</th><th>Action</th></tr></thead>
      <tbody>
        @forelse($registrations as $registration)
          <tr>
            <td class="registration-name" data-label="Name"><a class="fw-semibold" href="{{ route('archer-registrations.edit', $registration) }}">{{ $registration->name }} {{ $registration->surname }}</a></td>
            <td class="registration-email" data-label="Email">{{ $registration->email }}</td>
            <td class="text-nowrap" data-label="Date of birth">{{ $registration->dob->format('d M Y') }}</td>
            <td data-label="Hand">{{ $registration->hand }}</td>
            <td data-label="Institute">{{ $registration->institute ?: '-' }}</td>
            <td class="text-nowrap" data-label="Submitted">{{ $registration->created_at->format('d M Y') }}</td>
            <td class="registration-row-action"><a class="btn btn-sm btn-outline-primary" href="{{ route('archer-registrations.edit', $registration) }}">{{ $status === 'pending' ? 'Review' : 'View' }}<i class="icon-base bx bx-right-arrow-alt ms-1" aria-hidden="true"></i></a></td>
          </tr>
        @empty
          <tr><td colspan="7" class="registration-empty text-center text-body-secondary py-5">No {{ $status }} registrations{{ $search !== '' ? ' match this search' : '' }}.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $registrations->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
