<!doctype html>

<html
  lang="en"
  class="layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-skin="default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-starter"
  data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Achery</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{!! asset('assets/img/favicon/favicon.ico') !!}"  />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{!! asset('assets/vendor/fonts/iconify-icons.css') !!}"  />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

<!-- endbuild -->



    <link rel="stylesheet" href="{!! asset('assets/vendor/libs/pickr/pickr-themes.css') !!}" />

    <link rel="stylesheet"  href="{!! asset('assets/vendor/css/core.css') !!}"  />
    <link rel="stylesheet"  href="{!! asset('assets/css/demo.css') !!}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet"  href="{!! asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') !!}" />

    <link rel="stylesheet" href="{!! asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') !!}" />

    <link rel="stylesheet" href="{!! asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/vendor/libs/flatpickr/flatpickr.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/vendor/libs/pickr/pickr-themes.css') !!}" />

<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">

    <!-- endbuild -->
    <link rel="stylesheet"   href="{!! asset('assets/vendor/fonts/flag-icons.css') !!}"/>
    <link rel="stylesheet"   href="{!! asset('assets/vendor/libs/apex-charts/apex-charts.css') !!}"/>
    <!-- Page CSS -->

    <!-- Helpers -->
    
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <!-- <script  src="{!! asset('assets/vendor/js/template-customizer.js') !!}"></script> -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script  src="{!! asset('assets/vendor/js/helpers.js') !!}"></script>

    <script src="{!! asset('assets/js/config.js') !!}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session('success'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success"
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: "Error!",
                text: "{{ session('error') }}",
                icon: "error"
            });
        @endif
    });
