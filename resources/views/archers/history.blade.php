@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
@php $certificateEventScoreIdsByGradingId = $certificateEventScoreIdsByGradingId ?? collect(); @endphp
<div class="card mb-6">
             
            
          
                  <!-- <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-3">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div> -->
                <!-- </form> -->
 
    <!-- DataTable with Checkboxes -->
    <div class="card">
        
        <div class="card-datatable text-nowrap">
        <h5 class="card-header">Archer History</h5>
        <div class="table-responsive">
            <table id="history-table" class="table table-bordered">
                <thead>
                    <tr>
                     
                        <th>Name</th>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Grading</th>
                        <th>Grading for</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all as $pple )  
                    @php $event = $events->firstWhere('id', $pple->event); @endphp
                    @php $certificateEventScoreId = $certificateEventScoreIdsByGradingId->get((string) $pple->id); @endphp
                    <tr>

                        <td>{{ $pple->name }}</td>
                        <td>{{ $event->name ?? 'Unknown Event' }}</td>
                        <td>{{ $pple->date }}</td>
                        <td>{{ $pple->ageCategory }}</td>
                        <td>{{ $pple->currentGrading }}</td>
                        <td>{{ $pple->gradingfor }}</td>
                        <td>
                          <a href="/historydetails/{{$pple->id}}" class="btn btn-success btn-sm" style="color: white;">
                            <span class="fa fa-pencil"></span>
                            <span class="hidden-sm hidden-sm hidden-md">View More</span>
                          </a>

                          @if($certificateEventScoreId)
                            <a href="{{ route('archer.certificate', $certificateEventScoreId) }}" class="btn btn-warning btn-sm">
                              <span class="fa fa-download"></span>
                              Certificate
                            </a>

                            <form method="POST" action="{{ route('archer.certificate.email', $certificateEventScoreId) }}" class="d-inline">
                              @csrf
                              <button type="submit" class="btn btn-secondary btn-sm">
                                <span class="fa fa-envelope"></span>
                                Send Email
                              </button>
                            </form>
                          @endif
                        </td>
                 
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
    $('#history-table').DataTable({
      responsive: true,
      pageLength: 10,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'print'],
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search..."
      }
    });
  });
</script>
