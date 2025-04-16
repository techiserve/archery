@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
         
            
    <div class="card">
        <div class="card-datatable text-nowrap">
        <h5 class="card-header">All Archers</h5>
        <div class="table-responsive">
            <table id="archers-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Date of Event</th>
                  
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $archer)  
                    <tr  onclick="window.location='{{ route('events.showEvent', $archer->id) }}'" style="cursor:pointer;">
                        <td>
                        
                        </td> 
                        <td>{{ $archer->name }}</td>
                        @foreach($categories as $category)
                        @if($archer->cat == $category->id)
                        <td>{{ $category->name }}</td>
                        @endif
                        @endforeach
                        <td>{{ $archer->doe }}</td>
                    
                        <td><span class="badge bg-label-success"> Graded </span></td>
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
      responsive: true,
      pageLength: 10,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'print'],
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search archers..."
      }
    });
  });
</script>