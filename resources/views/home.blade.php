{{-- File: resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Welcome to ' . ($globalSiteName ?? config('app.name', 'ItezSoft')))

@push('styles')
<style>
    .hero-slide {
        background-size: cover;
        background-position: center center;
    }
    /* Basic fade transition for Alpine.js slider */
    .alpine-fade-enter-active, .alpine-fade-leave-active {
        transition: opacity 0.7s ease-in-out;
    }
    .alpine-fade-enter-from, .alpine-fade-leave-to {
        opacity: 0;
    }
    .alpine-fade-enter-to, .alpine-fade-leave-from {
        opacity: 1;
    }
</style>
@endpush

@section('content')

    {{-- Hero Slider Section --}}
    @if(isset($heroSlides) && $heroSlides->count() > 0)
        <section
            x-data="{
                currentSlide: 0,
                slides: {{ $heroSlides->count() }},
                autoplay: {{ isset($globalSliderAutoplay) && $globalSliderAutoplay ? 'true' : 'false' }},
                autoplayInterval: {{ $globalSliderDuration ?? 5000 }},
                showDots: {{ isset($globalSliderNavigationDots) && $globalSliderNavigationDots ? 'true' : 'false' }},
                intervalId: null,
                next() {
                    this.currentSlide = (this.currentSlide + 1) % this.slides;
                },
                prev() {
                    this.currentSlide = (this.currentSlide - 1 + this.slides) % this.slides;
                },
                goTo(index) {
                    this.currentSlide = index;
                },
                startAutoplay() {
                    if (this.autoplay && this.slides > 1) {
                        if (this.intervalId) clearInterval(this.intervalId); // Clear existing interval
                        this.intervalId = setInterval(() => {
                            this.next();
                        }, this.autoplayInterval);
                    }
                },
                stopAutoplay() {
                    clearInterval(this.intervalId);
                    this.intervalId = null;
                },
                initSlider() {
                    this.startAutoplay();
                    this.$watch('autoplay', (value) => {
                        this.stopAutoplay(); 
                        if (value) this.startAutoplay(); 
                    });
                    this.$watch('autoplayInterval', (value) => {
                        this.stopAutoplay(); 
                        if (this.autoplay) this.startAutoplay(); 
                    });
                }
            }"
            x-init="initSlider()"
            @mouseenter="stopAutoplay()"
            @mouseleave="startAutoplay()"
            class="relative w-full h-[60vh] md:h-[80vh] lg:h-screen overflow-hidden" {{-- Adjust height as needed --}}
        >
            @foreach($heroSlides as $index => $slide)
                <div
                    x-show="currentSlide === {{ $index }}"
                    x-transition:enter="alpine-fade-enter-active"
                    x-transition:enter-start="alpine-fade-enter-from"
                    x-transition:enter-end="alpine-fade-enter-to"
                    x-transition:leave="alpine-fade-leave-active"
                    x-transition:leave-start="alpine-fade-leave-from"
                    x-transition:leave-end="alpine-fade-leave-to"
                    class="absolute inset-0 w-full h-full hero-slide flex items-center justify-center text-center"
                    style="
                        background-image: {{ $slide->background_image_path ? "url('" . Storage::url($slide->background_image_path) . "')" : "linear-gradient(to right, #6366f1, #8b5cf6)" }}; /* Fallback gradient */
                        color: {{ $slide->text_color ?? '#FFFFFF' }};
                    "
                >
                    <div class="absolute inset-0 bg-black opacity-40"></div> {{-- Overlay for better text readability --}}
                    <div class="relative z-10 p-4 md:p-8 max-w-3xl">
                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 md:mb-6 leading-tight shadow-text"
                            x-intersect.once="document.getElementById('slide-h1-{{$index}}').classList.add('animate-fade-in-up')"
                            id="slide-h1-{{$index}}"
                            style="text-shadow: 1px 1px 3px rgba(0,0,0,0.5);"
                        >
                            {{ $slide->main_headline }}
                        </h1>
                        @if($slide->sub_headline)
                            <p class="text-lg sm:text-xl md:text-2xl mb-6 md:mb-8 opacity-90"
                               x-intersect.once="document.getElementById('slide-p-{{$index}}').classList.add('animate-fade-in-up-delay')"
                               id="slide-p-{{$index}}"
                               style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"
                            >
                                {{ $slide->sub_headline }}
                            </p>
                        @endif
                        @if($slide->button_text && $slide->button_link)
                            <a href="{{ $slide->button_link }}"
                               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg text-lg shadow-lg transform hover:scale-105 transition-transform duration-300"
                               x-intersect.once="document.getElementById('slide-btn-{{$index}}').classList.add('animate-fade-in-up-delay-more')"
                               id="slide-btn-{{$index}}"
                            >
                                {{ $slide->button_text }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach

            {{-- Slider Controls: Previous/Next Buttons --}}
            @if($heroSlides->count() > 1)
                <button @click="prev(); stopAutoplay(); startAutoplay();" class="absolute left-0 top-1/2 transform -translate-y-1/2 z-20 p-2 md:p-4 bg-black bg-opacity-30 hover:bg-opacity-50 text-white rounded-r-md transition-colors">
                    <i class="fas fa-chevron-left fa-lg"></i>
                </button>
                <button @click="next(); stopAutoplay(); startAutoplay();" class="absolute right-0 top-1/2 transform -translate-y-1/2 z-20 p-2 md:p-4 bg-black bg-opacity-30 hover:bg-opacity-50 text-white rounded-l-md transition-colors">
                    <i class="fas fa-chevron-right fa-lg"></i>
                </button>

                {{-- Slider Controls: Dots --}}
                <div x-show="showDots" class="absolute bottom-4 md:bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex space-x-2">
                    @foreach($heroSlides as $index => $slide)
                        <button @click="goTo({{ $index }}); stopAutoplay(); startAutoplay();"
                                :class="{'bg-white': currentSlide === {{ $index }}, 'bg-white/50 hover:bg-white/75': currentSlide !== {{ $index }} }"
                                class="w-3 h-3 rounded-full transition-colors"></button>
                    @endforeach
                </div>
            @endif
        </section>
    @else
        {{-- Fallback if no hero slides are active or if $heroSlides is not set/empty --}}
        <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20 md:py-32">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Welcome to {{ $globalSiteName ?? config('app.name', 'ItezSoft') }}
                </h1>
                <p class="text-lg sm:text-xl md:text-2xl mb-10 max-w-3xl mx-auto">
                    Innovative Digital Solutions for Modern Businesses.
                </p>
                <a href="{{ route('contact') }}" class="bg-white text-indigo-700 font-semibold py-3 px-10 rounded-lg hover:bg-indigo-100 transition duration-300 text-lg shadow-xl transform hover:scale-105">
                    Get In Touch
                </a>
            </div>
        </section>
    @endif

    {{-- The rest of your homepage content (services overview, etc.) --}}
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-12">Our Core Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Graphics Design --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="text-indigo-500 mb-6 text-5xl"><i class="fas fa-paint-brush"></i></div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Graphics Design</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-grow">Creative visuals, logos, and branding that capture attention and tell your story effectively.</p>
                    <a href="{{ route('services.graphics') }}" class="mt-auto text-indigo-600 hover:text-indigo-800 font-medium text-sm py-2 px-4 border border-indigo-600 rounded-md hover:bg-indigo-50 transition-colors">Learn More &rarr;</a>
                </div>
                {{-- POS Solutions --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="text-indigo-500 mb-6 text-5xl"><i class="fas fa-cash-register"></i></div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">POS Solutions</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-grow">Streamlined Point of Sale systems to manage sales, inventory, and customers efficiently.</p>
                    <a href="{{ route('services.pos') }}" class="mt-auto text-indigo-600 hover:text-indigo-800 font-medium text-sm py-2 px-4 border border-indigo-600 rounded-md hover:bg-indigo-50 transition-colors">Learn More &rarr;</a>
                </div>
                {{-- Website Design --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="text-indigo-500 mb-6 text-5xl"><i class="fas fa-laptop-code"></i></div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Website Design</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-grow">Modern, responsive, and SEO-friendly websites that convert visitors into loyal customers.</p>
                    <a href="{{ route('services.webdesign') }}" class="mt-auto text-indigo-600 hover:text-indigo-800 font-medium text-sm py-2 px-4 border border-indigo-600 rounded-md hover:bg-indigo-50 transition-colors">Learn More &rarr;</a>
                </div>
                {{-- Digital Solutions --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col items-center text-center">
                    <div class="text-indigo-500 mb-6 text-5xl"><i class="fas fa-cogs"></i></div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Digital Solutions</h3>
                    <p class="text-gray-600 text-sm mb-6 flex-grow">Comprehensive digital strategies, custom software development, and expert IT consultancy.</p>
                    <a href="{{ route('services.digital') }}" class="mt-auto text-indigo-600 hover:text-indigo-800 font-medium text-sm py-2 px-4 border border-indigo-600 rounded-md hover:bg-indigo-50 transition-colors">Learn More &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Ready to Elevate Your Business?</h2>
            <p class="text-gray-600 mb-8 max-w-xl mx-auto">Let's discuss how ItezSoft can help you achieve your digital goals. Contact us today for a free consultation.</p>
            <a href="{{ route('contact') }}" class="bg-purple-600 text-white font-semibold py-3 px-10 rounded-lg hover:bg-purple-700 transition duration-300 text-lg shadow-lg transform hover:scale-105">
                Schedule Consultation
            </a>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    // Basic animation classes (can be defined in app.css or here)
    const style = document.createElement('style');
    style.innerHTML = `
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }
        .animate-fade-in-up-delay {
            animation: fadeInUp 0.8s ease-out 0.2s forwards;
            opacity: 0;
        }
        .animate-fade-in-up-delay-more {
            animation: fadeInUp 0.8s ease-out 0.4s forwards;
            opacity: 0;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
