@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
             
            
          
                  <!-- <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-3">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div> -->
                <!-- </form> -->
 
    <!-- DataTable with Checkboxes -->
    <div class="card">
        <div class="card-datatable text-nowrap">
        <div class="table-responsive">
            <table class="datatables-basic table table-bordered table-responsive">
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
                    <tr>

                        <td>{{ $pple->name }}</td>
                        @foreach($events as $event)
                        @if($pple->event == $event->id)
                        <td>{{ $event->name }}</td>
                        @endif
                        @endforeach
                        <td>{{ $pple->date }}</td>
                        <td>{{ $pple->ageCategory }}</td>
                        <td>{{ $pple->currentGrading }}</td>
                        <td>{{ $pple->gradingfor }}</td>
                        <td>     <a  href="/historydetails/{{$pple->id}}" class='btn btn-success btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>View More</span>
                   </a>&nbsp;</td>
                 
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