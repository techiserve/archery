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
  </body>
</html>
