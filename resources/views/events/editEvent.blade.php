@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

<form method="POST" action="{{ route('event.updateEvent', ['id' => $event->id]) }}">
    @csrf
    @method('PUT')

    <div class="card mb-6">
        <h5 class="card-header">Update Event</h5>

        <div class="card-body">
            <h6>Event Details</h6>

            <div class="row g-6">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ $event->name }}" class="form-control" />
                </div>

                <div class="col-md-6">
                    <label class="form-label">Select Event Category</label>
                    <select class="form-select" name="cat">
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @foreach ($cats as $dr)
                            <option value="{{ $dr->id }}">{{ $dr->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date of Event</label>
                    <input type="date" name="doe" value="{{ $event->doe }}" class="form-control" />
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">Selected Archers</h5>

        <div class="card-datatable text-nowrap">
            <div class="table-responsive">
                <table id="manage-table" class="table table-bordered">
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
                                    <input 
                                        type="checkbox" 
                                        name="selected_archers[]" 
                                        value="{{ $archer->id }}"
                                        {{ $archers->contains('archer_id', $archer->id) ? 'checked' : '' }}
                                    >
                                </td>

                                <td>{{ $archer->name }}</td>
                                <td>{{ $archer->surname }}</td>
                                <td>{{ $archer->dob }}</td>
                                <td>{{ $archer->ageCategory }}</td>
                                <td>{{ $archer->currentGradingDominant }}</td>

                                <td>
                                    @foreach($archers as $arch)
                                        @if($archer->id == $arch->archer_id)
                                            <a href="/deletearcher/{{ $archer->id }}/{{ $arch->event_id }}" class="btn btn-danger btn-sm" style="color: white;">
                                                Remove from Event
                                            </a>
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

    <button type="submit" class="btn btn-primary mt-3">Update</button>
</form>
<script>
document.addEventListener("DOMContentLoaded", function() {

    // Get selected archers directly from Laravel/PHP
    let selectedArchers = new Set(@json($archers->pluck('archer_id')->map(fn($id) => (string) $id)->values()));

    const table = $('#manage-table').DataTable({
        responsive: true,
        pageLength: 40,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'print'],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        },
        columnDefs: [
            { targets: 0, orderable: false }
        ]
    });

    // Apply checked state to current DataTables page
    function refreshCheckboxes() {
        $('#manage-table input[type="checkbox"][name="selected_archers[]"]').each(function() {
            this.checked = selectedArchers.has(String(this.value));
        });
    }

    refreshCheckboxes();

    table.on('draw', function() {
        refreshCheckboxes();
    });

    $('#manage-table').on('change', 'input[name="selected_archers[]"]', function() {
        const archerId = String(this.value);

        if (this.checked) {
            selectedArchers.add(archerId);
        } else {
            selectedArchers.delete(archerId);
        }
    });

    $('#select-all').on('change', function() {
        const checked = this.checked;

        table.rows({ search: 'applied' }).every(function() {
            const row = this.node();
            const checkbox = $(row).find('input[name="selected_archers[]"]');

            if (checkbox.length) {
                const archerId = String(checkbox.val());

                checkbox.prop('checked', checked);

                if (checked) {
                    selectedArchers.add(archerId);
                } else {
                    selectedArchers.delete(archerId);
                }
            }
        });

        refreshCheckboxes();
    });

    $('form').on('submit', function() {
        $('input[name="selected_archers[]"]').removeAttr('name');

        selectedArchers.forEach(function(archerId) {
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'selected_archers[]')
                .val(archerId)
                .appendTo('form');
        });
    });
});
</script>

@endsection