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
@php
    // Get the maximum number of arrows in any round
    $maxArrows = $scorecards->map(function ($round) {
        return count($round);
    })->max();

    $roundTotals = [];
    $cumTotals = [];
    $times = [];
    $totalScore = 0;

    foreach ($scorecards as $round => $entries) {
        $first = $entries->first();
        $roundTotals[$round] = $first->roundtotal ?? 0;
        $cumTotals[$round] = $first->cumtotal ?? 0;
        $times[$round] = $first->time ?? '-';
        $totalScore = $first->total ?? 0;
    }
@endphp

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Arrow</th>
            @foreach($scorecards as $round => $entries)
                <th>Round {{ $round }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{-- Arrows --}}
        @for($i = 0; $i < $maxArrows; $i++)
            <tr>
                <td>Arrow {{ $i + 1 }}</td>
                @foreach($scorecards as $round => $entries)
                    <td>{{ $entries[$i]->arrow ?? '-' }}</td>
                @endforeach
            </tr>
        @endfor

        {{-- Round Total --}}
        <tr>
            <td><strong>Round Total</strong></td>
            @foreach($roundTotals as $round => $val)
                <td><strong>{{ $val }}</strong></td>
            @endforeach
        </tr>

        {{-- Cum Total --}}
        <tr>
            <td><strong>Cum Total</strong></td>
            @foreach($cumTotals as $round => $val)
                <td><strong>{{ $val }}</strong></td>
            @endforeach
        </tr>

        {{-- Time --}}
        <tr>
            <td><strong>Time</strong></td>
            @foreach($times as $round => $val)
                <td>{{ $val }}</td>
            @endforeach
        </tr>

        {{-- Total Score (one cell only) --}}
        <tr>
            <td colspan="{{ count($scorecards) + 1 }}">
                <strong>Total Score: {{ $totalScore }}</strong>
            </td>
        </tr>
    </tbody>
</table>



 
</form>

            
@endsection