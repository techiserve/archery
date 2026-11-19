@extends('registrations.layout')
@section('title', 'Archer Registration')
@section('content')
  <h1 class="mb-4">Archer registration</h1>
  <div id="registration-validation-summary" class="alert alert-danger" role="alert" @if(!$errors->any()) hidden @endif>
    <strong>Please check your registration details.</strong>
    @if($errors->any())
      <ul class="mb-0 mt-2 ps-4">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    @endif
  </div>
  <form id="archer-registration-form" action="{{ route('archer-registrations.store') }}" method="POST">
    @csrf
    @include('registrations.personal-fields', ['registration' => null])
    <div class="registration-actions mt-5 pt-4 border-top">
      <button type="submit" class="btn btn-primary">
        <i class="icon-base bx bx-send me-2" aria-hidden="true"></i>Submit registration
      </button>
    </div>
  </form>
@endsection
@push('scripts')
  <script src="{{ asset('assets/js/archer-registration.js') }}" defer></script>
@endpush
