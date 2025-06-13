{{-- File: resources/views/services/graphics.blade.php --}}
@extends('layouts.app')

@section('title', 'Graphics Design Services - ' . ($globalSiteName ?? config('app.name', 'ItezSoft')))

@section('content')
<div class="bg-gray-50 py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <header class="mb-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">
                    Graphics Design Services
                </h1>
                <p class="mt-4 text-xl text-gray-600">
                    Crafting Visual Identities That Speak Volumes.
                </p>
            </header>

            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed bg-white p-8 rounded-xl shadow-lg">
                <p>At ItezSoft, our graphics design services are tailored to help your brand make a memorable impact. We believe that great design is not just about aesthetics but also about clear communication and achieving business objectives.</p>

                <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">What We Offer:</h2>
                <ul>
                    <li>Logo Design & Brand Identity</li>
                    <li>Marketing Materials (Brochures, Flyers, Business Cards)</li>
                    <li>Digital Graphics (Social Media Posts, Web Banners)</li>
                    <li>User Interface (UI) & User Experience (UX) Design for applications</li>
                    <li>Illustrations and Infographics</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Our Approach</h2>
                <p>We work closely with you to understand your vision, target audience, and brand values. Our creative process involves research, conceptualization, design, and refinement, ensuring the final product aligns perfectly with your needs.</p>

                <div class="mt-10 text-center">
                    <a href="{{ route('contact') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg text-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                        Discuss Your Design Project
                    </a>
                </div>
                {{-- You can later convert this page's content to be managed by the dynamic "Pages" system --}}
            </div>
        </div>
    </div>
</div>
@endsection