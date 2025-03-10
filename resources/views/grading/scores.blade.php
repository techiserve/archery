@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
                <h5 class="card-header">Grading</h5>
                <form class="card-body"  method="POST" action="/grading/store">
                @csrf
                  <h6></h6>
                  <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-username">Level</label>
                      <input type="text" id="multicol-username" name="level" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-email">Distance</label>
                      <div class="input-group input-group-merge">
                        <input
                          type="text"
                          name="distance" 
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
                        <label class="form-label" for="multicol-password">Cub</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="text"
                            name="cub" 
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
                        <label class="form-label" for="multicol-confirm-password">Junior</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="text"
                            name="junior" 
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
                      <label class="form-label" for="multicol-first-name">Adult</label>
                      <input type="text" id="multicol-first-name" name="adult" class="form-control" placeholder="" />
                    </div>
                   
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Name</label>
                      <input type="text" id="multicol-first-name" name="name" class="form-control" placeholder="" />
                    </div>
                   
                  </div>
                  </br>     
                  <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Stripe Color</label>
                      <input type="text" id="multicol-first-name" name="color" class="form-control" placeholder="" />
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