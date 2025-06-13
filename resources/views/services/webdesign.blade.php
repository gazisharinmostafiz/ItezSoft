@extends('layouts.app')

@section('title', 'Website Design Services - ' . ($globalSiteName ?? config('app.name', 'ItezSoft')))

@section('content')
<div class="bg-gray-50 py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <header class="mb-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">
                    Website Design & Development
                </h1>
                <p class="mt-4 text-xl text-gray-600">
                    Building Engaging and High-Performing Websites.
                </p>
            </header>

            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed bg-white p-8 rounded-xl shadow-lg">
                <p>Your website is often the first interaction potential customers have with your brand. At ItezSoft, we design and develop websites that are not only visually stunning but also user-friendly, responsive, and optimized for search engines. We create digital experiences that drive engagement and conversions.</p>
                
                <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Our Web Design & Development Services:</h2>
                <ul>
                    <li>Custom Website Design</li>
                    <li>Responsive Web Development (Mobile, Tablet, Desktop)</li>
                    <li>E-commerce Solutions</li>
                    <li>Content Management Systems (CMS) like WordPress, or custom solutions</li>
                    <li>Website Maintenance & Support</li>
                    <li>SEO-Friendly Architecture</li>
                    <li>Performance Optimization</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Our Process</h2>
                <p>We follow a collaborative process, starting with understanding your business goals and target audience. This involves discovery, planning, design mockups, development, rigorous testing, and launch, followed by ongoing support to ensure your website continues to perform optimally.</p>
                
                <div class="mt-10 text-center">
                    <a href="{{ route('contact') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg text-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                        Start Your Web Project
                    </a>
                </div>
                {{-- You can later convert this page's content to be managed by the dynamic "Pages" system --}}
            </div>
        </div>
    </div>
</div>
@endsection