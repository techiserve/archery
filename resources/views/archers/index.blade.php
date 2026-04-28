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
        <h5 class="card-header">All Archers</h5>
        <div class="table-responsive">
            <table id="archers-table" class="table table-bordered">
                <thead>
                    <tr>
                      <th></th>
                        <th>Name(s)</th>
                        <th>Surname</th>
                        <th>Id</th>
                        <th>Dob</th>
                        <th>Age Category</th>
                        <th>Grading</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all as $pple )  
                    <tr>
                         <td></td>
                        <td>{{ $pple->name }}</td>
                        <td>{{ $pple->surname }}</td>
                        <td>{{ $pple->generatedId }}</td>
                        <td>{{ $pple->dob }}</td>
                        <td>{{ $pple->ageCategory }}</td>
                        <td>{{ $pple->currentGradingDominant }}</td>
                        <td>     <a  href="/viewmore/{{$pple->id}}" class='btn btn-success btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>View More</span>
                   </a>&nbsp;
                
                   <a  href="/archer/edit/{{$pple->id}}" class='btn btn-info btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Edit Archer</span>
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
<script>
  document.addEventListener("DOMContentLoaded", function() {
    $('#archers-table').DataTable({
      responsive: true,
      pageLength: 40,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'print'],
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search ..."
      }
    });
  });
</script>
