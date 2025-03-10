
<!doctype html>

<html
  lang="en"
  class="layout-wide customizer-hide"
  dir="ltr"
  data-skin="default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-no-customizer"
  data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Demo: Login Basic - Pages | Sneat - Bootstrap Dashboard PRO</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

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

<link rel="stylesheet"   href="{!! asset('assets/vendor/fonts/flag-icons.css') !!}"/>
<link rel="stylesheet"   href="{!! asset('assets/vendor/libs/apex-charts/apex-charts.css') !!}"/>

<link rel="stylesheet" href="{!! asset('assets/vendor/libs/pickr/pickr-themes.css') !!}" />

<link rel="stylesheet"  href="{!! asset('assets/vendor/css/core.css') !!}"  />
<link rel="stylesheet"  href="{!! asset('assets/css/demo.css') !!}" />

    <!-- Vendor -->
    <link rel="stylesheet"  href="{!! asset('assets/vendor/libs/@form-validation/form-validation.css') !!}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet"  href="{!! asset('assets/vendor/css/pages/page-auth.css') !!}" />

<!-- Vendors CSS -->

<link rel="stylesheet"  href="{!! asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') !!}" />

<!-- endbuild -->

<!-- Page CSS -->

<!-- Helpers -->
<script  src="{!! asset('assets/vendor/js/helpers.js') !!}"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<script  src="{!! asset('assets/vendor/js/template-customizer.js') !!}"></script>

<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

<script src="{!! asset('assets/js/config.js') !!}"></script>
  </head>

  <body>
  <!-- Content -->
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Login -->
        <div class="card px-sm-6 px-0">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  <span class="text-primary">
                    <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <defs>
                        <path
                          d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                          id="path-1"></path>
                      </defs>
                      <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                          <g id="Icon" transform="translate(27.000000, 15.000000)">
                            <g id="Mask" transform="translate(0.000000, 8.000000)">
                              <use fill="currentColor" xlink:href="#path-1"></use>
                            </g>
                          </g>
                        </g>
                      </g>
                    </svg>
                  </span>
                </span>
                <span class="app-brand-text demo text-heading fw-bold">Sneat</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1">Welcome to Sneat! 👋</h4>
            <p class="mb-6">Please sign-in to your account and start the adventure</p>

            <form id="formAuthentication" class="mb-6" action="{{ route('login') }}" method="POST">
              @csrf
              <div class="mb-6 form-control-validation">
                <label for="email" class="form-label">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="Enter your email"
                  value="{{ old('email') }}"
                  required autofocus />
              </div>
              <div class="mb-6 form-password-toggle form-control-validation">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    required />
                </div>
              </div>
              <div class="mb-7">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                  <a href="{{ route('password.request') }}">
                    <span>Forgot Password?</span>
                  </a>
                </div>
              </div>
              <div class="mb-6">
                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
              </div>
            </form>

            <p class="text-center">
              <span>New on our platform?</span>
              <a href="{{ route('register') }}">
                <span>Create an account</span>
              </a>
            </p>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>
  </div>


    <!-- / Content -->

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

<!-- endbuild -->
<script   src="{!! asset('assets/vendor/libs/i18n/i18n.js') !!}"></script>
<!-- Vendors JS -->

<!-- Main JS -->

<script   src="{!! asset('assets/js/main.js') !!}"></script>


<script   src="{!! asset('assets/vendor/libs/@form-validation/popular.js') !!}"></script>
    <script  src="{!! asset('assets/vendor/libs/@form-validation/bootstrap5.js') !!}"></script>
    <script   src="{!! asset('assets/vendor/libs/@form-validation/auto-focus.js') !!}"></script>

  

    <!-- Page JS -->
    <script  src="{!! asset('assets/js/pages-auth.js') !!}"></script>

  </body>
</html>
