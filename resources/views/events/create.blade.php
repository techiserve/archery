@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

  <!-- ✅ Form now wraps EVERYTHING -->
  <form method="POST" action="{{ route('event.eventStore') }}">
    @csrf

    <div class="card mb-6">
      <h5 class="card-header">Create Event</h5>
      <div class="card-body">
        <h6> Event Details</h6>
        <div class="row g-6">
          <div class="col-md-6">
            <label class="form-label" for="multicol-username">Name</label>
            <input type="text" id="multicol-username" name="name" class="form-control" placeholder="John Doe" />
          </div>

          <div class="col-md-6">
            <label class="form-label" for="exampleFormControlSelect1">Select Event Category</label>
            <div class="input-group input-group-merge">
              <select class="form-select" id="exampleFormControlSelect1" name="cat" aria-label="Default select example">
                @foreach ($cat as $dr)
                  <option value="{{ $dr->id }}">{{ $dr->name }}</option>
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
                  class="form-control"
                  placeholder=""
                  aria-describedby="multicol-password2" />
                <span class="input-group-text cursor-pointer" id="multicol-password2"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- DataTable with Checkboxes -->
    <div class="card">
      <div class="card-datatable text-nowrap">
        <div class="table-responsive">
          <table id="manage-table" class="table table-bordered">
            <thead>
              <tr>
                <th><input type="checkbox" id="select-all"></th>
                <th>Name</th>
                <th>Surname</th>
                <th>Category</th>
                <th>Grading</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($archers as $archer)
              <tr>
                <td>
                  <input type="checkbox" name="selected_archers[]" value="{{ $archer->id }}">
                </td>
                <td>{{ $archer->name }}</td>
                <td>{{ $archer->surname }}</td>
                <td>{{ $archer->ageCategory }}</td>
                <td>{{ $archer->currentGradingDominant }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary mt-3">Save</button>
  </form>

</div>
@endsection

<script>
  // Use delegation so it survives DataTables redraws
  document.addEventListener('change', function(e) {
    if (e.target && e.target.id === 'select-all') {
      document.querySelectorAll('input[name="selected_archers[]"]').forEach(cb => cb.checked = e.target.checked);
    }
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    $('#manage-table').DataTable({
      responsive: true,
      pageLength: 40,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'print'],
      language: { search: "_INPUT_", searchPlaceholder: "Search..." },
      columnDefs: [{ targets: 0, orderable: false }]
    });
  });
</script>
