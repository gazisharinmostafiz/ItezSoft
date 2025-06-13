{{-- File: resources/views/contact.blade.php --}}
@extends('layouts.app')

@section('title', 'Contact Us - ' . ($globalSiteName ?? config('app.name', 'ItezSoft')))

@section('content')
<div class="bg-gray-50 py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">
                Get In Touch
            </h1>
            <p class="mt-4 text-xl text-gray-600">
                We'd love to hear from you! Whether you have a question about our services, pricing, or anything else, our team is ready to answer all your questions.
            </p>
        </div>

        <div class="max-w-xl mx-auto bg-white p-8 md:p-10 rounded-xl shadow-lg">
            {{-- You can add a contact form here later --}}
            <div class="space-y-6">
                @if ($globalContactEmail)
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-envelope fa-fw mr-3 text-indigo-600"></i> Email Us
                    </h3>
                    <a href="mailto:{{ $globalContactEmail }}" class="text-indigo-600 hover:text-indigo-800 hover:underline">{{ $globalContactEmail }}</a>
                </div>
                @endif

                @if ($globalContactPhone)
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-phone fa-fw mr-3 text-indigo-600"></i> Call Us
                    </h3>
                    <a href="tel:{{ $globalContactPhone }}" class="text-indigo-600 hover:text-indigo-800 hover:underline">{{ $globalContactPhone }}</a>
                </div>
                @endif

                {{-- Placeholder for address or map if needed --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-map-marker-alt fa-fw mr-3 text-indigo-600"></i> Our Location
                    </h3>
                    <p class="text-gray-700">Ilford, London, United Kingdom (Further address details can be added here or managed via settings)</p>
                </div>

                {{-- Social Media Links (Copied from footer logic for consistency) --}}
                @if ($globalSocialFacebookUrl || $globalSocialTwitterUrl || $globalSocialLinkedinUrl || $globalSocialInstagramUrl)
                <div class="pt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Follow Us</h3>
                    <div class="flex space-x-4">
                        @if ($globalSocialFacebookUrl)
                            <a href="{{ $globalSocialFacebookUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-indigo-600 transition-colors" title="Facebook">
                                <i class="fab fa-facebook-f fa-2x"></i>
                            </a>
                        @endif
                        @if ($globalSocialTwitterUrl)
                            <a href="{{ $globalSocialTwitterUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-indigo-600 transition-colors" title="Twitter / X">
                                <i class="fab fa-twitter fa-2x"></i>
                            </a>
                        @endif
                        @if ($globalSocialLinkedinUrl)
                            <a href="{{ $globalSocialLinkedinUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-indigo-600 transition-colors" title="LinkedIn">
                                <i class="fab fa-linkedin-in fa-2x"></i>
                            </a>
                        @endif
                        @if ($globalSocialInstagramUrl)
                            <a href="{{ $globalSocialInstagramUrl }}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-indigo-600 transition-colors" title="Instagram">
                                <i class="fab fa-instagram fa-2x"></i>
                            </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        {{-- You can later convert this page's primary textual content to be managed by the dynamic "Pages" system --}}
    </div>
</div>
@endsection