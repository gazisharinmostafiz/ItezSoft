<header x-data="{ mobileMenuOpen: false, servicesOpen: false }" class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center text-indigo-600 hover:text-indigo-700">
                    @if ($globalSiteLogo)
                        <img src="{{ Storage::url($globalSiteLogo) }}" alt="{{ $globalSiteName ?? config('app.name') }} Logo" class="h-10 w-auto mr-3"> {{-- Adjust h-10 as needed --}}
                    @else
                        <span class="text-2xl font-bold">{{ $globalSiteName ?? config('app.name', 'itezsoft.com') }}</span>
                    @endif
                </a>
            </div>

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

                @auth
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="ms-3 relative">
                            <x-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->currentTeam?->name }}
                                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="w-60">
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Team') }}
                                        </div>
                                        @if (Auth::user()->currentTeam)
                                        <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                            {{ __('Team Settings') }}
                                        </x-dropdown-link>
                                        @endif
                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-dropdown-link href="{{ route('teams.create') }}">
                                                {{ __('Create New Team') }}
                                            </x-dropdown-link>
                                        @endcan
                                        @if (Auth::user()->allTeams()->count() > 1)
                                            <div class="border-t border-gray-200"></div>
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Switch Teams') }}
                                            </div>
                                            @foreach (Auth::user()->allTeams() as $team)
                                                <x-switchable-team :team="$team" />
                                            @endforeach
                                        @endif
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}
                                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>
                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>
                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                @if (Auth::user()->is_admin ?? false)
                                    <x-dropdown-link href="{{ route('admin.dashboard') }}">
                                        {{ __('Admin Panel') }}
                                    </x-dropdown-link>
                                @endif
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif
                                <div class="border-t border-gray-200"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                             @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md shadow-sm">Register</a>
                    @endif
                @endauth
            </nav>

            <div class="md:hidden flex items-center">
                @auth
                    <div class="ms-3 relative">
                         <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-1 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            <i class="fas fa-user-circle text-xl"></i>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>
                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ Auth::user()->name }}
                                </div>
                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                @if (Auth::user()->is_admin ?? false)
                                    <x-dropdown-link href="{{ route('admin.dashboard') }}">
                                        {{ __('Admin Panel') }}
                                    </x-dropdown-link>
                                @endif
                                <div class="border-t border-gray-200"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                             @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth
                <button @click="mobileMenuOpen = !mobileMenuOpen" id="mobile-menu-button" class="text-gray-600 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 p-2 rounded-md ml-3">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform -translate-x-full"
         class="md:hidden bg-white shadow-lg absolute w-full z-40">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">Home</a>
            <div x-data="{ servicesOpen: false }">
                <button @click="servicesOpen = !servicesOpen" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 flex justify-between items-center">
                    <span>Services</span>
                    <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-200" :class="{'rotate-180': servicesOpen}"></i>
                </button>
                <div x-show="servicesOpen" class="pl-4 mt-1 space-y-1">
                    <a href="{{ route('services.graphics') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50">Graphics Design</a>
                    <a href="{{ route('services.pos') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50">POS Solutions</a>
                    <a href="{{ route('services.webdesign') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50">Website Design</a>
                    <a href="{{ route('services.digital') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50">Digital Solutions</a>
                </div>
            </div>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">About Us</a>
            <a href="{{ route('blog.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">Blog</a>
            <a href="{{ route('careers.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">Careers</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">Contact Us</a>
            <div class="border-t border-gray-200 pt-3 mt-2">
            @guest
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block mt-1 px-3 py-2 rounded-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Register</a>
                @endif
            @endguest
            </div>
        </div>
    </div>
</header>