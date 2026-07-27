<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex bg-white">
            <!-- Left: Form Side -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 lg:px-24 xl:px-32 pt-28 pb-12 relative min-h-screen">
                <!-- Logo -->
                <div class="absolute top-8 left-8 sm:top-10 sm:left-12 lg:left-16">
                    <a href="/" class="flex items-center gap-2">
                        <img src="{{ asset('img/mainlogo.avif') }}" alt="ABTI JABAR" class="h-8 w-auto">
                        <span class="font-heading font-extrabold text-xl tracking-tight text-gray-900">ABTI JABAR</span>
                    </a>
                </div>

                <div class="w-full max-w-sm mx-auto">
                    {{ $slot }}
                </div>
            </div>

            <!-- Right: Image Side -->
            <div class="hidden lg:flex lg:w-1/2 p-4 sm:p-6">
                <div class="w-full h-full relative rounded-[2rem] overflow-hidden bg-gray-100">
                    <!-- Placeholder image matching the user's sports net picture aesthetic -->
                    <img src={{ asset('storage/auth/handball-net.jpg') }} class="absolute inset-0 w-full h-full object-cover" alt="Handball Net" />
                    <!-- Subtle overlay -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-gray-900/40 to-transparent"></div>
                </div>
            </div>
        </div>
    </body>
</html>
