@extends('registrations.layout')
@section('title', 'Registration Received')
@section('content')
  <i class="icon-base bx bx-check-circle text-success mb-3" style="font-size:40px" aria-hidden="true"></i>
  <h1>Registration received</h1>
  <p class="text-body-secondary">Thank you for registering with Qurtuba Furusiyyah.</p>
  <dl class="row my-4">
    <dt class="col-sm-3">Reference</dt><dd class="col-sm-9">{{ session('registration_reference') }}</dd>
    <dt class="col-sm-3">Status</dt><dd class="col-sm-9"><span class="badge bg-label-warning">Awaiting approval</span></dd>
  </dl>
  <div class="registration-actions">
    <a href="{{ route('archer-registrations.create') }}" class="btn btn-outline-primary">Register another archer</a>
  </div>
@endsection
