@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
                <h5 class="card-header">Create Archer</h5>
                <form class="card-body"  method="POST" action="/archers/store">
                @csrf
                  <h6>1. Archer Details</h6>
                  <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-username">Name</label>
                      <input type="text" id="multicol-username" name="name" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-email">Surname</label>
                      <div class="input-group input-group-merge">
                        <input
                          type="text"
                          name="surname" 
                          id="multicol-email"
                          class="form-control"
                          placeholder="Surname"
                          aria-label="john.doe"
                          aria-describedby="multicol-email2" />
                        <span class="input-group-text" id="multicol-email2"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-password-toggle">
                        <label class="form-label" for="multicol-password">Date of Birth</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="date"
                            name="dob" 
                            id="multicol-password"
                            class="form-control"
                            placeholder=""
                            aria-describedby="multicol-password2" />
                          <span class="input-group-text cursor-pointer" id="multicol-password2"
                            ></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-password-toggle">
                        <label class="form-label" for="multicol-confirm-password">Category</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="text"
                            name="category" 
                            id="multicol-confirm-password"
                            class="form-control"
                            placeholder=""
                            aria-describedby="multicol-confirm-password2" />
                          <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"
                            ><i class=""></i
                          ></span>
                        </div>
                      </div>
                    </div>
                  </div>
                 </br>
                  <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Current Grading</label>
                      <input type="text" id="multicol-first-name" name="grading" class="form-control" placeholder="" />
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