</script>
    @stack('styles')
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        @include('template.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          @include('template.navbar')

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            @yield('content')
            <!-- / Content -->

            <!-- Footer -->
            @include('template.footer')
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    @stack('modals')

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js  -->

    <script  src="{!! asset('assets/vendor/libs/jquery/jquery.js') !!}"></script>

    <script  src="{!! asset('assets/vendor/libs/popper/popper.js') !!}"></script>
    <script  src="{!! asset('assets/vendor/js/bootstrap.js') !!}"></script>
    <script  src="{!! asset('assets/vendor/libs/@algolia/autocomplete-js.js') !!}"></script>

    <script  src="{!! asset('assets/vendor/libs/pickr/pickr.js') !!}"></script>

    <script  src="{!! asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') !!}"></script>

    <script  src="{!! asset('assets/vendor/libs/hammer/hammer.js') !!}"></script>

    <script  src="{!! asset('assets/vendor/js/menu.js') !!}"></script>
    <script src="{!! asset('assets/vendor/libs/flatpickr/flatpickr.js') !!}"></script>

    <script  src="{!! asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') !!}"></script>
   

    <script src="{!! asset('assets/vendor/libs/@form-validation/popular.js') !!}"></script>
    <script src="{!! asset('assets/vendor/libs/@form-validation/bootstrap5.js') !!}"></script>
    <script src="{!! asset('assets/vendor/libs/@form-validation/auto-focus.js') !!}"></script>


<!-- jQuery & DataTables JS -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.js') }}"></script>


    <script src="{!! asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') !!}"></script>
    <script src="{!! asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') !!}"></script>
    <script src="{!! asset('assets/js/forms-pickers.js') !!}"></script>



    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script   src="{!! asset('assets/js/main.js') !!}"></script>

    <script   src="{!! asset('assets/js/dashboards-crm.js') !!}"></script>

    <script  src="{!! asset('assets/js/tables-datatables-basic.js') !!}"></script>

    <!-- Page JS -->
    <script>
      (function () {
        let certificateEmailTimer = null;
        const currentBatchUrl = "{{ route('certificate-email-batches.current') }}";
        const statusUrlTemplate = "{{ route('certificate-email-batches.show', ['batch' => '__BATCH__']) }}";
        const dismissUrlTemplate = "{{ route('certificate-email-batches.dismiss', ['batch' => '__BATCH__']) }}";

        function csrfToken() {
          return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        }

        function progressHtml(batch) {
          const total = Number(batch.total || 0);
          const sent = Number(batch.sent || 0);
          const failed = Number(batch.failed || 0);
          const processed = Number(batch.processed || sent + failed);
          const percentage = Number(batch.percentage || 0);

          return `
            <style>
              @keyframes certificateMailFly {
                0% { transform: translateX(-18px) translateY(8px) scale(.84); opacity: 0; }
                20% { opacity: 1; }
                70% { opacity: 1; }
                100% { transform: translateX(238px) translateY(-8px) scale(1.08); opacity: 0; }
              }
              @keyframes certificatePulse {
                0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(14,165,233,.32); }
                50% { transform: scale(1.04); box-shadow: 0 0 0 8px rgba(14,165,233,0); }
              }
              @keyframes certificateStripe {
                from { background-position: 0 0; }
                to { background-position: 36px 0; }
              }
            </style>
            <div style="text-align:left; min-width:280px;">
              <div style="position:relative; height:52px; margin-bottom:10px; border-radius:14px; background:linear-gradient(135deg,#eff6ff,#f0fdf4); overflow:hidden;">
                <div style="position:absolute; left:14px; top:12px; width:32px; height:32px; border-radius:50%; background:#ffffff; color:#0ea5e9; display:flex; align-items:center; justify-content:center; animation:certificatePulse 1.5s ease-in-out infinite;">
                  <i class="fa fa-envelope"></i>
                </div>
                <i class="fa fa-paper-plane" style="position:absolute; left:54px; top:17px; color:#16a34a; animation:certificateMailFly 1.65s linear infinite;"></i>
                <i class="fa fa-paper-plane" style="position:absolute; left:54px; top:17px; color:#0ea5e9; animation:certificateMailFly 1.65s linear .45s infinite;"></i>
                <i class="fa fa-paper-plane" style="position:absolute; left:54px; top:17px; color:#22c55e; animation:certificateMailFly 1.65s linear .9s infinite;"></i>
                <div style="position:absolute; right:14px; top:13px; color:#25324b; font-weight:800;">Sending...</div>
              </div>
              <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <div>
                  <div style="font-weight:700; color:#25324b;">Sending emails to archers</div>
                  <div style="font-size:13px; color:#64748b;">Certificates processed: ${processed} of ${total}</div>
                </div>
                <div style="font-weight:800; color:#16a34a;">${percentage}%</div>
              </div>
              <div style="height:14px; background:#eef2f7; border-radius:999px; overflow:hidden; box-shadow:inset 0 1px 2px rgba(15,23,42,.08);">
                <div style="width:${percentage}%; height:100%; background:linear-gradient(90deg,#0ea5e9,#22c55e), repeating-linear-gradient(45deg,rgba(255,255,255,.28) 0 8px,rgba(255,255,255,0) 8px 16px); background-size:auto,36px 36px; border-radius:999px; transition:width .35s ease; animation:certificateStripe 1s linear infinite;"></div>
              </div>
              <div style="display:flex; gap:8px; margin-top:14px; flex-wrap:wrap;">
                <span style="padding:6px 10px; border-radius:999px; background:#dcfce7; color:#166534; font-weight:700; animation:certificatePulse 1.8s ease-in-out infinite;">Sent: ${sent}</span>
                <span style="padding:6px 10px; border-radius:999px; background:#fee2e2; color:#991b1b; font-weight:700;">Failed: ${failed}</span>
                <span style="padding:6px 10px; border-radius:999px; background:#e0f2fe; color:#075985; font-weight:700;">Total: ${total}</span>
              </div>
            </div>
          `;
        }

        function showProgress(batch) {
          if (!Swal.isVisible()) {
            Swal.fire({
              title: 'Certificate emails',
              html: progressHtml(batch),
              icon: 'info',
              showConfirmButton: false,
              allowOutsideClick: false,
              didOpen: () => Swal.showLoading()
            });

            return;
          }

          Swal.update({
            title: 'Certificate emails',
            html: progressHtml(batch),
            icon: 'info',
            showConfirmButton: false
          });
        }

        async function dismissBatch(batchId) {
          await fetch(dismissUrlTemplate.replace('__BATCH__', batchId), {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'X-CSRF-TOKEN': csrfToken()
            }
          });
        }

        async function showFinished(batch) {
          clearInterval(certificateEmailTimer);
          certificateEmailTimer = null;

          try {
            await dismissBatch(batch.id);
          } catch (error) {
            console.error('Certificate email batch could not be dismissed.', error);
          }

          const failed = Number(batch.failed || 0);
          const sent = Number(batch.sent || 0);
          const total = Number(batch.total || 0);

          Swal.fire({
            title: failed > 0 ? 'Certificates sent with notes' : 'All certificates sent',
            html: `
              <div style="text-align:center;">
                <div style="font-size:34px; font-weight:800; color:${failed > 0 ? '#d97706' : '#16a34a'}; margin-bottom:8px;">
                  ${sent} / ${total}
                </div>
                <div>${sent} certificate email${sent === 1 ? '' : 's'} sent successfully.</div>
                ${failed > 0 ? `<div style="margin-top:8px; color:#b45309;">${failed} could not be sent. Check archer email addresses or mail delivery settings.</div>` : ''}
              </div>
            `,
            icon: failed > 0 ? 'warning' : 'success',
            confirmButtonText: 'Done'
          });
        }

        async function pollCertificateEmailBatch(batchId) {
          const response = await fetch(statusUrlTemplate.replace('__BATCH__', batchId), {
            headers: { 'Accept': 'application/json' }
          });
          const payload = await response.json();
          const batch = payload.batch;

          if (!batch) {
            clearInterval(certificateEmailTimer);
            certificateEmailTimer = null;
            return;
          }

          if (batch.status === 'completed' || batch.status === 'failed') {
            await showFinished(batch);
            return;
          }

          showProgress(batch);
        }

        window.startCertificateEmailTracker = function (batchId, batch) {
          if (certificateEmailTimer) {
            clearInterval(certificateEmailTimer);
          }

          if (batch) {
            showProgress(batch);
          }

          pollCertificateEmailBatch(batchId);
          certificateEmailTimer = setInterval(() => pollCertificateEmailBatch(batchId), 3000);
        };

        document.addEventListener('DOMContentLoaded', async function () {
          try {
            const response = await fetch(currentBatchUrl, {
              headers: { 'Accept': 'application/json' }
            });
            const payload = await response.json();
            const batch = payload.batch;

            if (!batch) {
              return;
            }

            if (batch.status === 'completed' || batch.status === 'failed') {
              await showFinished(batch);
              return;
            }

            window.startCertificateEmailTracker(batch.id, batch);
          } catch (error) {
            console.error('Certificate email tracker failed to start.', error);
          }
        });
      })();
    </script>
    @stack('scripts')
  </body>
</html>
