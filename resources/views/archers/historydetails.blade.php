@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
                <h5 class="card-header">Score Card History</h5>
                <form class="card-body"  method="POST" action="/grading/confirmscores">
                @csrf
                <h6> Event Details</h6>
                  <div class="row g-12">
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Name</label>
                      <input type="text" id="multicol-username" name="name" value="{{$grading->name}}" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Date</label>
                      <input type="text" id="multicol-username" name="date"  value="{{$grading->date}}" class="form-control" placeholder="John Doe" />
                    </div>
                    <!-- <div class="col-md-4">
                    
                      <label class="form-label" for="multicol-username">Event Category</label>
                      <input type="text" id="multicol-username" name="eventcategory"  value="{{$grading->eventcategory}}" class="form-control" placeholder="John Doe" />
                    </div> -->
                    
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Bow Used</label>
                      <input type="text" id="multicol-username" name="bowused"  value="{{$grading->bowUsed}}" class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Current Grading</label>
                      <input type="text" id="multicol-username" name="curentgrading"  value="{{$grading->currentGrading}}"  class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                    <label class="form-label" for="multicol-email">Grading for </label>
                   
                      <input type="text" id="multicol-username" name="gradefor"  value="{{$grading->gradingfor}}" class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                    <label class="form-label" for="multicol-username">Age Category</label>
                    <input type="text" id="multicol-username" name="age"  value="{{$grading->ageCategory}}" class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                      <div class="form-password-toggle">
                      <label class="form-label" for="multicol-username">Arrow Used</label>
                      <input type="text" id="multicol-username" name="arrow"  value="{{$grading->arrowsUsed}}" class="form-control" placeholder="John Doe" />
                      </div>
                    </div>
            
                    
    
              </div>
                        
</div>



 
</form>

            
@endsection