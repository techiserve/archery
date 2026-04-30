@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <h5 class="card-header">All Archers</h5>

        <div class="px-4 pb-3">
            <form method="GET" action="{{ url()->current() }}">
                <div class="row g-3 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Institute</label>
                        <select name="institute" class="form-select form-select-sm">
                            <option value="">All Institutes</option>
                            @foreach($institutes as $institute)
                                <option value="{{ $institute }}" {{ request('institute') == $institute ? 'selected' : '' }}>
                                    {{ $institute }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Age Category</label>
                        <select name="ageCategory" class="form-select form-select-sm">
                            <option value="">All Ages</option>
                            <option value="Cub" {{ request('ageCategory') == 'Cub' ? 'selected' : '' }}>Cub</option>
                            <option value="Junior" {{ request('ageCategory') == 'Junior' ? 'selected' : '' }}>Junior</option>
                            <option value="Adult" {{ request('ageCategory') == 'Adult' ? 'selected' : '' }}>Adult</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-sm me-2">
                            <i class="fa fa-filter"></i> Filter
                        </button>

                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>

        <div class="card-datatable text-nowrap px-3 pb-3">
            <div class="table-responsive">
                <table id="archers-table" class="table table-bordered table-hover align-middle">
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
                        @foreach ($all as $pple)
                            <tr>
                                <td></td>
                                <td>{{ $pple->name }}</td>
                                <td>{{ $pple->surname }}</td>
                                <td>{{ $pple->generatedId }}</td>
                                <td>{{ $pple->dob }}</td>
                                <td>{{ $pple->ageCategory }}</td>
                                <td>{{ $pple->currentGradingDominant }}</td>
                                <td>
                                    <a href="/viewmore/{{ $pple->id }}" class="btn btn-success btn-sm" style="color: white;">
                                        <span class="fa fa-eye"></span>
                                        View More
                                    </a>

                                    <a href="/archer/edit/{{ $pple->id }}" class="btn btn-info btn-sm" style="color: white;">
                                        <span class="fa fa-pencil"></span>
                                        Edit Archer
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        dom:
            "<'row px-2 mb-3 align-items-center'<'col-md-6'B><'col-md-6 d-flex justify-content-end'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row px-2 mt-3 align-items-center'<'col-md-5'i><'col-md-7 d-flex justify-content-end'p>>",
        buttons: ['copy', 'csv', 'excel', 'print'],
        language: {
            search: "",
            searchPlaceholder: "Search archers..."
        }
    });
});
</script>

<style>
    .card {
        border-radius: 10px;
    }

    .card-header {
        font-weight: 600;
        padding-bottom: 0.75rem;
    }

    .card-datatable {
        padding-bottom: 1rem;
    }

    #archers-table {
        border-radius: 8px;
        overflow: hidden;
    }

    #archers-table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        vertical-align: middle;
    }

    #archers-table tbody td {
        vertical-align: middle;
    }

    div.dataTables_filter {
        padding-right: 8px;
    }

    div.dataTables_filter input {
        margin-left: 10px;
        min-width: 260px;
        border-radius: 6px;
        padding: 6px 10px;
    }

    div.dt-buttons {
        margin-left: 4px;
    }

    .dt-button {
        border-radius: 6px !important;
        margin-right: 4px;
    }

    .dataTables_wrapper {
        padding: 0 6px;
    }

    .form-select-sm {
        border-radius: 6px;
    }

    .btn-sm {
        border-radius: 6px;
    }
</style>