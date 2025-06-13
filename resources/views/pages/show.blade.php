{{-- File: resources/views/pages/show.blade.php --}}
@extends('layouts.app') {{-- Use your main frontend layout --}}

{{-- Set the page title to the page's meta_title or its actual title --}}
@section('title', $page->meta_title ?? $page->title)

{{-- Set the meta description if provided --}}
@if($page->meta_description)
    @section('meta_description', $page->meta_description)
@endif

@push('styles')
    {{-- If you use Tailwind Typography for styling the page content --}}
    {{-- You might need to install it: npm install -D @tailwindcss/typography --}}
    {{-- And add it to your tailwind.config.js plugins: plugins: [require('@tailwindcss/typography')], --}}
    <style>
        .prose img { /* Basic responsive image styling within prose content */
            max-width: 100%;
            height: auto;
            border-radius: 0.375rem; /* rounded-md */
            margin-top: 1em;
            margin-bottom: 1em;
        }
        /* Add any other page-specific styles here */
    </style>
@endpush

@section('content')
<div class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <article class="max-w-3xl mx-auto"> {{-- Adjust max-width as needed --}}
            <header class="mb-8">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                    {{ $page->title }}
                </h1>
                <p class="mt-2 text-sm text-gray-500">
                    Last updated: {{ $page->updated_at->format('F j, Y') }}
                </p>
            </header>

            {{--
                For HTML content from Quill (or any WYSIWYG that outputs HTML), use {!! !!}.
                IMPORTANT: Ensure this content is properly sanitized if it can come from
                less trusted sources or if users can input arbitrary HTML/scripts.
                For admin-generated content, the risk is lower but still present.
                Using Tailwind Typography plugin's 'prose' class provides nice default styling.
            --}}
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! $page->content !!}
            </div>

            {{-- Optional: Back to Home or other relevant link --}}
            <div class="mt-12 pt-8 border-t">
                <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    &larr; Back to Home
                </a>
                {{-- Or link to a parent page if applicable, or a sitemap --}}
            </div>
        </article>
    </div>
</div>
@endsection
