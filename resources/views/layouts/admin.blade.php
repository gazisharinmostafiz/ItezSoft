{{-- File: resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'ItezSoft') }} Admin - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-inter bg-gray-100 antialiased">
    <div class="flex h-screen bg-gray-100">
        <aside class="w-64 bg-gray-800 text-gray-100 p-6 space-y-6 hidden md:block">
            <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-semibold hover:text-indigo-300">
                ItezSoft Admin
            </a>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tachometer-alt fa-fw"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.hero-slides.index') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.hero-slides.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-images fa-fw"></i> {{-- Hero Slides icon --}}
                    <span>Hero Slides</span>
                </a>
                <a href="{{ route('admin.posts.index') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.posts.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-file-alt fa-fw"></i>
                    <span>Blog Posts</span>
                </a>
                <a href="{{ route('admin.pages.index') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.pages.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-file-invoice fa-fw"></i>
                    <span>Manage Pages</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-users fa-fw"></i>
                    <span>Manage Users</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-cog fa-fw"></i>
                    <span>Site Settings</span>
                </a>
                <!-- Example for other links:
                <a href="#" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700">
                    <i class="fas fa-briefcase fa-fw"></i>
                    <span>Job Listings</span>
                </a>
                -->

                <!--
                <form method="POST" action="{{-- {{ route('logout') }} --}}#">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700">
                        <i class="fas fa-sign-out-alt fa-fw"></i>
                        <span>Logout</span>
                    </a>
                </form>
                -->
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <div>
                    <button id="admin-mobile-menu-button" class="text-gray-600 md:hidden">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-700">@yield('title', 'Admin Panel')</h1>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Welcome, {{ Auth::user()?->name ?? 'Admin' }}!</span>
                    <!--
                    <a href="#" class="ml-4 text-sm text-indigo-600 hover:underline"
                       onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                        Logout
                    </a>
                    <form id="logout-form-header" action="{{-- {{ route('logout') }} --}}#" method="POST" style="display: none;">
                        @csrf
                    </form>
                    -->
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="container mx-auto">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md shadow" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md shadow" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- Mobile Sidebar (hidden by default, toggled by JS) --}}
    <div id="admin-mobile-sidebar" class="fixed inset-0 flex z-40 md:hidden transform -translate-x-full transition-transform duration-300 ease-in-out">
        <aside class="w-64 bg-gray-800 text-gray-100 p-6 space-y-6">
             <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-semibold hover:text-indigo-300">
                ItezSoft Admin
            </a>
             <nav class="space-y-2 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tachometer-alt fa-fw"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.hero-slides.index') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.hero-slides.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-images fa-fw"></i>
                    <span>Hero Slides</span>
                </a>
                <a href="{{ route('admin.posts.index') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.posts.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-file-alt fa-fw"></i>
                    <span>Blog Posts</span>
                </a>
                <a href="{{ route('admin.pages.index') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.pages.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-file-invoice fa-fw"></i>
                    <span>Manage Pages</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-users fa-fw"></i>
                    <span>Manage Users</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-2 px-4 py-2.5 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-cog fa-fw"></i>
                    <span>Site Settings</span>
                </a>
            </nav>
        </aside>
        <div id="admin-mobile-overlay" class="flex-1 bg-black opacity-50"></div>
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const adminMobileMenuButton = document.getElementById('admin-mobile-menu-button');
            const adminMobileSidebar = document.getElementById('admin-mobile-sidebar');
            const adminMobileOverlay = document.getElementById('admin-mobile-overlay');

            if (adminMobileMenuButton && adminMobileSidebar) {
                adminMobileMenuButton.addEventListener('click', function () {
                    adminMobileSidebar.classList.toggle('-translate-x-full');
                });
            }
            if (adminMobileOverlay && adminMobileSidebar) {
                 adminMobileOverlay.addEventListener('click', function () {
                    adminMobileSidebar.classList.add('-translate-x-full');
                });
            }
        });
    </script>
</body>
</html>
