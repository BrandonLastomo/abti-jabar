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
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    @include('layouts/footer')

    @auth
        @include('components.export-modal')
    @endauth

    @stack('scripts')
</body>
</html>
