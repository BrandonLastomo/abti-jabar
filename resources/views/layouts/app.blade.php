<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts/header')
</head>
<body>

    @include('layouts/navbar')

    @php
        $fullWidthPages = ['home', 'about-us', 'west-java-corner', 'event', 'database', 'education', 'profile', 'gallery', 'archives'];
        $isFullWidth = in_array(request()->route()?->getName(), $fullWidthPages);
    @endphp
    <main class="{{ $isFullWidth ? '' : 'page' }}">
        @yield('content')
    </main>

    @include('layouts/footer')

    @stack('scripts')
</body>
</html>
