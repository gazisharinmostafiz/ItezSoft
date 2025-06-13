@extends('layouts.app')

@section('title', 'Digital Solutions - ' . ($globalSiteName ?? config('app.name', 'ItezSoft')))

@section('content')
<div class="bg-gray-50 py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <header class="mb-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">
                    Comprehensive Digital Solutions
                </h1>
                <p class="mt-4 text-xl text-gray-600">
                    Your Partner for End-to-End Digital Transformation.
                </p>
            </header>

            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed bg-white p-8 rounded-xl shadow-lg">
                <p>ItezSoft provides a holistic suite of digital solutions designed to address all your online business needs. From initial strategy and software development to digital marketing and ongoing support, we help you navigate the complexities of the digital world and achieve sustainable growth.</p>
                
                <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Our Range of Digital Solutions Includes:</h2>
                <ul>
                    <li>Custom Software Development (Web & Mobile Applications)</li>
                    <li>Digital Strategy & Consultancy</li>
                    <li>Search Engine Optimization (SEO)</li>
                    <li>Social Media Marketing (SMM)</li>
                    <li>Cloud Solutions & Integration</li>
                    <li>Data Analytics & Business Intelligence</li>
                    <li>Ongoing Technical Support & Maintenance</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Why ItezSoft?</h2>
                <p>We focus on understanding your unique challenges and opportunities to deliver tailored solutions that produce measurable results. Our integrated approach ensures all your digital efforts work cohesively to build a stronger brand and drive business success.</p>
                
                <div class="mt-10 text-center">
                    <a href="{{ route('contact') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg text-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                        Discuss Your Digital Needs
                    </a>
                </div>
                {{-- You can later convert this page's content to be managed by the dynamic "Pages" system --}}
            </div>
        </div>
    </div>
</div>
@endsection