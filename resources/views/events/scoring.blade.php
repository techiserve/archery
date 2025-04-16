@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
             
    <div class="card">
        <div class="card-datatable text-nowrap">
        <h5 class="card-header">Event: {{ $event->name }} | Category: {{$catname}} | Date: {{$event->doe}}</h5>
        <div class="table-responsive">
            <table id="archers-table" class="table table-bordered">
                <thead>
                    <tr>
                     
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Grading</th>
                        <th>Age Category</th>
                        <th>Latest Round</th>
                        <th>Score</th>
                        <th>Current P/R</th>
                        <th>Required P/R</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archers as $archer)  
                    <tr>
                    @foreach($pples as $pple)
                   @if($archer->archer_id == $pple->id)            
                      
                        <td>{{ $pple->name }}</td>
                        <td>{{ $pple->surname }}</td>
                        <td>{{ $pple->currentGradingDominant }}</td>
                        <td>{{ $pple->ageCategory }}</td>
                        <td>{{ $archer->timed }}</td>
                        <td>{{ $archer->totalScore }}</td>
                        <td>{{ round($archer->thumbring)  }}</td>
                        <td>{{ round($archer->arrowinhand) }}</td>
                        <td class="text-center">  
                          
                  @if($archer->status == '1')
                  @if($event->status != '1')
                      <a  href="/gradearcher/{{$archer->id}}" class='btn btn-success btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>  Capture Scores</span>
                   </a>&nbsp;
                   @endif

                   <a  href="/archer/edit/{{$archer->archer_id}}" class='btn btn-primary btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Archer Info</span>
                   </a>&nbsp;
                          
                   @else
                   @if($event->status != '1')
                             <button
                              type="button"
                              class="btn btn-success btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#modalCenter{{ $archer->id }}">
                              Capture Details
                            </button>
                            @endif

                      <a  href="/archer/edit/{{$archer->archer_id}}" class='btn btn-primary btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Archer Info</span>
                   </a>&nbsp;

                   
                 
             @endif
             <!-- <a  href="/archer/certificate/{{$archer->id}}" class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'> Download Certificate</span>
                   </a>&nbsp; -->

   
<!-- Modal -->
<div class="modal fade" id="modalCenter{{ $archer->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form class="card-body" method="POST" action="{{ route('event.archerDetails') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Capture Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-6">
            <div class="col mb-0">
              <label class="form-label">Arrow Used</label>
              <input type="text" name="arrowUsed" class="form-control" placeholder="Enter Arrow Used" />
            </div>
            <div class="col mb-0">
              <label class="form-label">Bow Used</label>
              <input type="text" name="bowUsed" class="form-control" placeholder="Enter Bow Used" />
            </div>
          </div>
        
        </div>

        <!-- Send IDs or values properly -->
        <input type="hidden" name="cat" value="{{ $cat }}">
        <input type="hidden" name="archer" value="{{ $pple->id }}"> <!-- Better to use ID than surname -->
        <input type="hidden" name="event" value="{{ $archer->event_id }}">

        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>


   
<!-- Modal -->
<div class="modal fade" id="modalCente{{ $archer->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form class="card-body" method="POST" action="{{ route('event.archerDetails') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Capture Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-6">
            <div class="col mb-0">
              <label class="form-label">Arrow Used</label>
              <input type="text" name="arrowUsed" class="form-control" placeholder="Enter Arrow Used" />
            </div>
            <div class="col mb-0">
              <label class="form-label">Bow Used</label>
              <input type="text" name="bowUsed" class="form-control" placeholder="Enter Bow Used" />
            </div>
          </div>
        
        </div>

        <!-- Send IDs or values properly -->
        <input type="hidden" name="cat" value="{{ $cat }}">
        <input type="hidden" name="archer" value="{{ $pple->id }}"> <!-- Better to use ID than surname -->
        <input type="hidden" name="event" value="{{ $archer->event_id }}">

        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

                     </td>
                        @endif
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
   
    
    
    </div>
  </div>
   
  

            

@endsection
<script>
  document.addEventListener("DOMContentLoaded", function() {
    $('#archers-table').DataTable({
      responsive: true,
      pageLength: 10,
      ordering: false,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'print'],
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search ..."
      }
    });
  });
</script>