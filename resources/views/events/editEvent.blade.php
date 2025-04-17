@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
                <h5 class="card-header">Update Event</h5>
                <form class="card-body"  method="POST" action="{{ route('event.updateEvent', ['id' => $event->id]) }}">
                @csrf
                @method('PUT')
                  <h6> Event Details</h6>
                  <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-username">Name</label>
                      <input type="text" id="multicol-username" name="name" value="{{$event->name}}" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-email">Select Event Category</label>
                      <div class="input-group input-group-merge">
                      <select class="form-select" id="exampleFormControlSelect1" name="cat" aria-label="Default select example">
                      <option value="{{ $cat->id }}">{{ $cat->name }} </option>    
                       @foreach ($cats as $dr)                                                 
                       <option value="{{ $dr->id }}">{{ $dr->name }} </option>                                                                                                                  
                       @endforeach
                     </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-password-toggle">
                        <label class="form-label" for="multicol-password">Date of Event</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="date"
                            name="doe" 
                            id="multicol-password"
                            value="{{$event->doe}}" 
                            class="form-control"
                            placeholder=""
                            aria-describedby="multicol-password2" />
                          <span class="input-group-text cursor-pointer" id="multicol-password2"
                            ></span>
                        </div>
                      </div>
                    </div>
            
          
                  <!-- <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-3">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div> -->
                <!-- </form> -->
              </div>
                        
</div>


    <!-- DataTable with Checkboxes -->
    <div class="card">
    <h5 class="card-header">Selected Archers</h5>
    <div class="table-responsive">
        <div class="card-datatable text-nowrap">
            <table class="datatables-basic table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Dob</th>
                        <th>Category</th>
                        <th>Grading</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allarchers as $archer)  
                    <tr>
                        <td>
                        <input type="checkbox" name="selected_archers[]" value="{{ $archer->id }}"
                        {{ $archers->contains('archer_id', $archer->id) ? 'checked' : '' }}>
                        </td> 
                        <td>{{ $archer->name }}</td>
                        <td>{{ $archer->surname }}</td>
                        <td>{{ $archer->dob }}</td>
                        <td>{{ $archer->ageCategory }}</td>
                        <td>{{ $archer->currentGradingDominant }}</td>
                        
                        <td>
                        @foreach($archers as $arch)
                        @if($archer->id == $arch->archer_id)
                        <a  href="/deletearcher/{{$archer->id}}/{{$arch->event_id}}" class='btn btn-danger btn-sm' style='color: white;'>
                      <span class='fa fa-pencil'></span>
                      <span class='hidden-sm hidden-sm hidden-md'>Remove from Event</span>
                   </a>&nbsp;
                        @endif
                        @endforeach
                   </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>
    
    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary mt-3">Update</button>
</form>

<script>
    document.getElementById('select-all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('input[name="selected_archers[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>

              <!--/ DataTable with Buttons -->  
@endsection