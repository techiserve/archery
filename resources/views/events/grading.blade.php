@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
                <h5 class="card-header">Create Event</h5>
                <form class="card-body"  method="POST" action="/grading/details">
                @csrf
                  <h6> Event Details</h6>
                  <div class="row g-12">
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Name</label>
                      <input type="text" id="multicol-username" name="name" value="{{$archer->name}} {{$archer->surname}}" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Date</label>
                      <input type="date" id="multicol-username" name="date" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-email">Select Event Category</label>
                      <div class="input-group input-group-merge">
                      <select class="form-select" id="exampleFormControlSelect1" name="ec" aria-label="Default select example">  
                        @foreach($categories as $cat)
                      <option value="{{$cat->name}}">{{$cat->name}} </option>  
                         @endforeach  
                      </select>
                      </div>
                    </div>
                    
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Bow Used</label>
                      <input type="text" id="multicol-username" name="bu" class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Current Grading</label>
                      <input type="text" id="multicol-username" name="cg" value="{{$archer->currentGrading}}" class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                    <label class="form-label" for="multicol-email">Grading for </label>
                    <select class="form-select" id="exampleFormControlSelect1" name="gf" aria-label="Default select example">  
                        @foreach($scores as $score)
                      <option value="{{$score->level}}">{{$score->level}} </option>  
                         @endforeach  
                      </select>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label" for="multicol-email">Age Category</label>
                      <div class="input-group input-group-merge">
                      <select class="form-select" id="exampleFormControlSelect1" name="ag" aria-label="Default select example">  
          
                      <option value="cub">Cub</option>  
                      <option value="junior">Junior</option>  
                      <option value="adult">Adult</option>  
                  
                      </select>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-password-toggle">
                        <label class="form-label" for="multicol-password">Arrow Used</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="text"
                            name="au" 
                            id="multicol-password"
                            class="form-control"
                            placeholder=""
                            aria-describedby="multicol-password2" />
                          <span class="input-group-text cursor-pointer" id="multicol-password2"
                            ></span>
                        </div>
                      </div>
                    </div>
            
                    <input type="hidden" name="event" value="{{$eventyacho->event_id}}">
                    <input type="hidden" name="archer" value="{{$archer->id}}">

                  <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-3">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div>
                </form>
              </div>
                        
</div>

</form>

    
@endsection