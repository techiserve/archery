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
                        <th>Surname</th>
                        <th>Dob</th>
                        <th>Category</th>
                        <th>Grading</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archers as $archer)  
                    <tr>
                    @foreach($pples as $pple)
                  @if($archer->archer_id == $pple->id)            
                      
                        <td>{{ $pple->name }}</td>
                        <td>{{ $pple->surname }}</td>
                        <td>{{ $pple->dob }}</td>
                        <td>{{ $pple->ageCategory }}</td>
                        <td>{{ $pple->currentGrading }}</td>
                        <td>     <a  href="/gradearcher/{{$archer->id}}" class='btn btn-success btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>  Grade Archer</span>
                   </a>&nbsp;</td>
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