@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
                <h5 class="card-header">Update Archer</h5>
                <form class="card-body"  method="POST" action="/archer/update/{{$archer->id}}">
                @csrf
                @method('put')
                  <h6>1. Archer Details</h6>
                  <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-username">Name</label>
                      <input type="text" id="multicol-username" name="name" value="{{$archer->name}}" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-email">Surname</label>
                      <div class="input-group input-group-merge">
                        <input
                          type="text"
                          name="surname" 
                          value="{{$archer->surname}}"
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
                            value="{{$archer->dob}}"
                            id="dob"
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
                        <label class="form-label" for="multicol-confirm-password">Email</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="email"
                            value="{{$archer->email}}"
                            name="email" 
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
                      <label class="form-label" for="multicol-first-name">Current Grading Dominant</label>
                      <select class="form-select" id="exampleFormControlSelect1" name="cgd" aria-label="Default select example">
                         <option value="{{$archer->currentGradingDominant}}">{{$archer->currentGradingDominant}}</option>   
                           <option value="SC1">SC1</option>   
                           <option value="SC2">SC2</option>
                           <option value="SC3">SC3</option>  
                           <option value="SJ1">SJ1</option>   
                           <option value="SJ2">SJ2</option>
                           <option value="SJ3">SJ3</option>  
                           <option value="SA1">SA1</option>   
                           <option value="SA2">SA2</option>
                           <option value="SA3">SA3</option> 

                           <option value="AC1">AC1</option>   
                           <option value="AC2">AC2</option>
                           <option value="AC3">AC3</option>  
                           <option value="AJ1">AJ1</option>   
                           <option value="AJ2">AJ2</option>
                           <option value="AJ3">AJ3</option>  
                           <option value="AA1">AA1</option>   
                           <option value="AA2">AA2</option>
                           <option value="AA3">AA3</option> 

                           <option value="MC1">MC1</option>   
                           <option value="MC2">MC2</option>
                           <option value="MC3">MC3</option>  
                           <option value="MJ1">MJ1</option>   
                           <option value="MJ2">MJ2</option>
                           <option value="MJ3">MJ3</option>  
                           <option value="MA1">MA1</option>   
                           <option value="MA2">MA2</option>
                           <option value="MA3">MA3</option> 
                     </select>
                    </div>
                   
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Current Grading Weak</label>
                      <select class="form-select" id="exampleFormControlSelect1" name="cgw" aria-label="Default select example">
                      <option value="{{$archer->currentGradingWeak}}">{{$archer->currentGradingWeak}}</option>  
                           <option value="SC1">SC1</option>   
                           <option value="SC2">SC2</option>
                           <option value="SC3">SC3</option>  
                           <option value="SJ1">SJ1</option>   
                           <option value="SJ2">SJ2</option>
                           <option value="SJ3">SJ3</option>  
                           <option value="SA1">SA1</option>   
                           <option value="SA2">SA2</option>
                           <option value="SA3">SA3</option> 

                           <option value="AC1">AC1</option>   
                           <option value="AC2">AC2</option>
                           <option value="AC3">AC3</option>  
                           <option value="AJ1">AJ1</option>   
                           <option value="AJ2">AJ2</option>
                           <option value="AJ3">AJ3</option>  
                           <option value="AA1">AA1</option>   
                           <option value="AA2">AA2</option>
                           <option value="AA3">AA3</option> 

                           <option value="MC1">MC1</option>   
                           <option value="MC2">MC2</option>
                           <option value="MC3">MC3</option>  
                           <option value="MJ1">MJ1</option>   
                           <option value="MJ2">MJ2</option>
                           <option value="MJ3">MJ3</option>  
                           <option value="MA1">MA1</option>   
                           <option value="MA2">MA2</option>
                           <option value="MA3">MA3</option> 
                     </select>
                    </div>
                    </div>  
                    </br>
                   
                    <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Current Proficiency</label>
              
                      <select class="form-select" id="exampleFormControlSelect1" name="cp" aria-label="Default select example">
                      <option value="{{$archer->currentProficiency}}">{{$archer->currentProficiency}}</option>  
                           <option value="SC1">SC1</option>   
                           <option value="SC2">SC2</option>
                           <option value="SC3">SC3</option>  
                           <option value="SJ1">SJ1</option>   
                           <option value="SJ2">SJ2</option>
                           <option value="SJ3">SJ3</option>  
                           <option value="SA1">SA1</option>   
                           <option value="SA2">SA2</option>
                           <option value="SA3">SA3</option> 

                           <option value="AC1">AC1</option>   
                           <option value="AC2">AC2</option>
                           <option value="AC3">AC3</option>  
                           <option value="AJ1">AJ1</option>   
                           <option value="AJ2">AJ2</option>
                           <option value="AJ3">AJ3</option>  
                           <option value="AA1">AA1</option>   
                           <option value="AA2">AA2</option>
                           <option value="AA3">AA3</option> 

                           <option value="MC1">MC1</option>   
                           <option value="MC2">MC2</option>
                           <option value="MC3">MC3</option>  
                           <option value="MJ1">MJ1</option>   
                           <option value="MJ2">MJ2</option>
                           <option value="MJ3">MJ3</option>  
                           <option value="MA1">MA1</option>   
                           <option value="MA2">MA2</option>
                           <option value="MA3">MA3</option> 
                     </select> 
           
                    </div>
                   
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Age Group</label>
                      <select class="form-select" id="cgd" name="ag" aria-label="Default select example">
                      <option value="{{$archer->ageCategory}}">{{$archer->ageCategory}}</option> 
                           <option value="Cub">Cub</option>   
                           <option value="Junior">Junior</option>
                           <option value="Adult">Adult</option>  
                     </select>
                    </div>
                    </div>  
                    </br>
                    <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Age Group Proficiency</label>
                      <select class="form-select" id="cgd" name="agp" aria-label="Default select example">
                      <option value="{{$archer->agegroupProficiency}}">{{$archer->agegroupProficiency}}</option> 
                           <option value="Cub">Cub</option>   
                           <option value="Junior">Junior</option>
                           <option value="Adult">Adult</option>  
                     </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Dominant Hand</label>
                      <select class="form-select" id="exampleFormControlSelect1" name="dh" aria-label="Default select example">
                      <option value="{{$archer->hand}}">{{$archer->hand}}</option> 
                           <option value="Left">Left</option>
                           <option value="Right">Right</option>  
                     </select>
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