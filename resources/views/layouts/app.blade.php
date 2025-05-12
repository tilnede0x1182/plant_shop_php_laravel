<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Plant Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Styles personnalisés -->
    <link href="{{ asset('css/orange.css') }}" rel="stylesheet">
</head>

<body class="bg-light">
    @include('layouts._navbar')
    <main class="container my-4">
        @include('layouts._flash')
        @yield('content')
    </main>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Scripts personnalisés -->
    <script src="{{ asset('js/cart.js') }}" defer></script>
</body>

</html>
