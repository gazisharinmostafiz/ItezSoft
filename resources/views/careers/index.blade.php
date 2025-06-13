{{-- File: resources/views/careers/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Careers - ' . ($globalSiteName ?? config('app.name', 'ItezSoft')))

@section('content')
<div class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 leading-tight">
                Join Our Team
            </h1>
            <p class="mt-4 text-xl text-gray-600">
                We're looking for passionate individuals to help us build the future of digital solutions.
            </p>
        </div>

        {{-- This section will be replaced later with dynamic job listings --}}
        <div class="text-center py-12">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Current Openings</h2>
            <p class="text-gray-600">
                We currently do not have any open positions, but we are always interested in hearing from talented individuals.
                Feel free to send your CV to <a href="mailto:{{ $globalContactEmail ?? 'careers@itezsoft.com' }}" class="text-indigo-600 hover:underline">{{ $globalContactEmail ?? 'careers@itezsoft.com' }}</a>.
            </p>
        </div>
    </div>
</div>
@endsection