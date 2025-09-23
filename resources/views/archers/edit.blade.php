@extends('template.default')

<style>
  .form-check {
    padding: 10px;
    border: 1px solid #d9dee3;
    border-radius: 0.375rem;
    background-color: #f8f9fa;
  }
  .form-check-input:checked {
    background-color: #696cff;
    border-color: #696cff;
  }
  .form-check-label {
    margin-left: 10px;
    font-weight: 500;
  }
</style>

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">
    <h5 class="card-header">Update Archer</h5>

    <form class="card-body" method="POST" action="/archer/update/{{ $archer->id }}">
      @csrf
      @method('put')

      <h6>1. Archer Details</h6>
      <div class="row g-6">
        <div class="col-md-6">
          <label class="form-label" for="name">Name</label>
          <input type="text" id="name" name="name" value="{{ $archer->name }}" class="form-control" placeholder="John Doe" />
        </div>

        <div class="col-md-6">
          <label class="form-label" for="surname">Surname</label>
          <div class="input-group input-group-merge">
            <input
              type="text"
              name="surname"
              id="surname"
              value="{{ $archer->surname }}"
              class="form-control"
              placeholder="Surname"
              aria-label="surname"
              aria-describedby="surname-addon" />
            <span class="input-group-text" id="surname-addon"></span>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label" for="knownAs">Known As</label>
          <input type="text" id="knownAs" name="knownAs" value="{{ $archer->knownAs ?? '' }}" class="form-control" placeholder="Nick name / Preferred name" />
        </div>

        <div class="col-md-6">
          <label class="form-label" for="dob">Date of Birth</label>
          <div class="input-group input-group-merge">
            <input
              type="date"
              name="dob"
              id="dob"
              value="{{ $archer->dob }}"
              class="form-control"
              aria-describedby="dob-addon" />
            <span class="input-group-text cursor-pointer" id="dob-addon"></span>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label" for="nationalId">National ID</label>
          <input type="text" id="nationalId" name="nId" value="{{ $archer->nId ?? '' }}" class="form-control" placeholder="National ID" />
        </div>

        <div class="col-md-6">
          <label class="form-label" for="email">Email</label>
          <div class="input-group input-group-merge">
            <input
              type="email"
              name="email"
              id="email"
              value="{{ $archer->email }}"
              class="form-control"
              placeholder="email@example.com"
              aria-describedby="email-addon" />
            <span class="input-group-text cursor-pointer" id="email-addon"></span>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label" for="gender">Gender</label>
          <select class="form-select" id="gender" name="gender" aria-label="Gender">
            <option value="{{ $archer->gender ?? '' }}">{{ $archer->gender ?? 'Select gender' }}</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label" for="hand">Dominant Hand</label>
          <select class="form-select" id="hand" name="dh" aria-label="Dominant Hand">
            <option value="{{ $archer->hand }}">{{ $archer->hand }}</option>
            <option value="Right">Right</option>
            <option value="Left">Left</option>
          </select>
        </div>
      </div>

      <hr class="my-4"/>

      <h6>2. Grading & Proficiency</h6>
      <div class="row g-6">
        <div class="col-md-6">
          <label class="form-label" for="ageCategory">Age Group</label>
          <select class="form-select" id="ageCategory" name="ag" aria-label="Age Group">
            <option value="{{ $archer->ageCategory }}">{{ $archer->ageCategory }}</option>
            <option value="Cub">Cub</option>
            <option value="Junior">Junior</option>
            <option value="Adult">Adult</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label" for="ageGroup">Age Group Proficiency</label>
          <select class="form-select" id="ageGroup" name="agp" aria-label="Age Group Proficiency">
            <option value="{{ $archer->agegroupProficiency }}">{{ $archer->agegroupProficiency }}</option>
            <option value="Cub">Cub</option>
            <option value="Junior">Junior</option>
            <option value="Adult">Adult</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label" for="cgd">Current Grading Dominant</label>
          <select class="form-select" id="cgd" name="cgd" aria-label="Current Grading Dominant">
            <option value="{{ $archer->currentGradingDominant }}">{{ $archer->currentGradingDominant }}</option>
            <!-- Cub -->
            <option value="CNG">CNG</option>
            <option value="CS1">CS1</option><option value="CS2">CS2</option><option value="CS3">CS3</option>
            <option value="CA1">CA1</option><option value="CA2">CA2</option><option value="CA3">CA3</option>
            <option value="CM1">CM1</option><option value="CM2">CM2</option><option value="CM3">CM3</option>
            <!-- Junior -->
            <option value="JNG">JNG</option>
            <option value="JS1">JS1</option><option value="JS2">JS2</option><option value="JS3">JS3</option>
            <option value="JA1">JA1</option><option value="JA2">JA2</option><option value="JA3">JA3</option>
            <option value="JM1">JM1</option><option value="JM2">JM2</option><option value="JM3">JM3</option>
            <!-- Adult -->
            <option value="ANG">ANG</option>
            <option value="AS1">AS1</option><option value="AS2">AS2</option><option value="AS3">AS3</option>
            <option value="AA1">AA1</option><option value="AA2">AA2</option><option value="AA3">AA3</option>
            <option value="AM1">AM1</option><option value="AM2">AM2</option><option value="AM3">AM3</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label" for="cgw">Current Grading Weak</label>
          <select class="form-select" id="cgw" name="cgw" aria-label="Current Grading Weak">
            <option value="{{ $archer->currentGradingWeak }}">{{ $archer->currentGradingWeak }}</option>
            <!-- Cub -->
            <option value="CNG">CNG</option>
            <option value="CS1">CS1</option><option value="CS2">CS2</option><option value="CS3">CS3</option>
            <option value="CA1">CA1</option><option value="CA2">CA2</option><option value="CA3">CA3</option>
            <option value="CM1">CM1</option><option value="CM2">CM2</option><option value="CM3">CM3</option>
            <!-- Junior -->
            <option value="JNG">JNG</option>
            <option value="JS1">JS1</option><option value="JS2">JS2</option><option value="JS3">JS3</option>
            <option value="JA1">JA1</option><option value="JA2">JA2</option><option value="JA3">JA3</option>
            <option value="JM1">JM1</option><option value="JM2">JM2</option><option value="JM3">JM3</option>
            <!-- Adult -->
            <option value="ANG">ANG</option>
            <option value="AS1">AS1</option><option value="AS2">AS2</option><option value="AS3">AS3</option>
            <option value="AA1">AA1</option><option value="AA2">AA2</option><option value="AA3">AA3</option>
            <option value="AM1">AM1</option><option value="AM2">AM2</option><option value="AM3">AM3</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label" for="cp">Current Proficiency</label>
          <select class="form-select" id="cp" name="cp" aria-label="Current Proficiency">
            <option value="{{ $archer->currentProficiency }}">{{ $archer->currentProficiency }}</option>
            <!-- Cub -->
            <option value="CNG">CNG</option>
            <option value="CS1">CS1</option><option value="CS2">CS2</option><option value="CS3">CS3</option>
            <option value="CA1">CA1</option><option value="CA2">CA2</option><option value="CA3">CA3</option>
            <option value="CM1">CM1</option><option value="CM2">CM2</option><option value="CM3">CM3</option>
            <!-- Junior -->
            <option value="JNG">JNG</option>
            <option value="JS1">JS1</option><option value="JS2">JS2</option><option value="JS3">JS3</option>
            <option value="JA1">JA1</option><option value="JA2">JA2</option><option value="JA3">JA3</option>
            <option value="JM1">JM1</option><option value="JM2">JM2</option><option value="JM3">JM3</option>
            <!-- Adult -->
            <option value="ANG">ANG</option>
            <option value="AS1">AS1</option><option value="AS2">AS2</option><option value="AS3">AS3</option>
            <option value="AA1">AA1</option><option value="AA2">AA2</option><option value="AA3">AA3</option>
            <option value="AM1">AM1</option><option value="AM2">AM2</option><option value="AM3">AM3</option>
          </select>
        </div>
      </div>

      <div class="row g-6 mt-4">
        <div class="col-md-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="clubMember" id="clubMember" {{ $archer->clubMember ? 'checked' : '' }}>
            <label class="form-check-label" for="clubMember">
              Club Member
            </label>
          </div>
        </div>
      </div>

       <div class="pt-6">
        <button type="submit" class="btn btn-primary me-3">Submit</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
      </div>
    </form>
  </div>
</div>
@endsection
