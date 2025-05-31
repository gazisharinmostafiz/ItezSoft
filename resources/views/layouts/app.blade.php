<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Use globalSiteName for the title, fallback to config --}}
    <title>{{ $globalSiteName ?? config('app.name', 'ItezSoft') }} - @yield('title', 'Digital Solutions')</title>

    {{-- Display favicon if you add this setting later --}}
    {{-- @if(isset($globalSiteFavicon) && $globalSiteFavicon)
        <link rel="icon" href="{{ Storage::url($globalSiteFavicon) }}">
    @endif --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        #mobile-menu {
            transition: transform 0.3s ease-out;
        }
    </style>
    @stack('styles')
</head>
<body class="font-inter bg-gray-50 antialiased">

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
    @livewireScripts
</body>
</html>