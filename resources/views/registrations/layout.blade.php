<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Archer Registration') | Qurtuba Furusiyyah</title>
  <link rel="icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/archer-registrations.css') }}">
</head>
<body class="archer-registration-page registration-public">
  <header class="registration-header">
    <div class="registration-width d-flex flex-wrap align-items-center justify-content-between gap-3">
      <a class="registration-brand" href="{{ route('archer-registrations.create') }}">Qurtuba Furusiyyah</a>
      <a class="registration-sign-in" href="{{ route('login') }}">Staff sign in <i class="icon-base bx bx-log-in" aria-hidden="true"></i></a>
    </div>
  </header>
  <main class="registration-width registration-main">
    @yield('content')
  </main>
  @stack('scripts')
</body>
</html>
