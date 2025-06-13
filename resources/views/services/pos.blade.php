@extends('layouts.app')

@section('title', 'POS Solutions - ' . ($globalSiteName ?? config('app.name', 'ItezSoft')))

@section('content')
<div class="bg-gray-50 py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <header class="mb-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">
                    Point of Sale (POS) Solutions
                </h1>
                <p class="mt-4 text-xl text-gray-600">
                    Streamlining Your Business Operations with Advanced POS Systems.
                </p>
            </header>

            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed bg-white p-8 rounded-xl shadow-lg">
                <p>ItezSoft offers robust and scalable Point of Sale (POS) solutions designed to meet the unique needs of retail businesses, restaurants, and service providers. Our POS systems are built to enhance efficiency, improve customer experience, and provide you with valuable insights into your sales data.</p>
                
                <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Key Features of Our POS Solutions:</h2>
                <ul>
                    <li>Inventory Management</li>
                    <li>Sales Tracking & Reporting</li>
                    <li>Customer Relationship Management (CRM) Integration</li>
                    <li>Payment Processing (including contactless)</li>
                    <li>Multi-store Capabilities</li>
                    <li>User-friendly Interface</li>
                    <li>Hardware Compatibility</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Why Choose Our POS?</h2>
                <p>We understand that every business is different. Our team works with you to customize a POS solution that fits your workflow, helps reduce errors, and allows you to focus on growing your business. From initial setup and training to ongoing support, we're here to ensure your success.</p>
                
                <div class="mt-10 text-center">
                    <a href="{{ route('contact') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg text-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                        Request a POS Demo
                    </a>
                </div>
                {{-- You can later convert this page's content to be managed by the dynamic "Pages" system --}}
            </div>
        </div>
    </div>
</div>
@endsection