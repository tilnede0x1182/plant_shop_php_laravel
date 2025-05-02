<!DOCTYPE html><html lang="fr"><head>
  <meta charset="utf-8"><title>Plant Shop</title>
  @vite('resources/css/orange.css')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
  @include('layouts._navbar')
  <main class="container my-4">@include('layouts._flash') @yield('content')</main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @vite('resources/js/app.js')
</body></html>
