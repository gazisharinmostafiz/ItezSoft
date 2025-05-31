@extends('layouts.app') {{-- Extend the main layout --}}

@section('title', 'Welcome') {{-- Set the page-specific title --}}

@section('content')
    {{-- Hero Section --}}
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20 md:py-32">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Innovative Digital Solutions for Modern Businesses
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl mb-10 max-w-3xl mx-auto">
                At ItezSoft, we craft cutting-edge software, stunning graphics, and effective web solutions tailored to your success.
            </p>
            <a href="{{-- {{ route('contact') }} --}}#" class="bg-white text-indigo-700 font-semibold py-3 px-10 rounded-lg hover:bg-indigo-100 transition duration-300 text-lg shadow-xl transform hover:scale-105">
                Get Your Free Quote
            </a>
        </div>
    </section>

    {{-- Services Overview Section --}}
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-12">Our Core Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Service Item 1: Graphics Design --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="text-indigo-500 mb-6 text-5xl"><i class="fas fa-paint-brush"></i></div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Graphics Design</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-grow">Creative visuals, logos, and branding that capture attention and tell your story effectively.</p>
                    <a href="{{-- {{ route('services.graphics') }} --}}#" class="mt-auto text-indigo-600 hover:text-indigo-800 font-medium text-sm py-2 px-4 border border-indigo-600 rounded-md hover:bg-indigo-50 transition-colors">Learn More &rarr;</a>
                </div>
                {{-- Service Item 2: POS Solutions --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="text-indigo-500 mb-6 text-5xl"><i class="fas fa-cash-register"></i></div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">POS Solutions</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-grow">Streamlined Point of Sale systems to manage sales, inventory, and customers efficiently.</p>
                    <a href="{{-- {{ route('services.pos') }} --}}#" class="mt-auto text-indigo-600 hover:text-indigo-800 font-medium text-sm py-2 px-4 border border-indigo-600 rounded-md hover:bg-indigo-50 transition-colors">Learn More &rarr;</a>
                </div>
                {{-- Service Item 3: Website Design --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="text-indigo-500 mb-6 text-5xl"><i class="fas fa-laptop-code"></i></div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Website Design</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-grow">Modern, responsive, and SEO-friendly websites that convert visitors into loyal customers.</p>
                    <a href="{{-- {{ route('services.webdesign') }} --}}#" class="mt-auto text-indigo-600 hover:text-indigo-800 font-medium text-sm py-2 px-4 border border-indigo-600 rounded-md hover:bg-indigo-50 transition-colors">Learn More &rarr;</a>
                </div>
                {{-- Service Item 4: Digital Solutions --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="text-indigo-500 mb-6 text-5xl"><i class="fas fa-cogs"></i></div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Digital Solutions</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-grow">Comprehensive digital strategies, custom software development, and expert IT consultancy.</p>
                    <a href="{{-- {{ route('services.digital') }} --}}#" class="mt-auto text-indigo-600 hover:text-indigo-800 font-medium text-sm py-2 px-4 border border-indigo-600 rounded-md hover:bg-indigo-50 transition-colors">Learn More &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action Section --}}
    <section class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Ready to Elevate Your Business?</h2>
            <p class="text-gray-600 mb-8 max-w-xl mx-auto">Let's discuss how ItezSoft can help you achieve your digital goals. Contact us today for a free consultation.</p>
            <a href="{{-- {{ route('contact') }} --}}#" class="bg-purple-600 text-white font-semibold py-3 px-10 rounded-lg hover:bg-purple-700 transition duration-300 text-lg shadow-lg transform hover:scale-105">
                Schedule Consultation
            </a>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    // Ensure this script runs after the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileServicesButton = document.getElementById('mobile-services-button');
        const mobileServicesDropdown = document.getElementById('mobile-services-dropdown');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                // Toggle classes for sliding effect
                if (mobileMenu.classList.contains('-translate-x-full')) {
                    mobileMenu.classList.remove('-translate-x-full');
                    mobileMenu.classList.add('translate-x-0');
                } else {
                    mobileMenu.classList.remove('translate-x-0');
                    mobileMenu.classList.add('-translate-x-full');
                    // Also hide services dropdown if menu is closed
                    if (mobileServicesDropdown && !mobileServicesDropdown.classList.contains('hidden')) {
                        mobileServicesDropdown.classList.add('hidden');
                    }
                }
            });
        }

        if (mobileServicesButton && mobileServicesDropdown) {
            mobileServicesButton.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent click from closing the main mobile menu
                mobileServicesDropdown.classList.toggle('hidden');
            });
        }

        // Optional: Close mobile menu if clicking outside of it
        document.addEventListener('click', (event) => {
            if (mobileMenu && mobileMenuButton) {
                const isClickInsideMenu = mobileMenu.contains(event.target);
                const isClickOnButton = mobileMenuButton.contains(event.target);
                // Also check if the click is inside the services dropdown trigger, if it's part of the menu button logic
                const isClickOnServicesButton = mobileServicesButton ? mobileServicesButton.contains(event.target) : false;


                if (!isClickInsideMenu && !isClickOnButton && !isClickOnServicesButton && mobileMenu.classList.contains('translate-x-0')) {
                    mobileMenu.classList.remove('translate-x-0');
                    mobileMenu.classList.add('-translate-x-full');
                    if (mobileServicesDropdown && !mobileServicesDropdown.classList.contains('hidden')) {
                         mobileServicesDropdown.classList.add('hidden');
                    }
                }
            }
        });
    });
</script>
@endpush
