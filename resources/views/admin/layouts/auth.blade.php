<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name').' - Admin')</title>

  {{-- SB Admin 2 assets --}}
  <link href="/adm/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="/adm/css/sb-admin-2.min.css" rel="stylesheet">

  <style>
    .bg-gradient-admin {
      background: linear-gradient(135deg, #1d4ed8 0%, #0ea5e9 100%);
      min-height: 100vh;
      display: flex; align-items: center;
    }
    .brand-badge {
      width: 56px; height: 56px;
      display: inline-flex; align-items: center; justify-content: center;
      border-radius: 12px; color: #fff; background: #2563eb;
      box-shadow: 0 8px 20px rgba(37, 99, 235, .35);
      font-weight: 700; letter-spacing: .5px;
    }
  </style>

  @stack('head')
</head>
<body class="bg-gradient-admin">

  <div class="container">
    @yield('content')
  </div>

  {{-- SB Admin 2 scripts --}}
  <script src="/adm/vendor/jquery/jquery.min.js"></script>
  <script src="/adm/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/adm/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="/adm/js/sb-admin-2.min.js"></script>
  @stack('scripts')
</body>
</html>
