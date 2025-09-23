@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">

    <div class="card">
      <div class="card-datatable text-nowrap">
        {{-- Header with right-aligned action buttons --}}
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
          <h5 class="mb-0">
            Event: {{ $event->name }} | Category: {{ $catname }} | Date: {{ $event->doe }}
          </h5>

          <div class="ms-auto">
            <div class="btn-group" role="group" aria-label="Event actions">
              {{-- Use your actual endpoints or swap to route() helpers --}}
              <a href="/events/{{ $event->id }}/rawscores"
                 class="btn btn-outline-primary btn-sm">
                Event raw scores
              </a>
              <a href="/events/{{ $event->id }}/scoresummary"
                 class="btn btn-outline-primary btn-sm">
                Event score summary
              </a>
              <a href="/events/{{ $event->id }}/supersummary"
                 class="btn btn-outline-primary btn-sm">
                Super summary
              </a>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table id="archers-table" class="table table-bordered">
            <thead>
              <tr>
                <th>.</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Score</th>
                <th>Age Category</th>
                <th>Latest Round</th>
                <th>No of Xs</th>
                <th>Grading</th>
                <th>Grading For</th>
                <th>Current P/R</th>
                <th>Required P/R</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($archers as $archer)
                @php $pple = $pples->firstWhere('id', $archer->archer_id); @endphp
                @if($pple)
                  <tr>
                    <td></td>

                    @if ($archer->status == 1)
                      <td onclick="window.location='{{ route('gradearcher', $archer->id) }}'" style="cursor:pointer;">
                        {{ $pple->name }}
                      </td>
                    @else
                      <td onclick="handleRowClick(event, '{{ $archer->id }}')" style="cursor:pointer;">
                        {{ $pple->name }}
                      </td>
                    @endif

                    <td>{{ $pple->surname }}</td>
                    <td>{{ $archer->totalScore }}</td>
                    <td>{{ $pple->ageCategory }}</td>
                    <td>{{ $archer->timed }}</td>
                    <td>{{ $archer->updatedBy }}</td>
                    <td>{{ $pple->currentGradingDominant }}</td>
                    <td>{{ $pple->gradingfor }}</td>
                    <td>{{ round($archer->thumbring) }}</td>
                    <td>{{ round($archer->arrowinhand) }}</td>
                    <td class="text-center">
                      {{-- Action Buttons --}}
                      @if($archer->status == '1')
                        @if($archer->timed != $category->rounds)
                          <a href="/gradearcher/{{ $archer->id }}" class="btn btn-success btn-sm">Capture Scores</a>&nbsp;
                        @endif
                        <a href="/archer/edit/{{ $archer->archer_id }}" class="btn btn-primary btn-sm">Archer</a>&nbsp;
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $archer->id }}">
                          Edit Scores
                        </button>
                      @else
                        @if($event->status != '1')
                          <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalCenter{{ $archer->id }}">
                            Capture Details
                          </button>
                        @endif
                        <a href="/archer/edit/{{ $archer->archer_id }}" class="btn btn-primary btn-sm">Archer</a>&nbsp;
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $archer->id }}">
                          Edit Scores
                        </button>
                      @endif
                    </td>
                  </tr>

                  {{-- Capture Details Modal (after row) --}}
                  <div class="modal fade" id="modalCenter{{ $archer->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <form class="card-body" method="POST" action="{{ route('event.archerDetails') }}">
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Capture Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row g-6">
                              <div class="col mb-0">
                                <label class="form-label">Arrow Used</label>
                                <input type="text" name="arrowUsed" class="form-control" placeholder="Enter Arrow Used" />
                              </div>
                              <div class="col mb-0">
                                <label class="form-label">Bow Used</label>
                                <input type="text" name="bowUsed" class="form-control" placeholder="Enter Bow Used" />
                              </div>
                            </div>
                          </div>
                          <input type="hidden" name="cat" value="{{ $cat }}">
                          <input type="hidden" name="archer" value="{{ $pple->id }}">
                          <input type="hidden" name="event" value="{{ $archer->event_id }}">
                          <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  {{-- Edit Scores Modal (after row) --}}
                  <div class="modal fade" id="modalEdit{{ $archer->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <form class="card-body" method="POST" action="{{ route('event.editScore') }}">
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Round to Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row g-6">
                              <div class="col mb-0">
                                <select name="round" class="form-select">
                                  @foreach (range(1, $category->rounds) as $i)
                                    <option value="{{ $i }}">Round {{ $i }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <input type="hidden" name="cat" value="{{ $cat }}">
                          <input type="hidden" name="archer" value="{{ $pple->id }}">
                          <input type="hidden" name="event" value="{{ $archer->event_id }}">
                          <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                @endif
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
  function handleRowClick(event, archerId) {
    // Don't do anything if the modal is already open
    const modalEl = document.getElementById(`modalCenter${archerId}`);
    const isAlreadyShown = modalEl && modalEl.classList.contains('show');
    if (isAlreadyShown) return;

    // Prevent modal if clicked on a button or anchor
    if (event.target.closest('button') || event.target.closest('a')) {
      return;
    }

    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  }

  document.addEventListener("DOMContentLoaded", function () {
    $('#archers-table').DataTable({
      responsive: true,
      pageLength: 10,
      ordering: false,
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'print'],
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search ..."
      }
    });
  });
</script>
