@extends('template.default')
<style>
  /* Add space between control icon and first column */
  table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before {
    margin-right: 20px !important;
  }
</style>
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
        <h5 class="card-header">Events</h5>
        <div class="table-responsive">
            <table id="archers-table" class="table table-bordered">
                <thead>
                    <tr  >
                     
                        <th>.</th>
                        <th>Name</th>
                        <th>Category</th>
                     
                        <th>Date of Event</th>  
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archers as $archer)  
                    <tr>
                       
                        <td></td>
                        <td  onclick="window.location='{{ route('events.showEvent', $archer->id) }}'" style="cursor:pointer;" >{{ $archer->name }}</td>

                        @foreach($categories as $category)
                        @if($archer->cat == $category->id)
                        <td>{{ $category->name }}</td>
                        @endif
                        @endforeach
                        <td>{{ $archer->doe }}</td>

                        @if($archer->status == 1)
                        <td><span class="badge bg-label-danger"> Ended </span></td>
                        @else
                        <td><span class="badge bg-label-success"> Open </span></td>
                        @endif

                        <td>
                        @if($archer->status != 1)  
                        <a  href="/endevent/{{$archer->id}}" class='btn btn-danger btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>End Event</span>
                      </a>&nbsp;
                     @endif

                     <a  href="/events/showEvent/{{$archer->id}}"  class='btn btn-success btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Score Archers</span>
                     </a>&nbsp;
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
                        
    
    <!-- Submit Button -->
 

              <!--/ DataTable with Buttons -->  
@endsection
<script>
  document.addEventListener("DOMContentLoaded", function() {
    $('#archers-table').DataTable({
      responsive: {
        details: {
          type: 'inline'
        }
      },
      pageLength: 10,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'print'],
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search..."
      },
      columnDefs: [
        { responsivePriority: 1, targets: 0 }, // Category - Always visible
        { responsivePriority: 2, targets: 1 }, // Name - Always visible
        { responsivePriority: 10001, targets: [2, 3, 4] } // Hide these in mobile first
      ]
    });
  });
</script>
