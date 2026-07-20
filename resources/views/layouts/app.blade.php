<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts/header')
</head>
<body>

    @include('layouts/navbar')

    <main class="{{ request()->routeIs('home') || request()->routeIs('west-java-corner') ? '' : 'page' }}">
        @yield('content')
    </main>

    @include('layouts/footer')

    @stack('scripts')
</body>
</html>
