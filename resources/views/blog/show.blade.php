#
@extends('layouts.app') {{-- Use your main frontend layout --}}

@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? Str::limit(strip_tags($post->content), 160))

@push('styles')
    {{-- If you use Tailwind Typography for styling the post content --}}
    {{-- You might need to install it: npm install -D @tailwindcss/typography --}}
    {{-- And add it to your tailwind.config.js plugins: plugins: [require('@tailwindcss/typography')], --}}
    <style>
        .prose img { /* Basic responsive image styling within prose */
            max-width: 100%;
            height: auto;
            border-radius: 0.375rem; /* rounded-md */
            margin-top: 1em;
            margin-bottom: 1em;
        }
    </style>
@endpush

@section('content')
<div class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <article class="max-w-3xl mx-auto">
            @if ($post->featured_image)
                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto max-h-[500px] object-cover rounded-xl shadow-lg mb-8">
            @endif

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                {{ $post->title }}
            </h1>

            <div class="text-sm text-gray-500 mb-8 border-b pb-4">
                <span>Published on {{ $post->published_at ? $post->published_at->format('F j, Y') : 'N/A' }}</span>
                @if($post->author)
                    <span class="mx-2">&bull;</span>
                    <span>By <a href="#" class="text-indigo-600 hover:underline">{{ $post->author->name }}</a></span>
                @endif
                {{-- Add categories/tags here if you implement them later --}}
            </div>

            {{-- For HTML content from Quill, use {!! !!}. Ensure it's sanitized! --}}
            {{-- Using Tailwind Typography plugin's 'prose' class for nice article styling --}}
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! $post->content !!}
            </div>

            {{-- Optional: Social Share Buttons --}}
            <div class="mt-12 pt-8 border-t">
                <p class="text-sm text-gray-600 mb-2">Share this post:</p>
                {{-- Add your social sharing links/buttons here --}}
                <div class="flex space-x-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" target="_blank" class="text-blue-600 hover:text-blue-800"><i class="fab fa-facebook-square fa-2x"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" class="text-sky-500 hover:text-sky-700"><i class="fab fa-twitter-square fa-2x"></i></a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}" target="_blank" class="text-blue-700 hover:text-blue-900"><i class="fab fa-linkedin fa-2x"></i></a>
                </div>
            </div>

            {{-- Optional: Comments Section --}}
            {{-- <div class="mt-12 pt-8 border-t">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Comments</h3>
                </div> --}}

            <div class="mt-12 pt-8 border-t">
                <a href="{{ route('blog.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    &larr; Back to Blog
                </a>
            </div>

        </article>
    </div>
</div>
@endsection
