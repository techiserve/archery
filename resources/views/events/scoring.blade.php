@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  @php $certificateEligibleScoreIds = $certificateEligibleScoreIds ?? collect(); @endphp
  @php $allCertificateEligibleScoreIds = $allCertificateEligibleScoreIds ?? collect(); @endphp

  @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">

    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
      <h5 class="mb-0">
        Event: {{ $event->name }} | Category: {{ $catname }} | Date: {{ $event->doe }}
      </h5>

      <div class="ms-auto">
        <div class="btn-group" role="group">
          <a href="/events/{{ $event->id }}/rawscores" class="btn btn-outline-primary btn-sm">
            Event raw scores
          </a>
          <a href="/events/{{ $event->id }}/scoresummary" class="btn btn-outline-primary btn-sm">
            Event score summary
          </a>
          <a href="/events/{{ $event->id }}/supersummary" class="btn btn-outline-primary btn-sm">
            Super summary
          </a>
        </div>

        @if($allCertificateEligibleScoreIds->isNotEmpty())
          <button
            type="button"
            id="send-all-certificates"
            class="btn btn-success btn-sm ms-2"
            data-url="{{ route('events.certificates.email-all', $event->id) }}"
            data-total="{{ $allCertificateEligibleScoreIds->count() }}">
            <span class="fa fa-envelope"></span>
            Send All Certificates ({{ $allCertificateEligibleScoreIds->count() }})
          </button>
        @endif
      </div>
    </div>

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
                @if($pple->ageCategory != null)
                                 <td>{{ $pple->ageCategory }}</td>       
                                @else
                                  <td>No Age Category</td>       
                                @endif
                          
                  <td>{{ $archer->timed }}</td>
                  <td>{{ $archer->updatedBy }}</td>

                  @if($catname == 'Non Dominant Hand')
                    <td>{{ $pple->currentGradingWeak }}</td>
                  @else
                    <td>{{ $pple->currentGradingDominant }}</td>
                  @endif

                  <td>{{ $pple->gradingfor }}</td>
                  <td>{{ round($archer->thumbring) }}</td>
                  <td>{{ round($archer->arrowinhand) }}</td>

                  <td class="text-center">
                    @if($archer->status == '1')
                      @if($archer->timed != $category->rounds)
                        <a href="/gradearcher/{{ $archer->id }}" class="btn btn-success btn-sm">
                          Capture Scores
                        </a>
                      @endif

                      <a href="/archer/edit/{{ $archer->archer_id }}" class="btn btn-primary btn-sm">
                        Archer
                      </a>

                      <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $archer->id }}">
                        Edit Scores
                      </button>
                    @else
                      @if($event->status != '1')
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalCenter{{ $archer->id }}">
                          Capture Details
                        </button>
                      @endif

                      <a href="/archer/edit/{{ $archer->archer_id }}" class="btn btn-primary btn-sm">
                        Archer
                      </a>

                      <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $archer->id }}">
                        Edit Scores
                      </button>
                    @endif

                    @if($certificateEligibleScoreIds->contains((string) $archer->id))
                      <a href="{{ route('archer.certificate', $archer->id) }}" class="btn btn-warning btn-sm">
                        <span class="fa fa-download"></span>
                        Certificate
                      </a>

                      <form method="POST" action="{{ route('archer.certificate.email', $archer->id) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">
                          <span class="fa fa-envelope"></span>
                          Send Email
                        </button>
                      </form>
                    @endif
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>

</div>
@endsection

@push('modals')
  @foreach ($archers as $archer)
    @php $pple = $pples->firstWhere('id', $archer->archer_id); @endphp

    @if($pple)
      <div class="modal fade scoring-modal" id="modalCenter{{ $archer->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down" role="document">
          <div class="modal-content">
            <form method="POST" action="{{ route('event.archerDetails') }}">
              @csrf

              <div class="modal-header">
                <h5 class="modal-title">Capture Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <div class="modal-body">
                <div class="row g-3">
                  <div class="col-12 col-sm-6">
                    <label class="form-label">Arrow Used</label>
                    <input type="text" name="arrowUsed" class="form-control" placeholder="Enter Arrow Used" />
                  </div>

                  <div class="col-12 col-sm-6">
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
            </form>
          </div>
        </div>
      </div>

      <div class="modal fade scoring-modal" id="modalEdit{{ $archer->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down" role="document">
          <div class="modal-content">
            <form method="POST" action="{{ route('event.editScore') }}">
              @csrf

              <div class="modal-header">
                <h5 class="modal-title">Round to Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <div class="modal-body">
                <div class="row g-3">
                  <div class="col-12">
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
            </form>
          </div>
        </div>
      </div>
    @endif
  @endforeach
@endpush

