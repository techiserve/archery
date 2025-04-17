@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
         
            
    <div class="card">
        <div class="card-datatable text-nowrap">
        <h5 class="card-header">Manage Events.</h5>
        <div class="table-responsive">
            <table id="manage-table" class="table table-bordered">
                <thead>
                    <tr>
                    
                        <th>Name</th>
                        <th>Category</th>
                        <th>Date of Event</th>
                  
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $archer)  
                    <tr>
                     
                        <td>{{ $archer->name }}</td>
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
                        <a  href="/editevent/{{$archer->id}}" class='btn btn-success btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Edit Event</span>
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
    $('#manage-table').DataTable({
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