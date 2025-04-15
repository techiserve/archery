@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
         
            
    <div class="card">
        <div class="card-datatable text-nowrap">
        <div class="table-responsive">
            <table class="datatables-basic table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Rounds</th>
                        <th>Arrows</th>
                  
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $archer)  
                    <tr  onclick="window.location='{{ route('events.showEvent', $archer->id) }}'" style="cursor:pointer;">
                        <td>
                        </td> 
                        <td>{{ $archer->name }}</td>
                        <td>{{ $archer->rounds }}</td>
                        <td>{{ $archer->arrows }}</td>
                    
                        <td>
                        <a  href="/editeventCategory/{{$archer->id}}" class='btn btn-danger btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Delete Category</span>
                   </a>&nbsp;
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