@push('scripts')
<script>
function handleRowClick(event, archerId) {
  const modalEl = document.getElementById(`modalCenter${archerId}`);

  if (!modalEl) return;

  const isAlreadyShown = modalEl.classList.contains('show');

  if (isAlreadyShown) return;

  if (event.target.closest('button') || event.target.closest('a')) {
    return;
  }

  const modal = new bootstrap.Modal(modalEl);
  modal.show();
}

document.addEventListener("DOMContentLoaded", function () {
  const sendAllButton = document.getElementById('send-all-certificates');

  if (sendAllButton) {
    sendAllButton.addEventListener('click', async function () {
      const total = Number(sendAllButton.dataset.total || 0);
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

      sendAllButton.disabled = true;

      Swal.fire({
        title: 'Sending certificates',
        html: `
          <style>
            @keyframes certificateStartFly {
              0% { transform: translateX(-12px) translateY(7px) scale(.85); opacity: 0; }
              20% { opacity: 1; }
              75% { opacity: 1; }
              100% { transform: translateX(210px) translateY(-7px) scale(1.06); opacity: 0; }
            }
            @keyframes certificateStartPulse {
              0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34,197,94,.32); }
              50% { transform: scale(1.04); box-shadow: 0 0 0 8px rgba(34,197,94,0); }
            }
            @keyframes certificateStartStripe {
              from { background-position: 0 0; }
              to { background-position: 36px 0; }
            }
          </style>
          <div style="text-align:left;">
            <div style="position:relative; height:52px; margin-bottom:12px; border-radius:14px; background:linear-gradient(135deg,#eff6ff,#f0fdf4); overflow:hidden;">
              <div style="position:absolute; left:14px; top:12px; width:32px; height:32px; border-radius:50%; background:#ffffff; color:#16a34a; display:flex; align-items:center; justify-content:center; animation:certificateStartPulse 1.4s ease-in-out infinite;">
                <i class="fa fa-envelope"></i>
              </div>
              <i class="fa fa-paper-plane" style="position:absolute; left:54px; top:17px; color:#16a34a; animation:certificateStartFly 1.6s linear infinite;"></i>
              <i class="fa fa-paper-plane" style="position:absolute; left:54px; top:17px; color:#0ea5e9; animation:certificateStartFly 1.6s linear .45s infinite;"></i>
              <i class="fa fa-paper-plane" style="position:absolute; left:54px; top:17px; color:#22c55e; animation:certificateStartFly 1.6s linear .9s infinite;"></i>
              <div style="position:absolute; right:14px; top:13px; color:#25324b; font-weight:800;">Starting...</div>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
              <span>Preparing certificate emails...</span>
              <strong>0 / ${total}</strong>
            </div>
            <div style="height:12px; background:#eef2f7; border-radius:999px; overflow:hidden;">
              <div style="width:35%; height:100%; background:linear-gradient(90deg,#0ea5e9,#22c55e), repeating-linear-gradient(45deg,rgba(255,255,255,.3) 0 8px,rgba(255,255,255,0) 8px 16px); background-size:auto,36px 36px; border-radius:999px; animation:certificateStartStripe 1s linear infinite;"></div>
            </div>
          </div>
        `,
        icon: 'info',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
      });

      try {
        const response = await fetch(sendAllButton.dataset.url, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
          }
        });
        const payload = await response.json();

        if (!response.ok) {
          throw new Error(payload.message || 'The certificate email batch could not be started.');
        }

        if (window.startCertificateEmailTracker) {
          window.startCertificateEmailTracker(payload.batch.id, payload.batch);
        }
      } catch (error) {
        Swal.fire({
          title: 'Email batch not started',
          text: error.message,
          icon: 'error'
        });
      } finally {
        sendAllButton.disabled = false;
      }
    });
  }

  $('#archers-table').DataTable({
    responsive: true,
    pageLength: 10,
    ordering: false,
    dom:
      "<'row px-3 mb-3 align-items-center'<'col-md-6'B><'col-md-6 d-flex justify-content-end'f>>" +
      "<'row'<'col-md-12'tr>>" +
      "<'row px-3 mt-3 align-items-center'<'col-md-5'i><'col-md-7 d-flex justify-content-end'p>>",
    buttons: ['copy', 'csv', 'excel', 'print'],
    language: {
      search: "",
      searchPlaceholder: "Search event archers..."
    }
  });
});
</script>
@endpush

@push('styles')
<style>
.card {
  border-radius: 10px;
}

.card-header {
  font-weight: 600;
}

.card-datatable {
  padding-bottom: 1rem;
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

.scoring-modal {
  --bs-modal-zindex: 1110;
}

body.modal-open .modal-backdrop {
  --bs-backdrop-zindex: 1109;
}

body.modal-open .layout-overlay {
  display: none !important;
  pointer-events: none;
}
</style>
@endpush
