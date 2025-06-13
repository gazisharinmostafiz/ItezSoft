{{-- File: resources/views/partials/header.blade.php (Excerpt) --}}
<header x-data="{ mobileMenuOpen: false, servicesOpen: false }" class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center text-indigo-600 hover:text-indigo-700">
                    @if ($globalSiteLogo)
                        <img src="{{ Storage::url($globalSiteLogo) }}" alt="{{ $globalSiteName ?? config('app.name') }} Logo" class="h-10 w-auto mr-3">
                    @else
                        <span class="text-2xl font-bold">{{ $globalSiteName ?? config('app.name', 'itezsoft.com') }}</span>
                    @endif
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-6 lg:space-x-8">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'text-indigo-600 font-semibold border-b-2 border-indigo-500' : '' }}">Home</a>
                <div class="relative group">
                    <button class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium inline-flex items-center {{ request()->is('services*') ? 'text-indigo-600 font-semibold border-b-2 border-indigo-500' : '' }}">
                        Services <i class="fas fa-chevron-down ml-2 text-xs"></i>
                    </button>
                    <div class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 group-hover:opacity-100 transition-opacity duration-200 ease-in-out invisible group-hover:visible z-50">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                            <a href="{{ route('services.graphics') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-md" role="menuitem">Graphics Design</a>
                            <a href="{{ route('services.pos') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-md" role="menuitem">POS Solutions</a>
                            <a href="{{ route('services.webdesign') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-md" role="menuitem">Website Design</a>
                            <a href="{{ route('services.digital') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-md" role="menuitem">Digital Solutions</a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('about') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('about') ? 'text-indigo-600 font-semibold border-b-2 border-indigo-500' : '' }}">About Us</a>
                <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('blog.index') || request()->routeIs('blog.show') ? 'text-indigo-600 font-semibold border-b-2 border-indigo-500' : '' }}">Blog</a>
                <a href="{{ route('careers.index') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('careers.index') ? 'text-indigo-600 font-semibold border-b-2 border-indigo-500' : '' }}">Careers</a>
                <a href="{{ route('contact') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('contact') ? 'text-indigo-600 font-semibold border-b-2 border-indigo-500' : '' }}">Contact Us</a>
                {{-- Authentication links follow --}}
         </nav>
         {{-- ... rest of the header ... --}}
 </header>