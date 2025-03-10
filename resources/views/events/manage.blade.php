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
                    <tr  >
                        <th></th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Date of Event</th>
                  
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archers as $archer)  
                    <tr  onclick="window.location='{{ route('events.showEvent', $archer->id) }}'" style="cursor:pointer;">
                        <td>
                        
                        </td> 
                        <td>{{ $archer->name }}</td>
                        <td>{{ $archer->cat }}</td>
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