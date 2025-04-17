@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
         
            
    <div class="card">
        <div class="card-datatable text-nowrap">
        <h5 class="card-header">All Categories</h5>
        <div class="table-responsive">
            <table id="archers-table" class="table table-bordered">
                <thead>
                    <tr>
                   
                        <th>Name</th>
                        <th>Rounds</th>
                        <th>Arrows</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $archer)  
                    <tr>
                       
                        <td>{{ $archer->name }}</td>
                        <td>{{ $archer->rounds }}</td>
                        <td>{{ $archer->arrows }}</td> 
                        <td>
                    @if($archer->name  != 'Grading')
                        <a  href="/editeventCategory/{{$archer->id}}" class='btn btn-danger btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Delete Category</span>
                   </a>&nbsp;
                   @endif
                   </td>
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