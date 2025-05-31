
@extends('layouts.app') {{-- Use your main frontend layout --}}

@section('title', 'Our Blog')

@section('content')
<div class="bg-gray-50 py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-800">
                ItezSoft Blog
            </h1>
            <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                Insights, news, and articles on software development, design, and digital solutions.
            </p>
        </div>

        @if ($posts->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($posts as $post)
                    <article class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col hover:shadow-xl transition-shadow duration-300">
                        @if ($post->featured_image)
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover">
                            </a>
                        @else
                            <a href="{{ route('blog.show', $post->slug) }}" class="block w-full h-56 bg-indigo-500 flex items-center justify-center text-white text-2xl font-semibold">
                                {{ Str::limit($post->title, 20) }}
                            </a>
                        @endif
                        <div class="p-6 flex flex-col flex-grow">
                            <h2 class="text-xl font-semibold text-gray-800 mb-3">
                                <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-indigo-600 transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <div class="text-sm text-gray-500 mb-3">
                                <span>Published on {{ $post->published_at ? $post->published_at->format('M d, Y') : 'N/A' }}</span>
                                @if($post->author)
                                    <span>by <a href="#" class="text-indigo-500 hover:underline">{{ $post->author->name }}</a></span>
                                @endif
                            </div>
                            <div class="text-gray-600 text-sm mb-6 flex-grow">
                                {{-- For HTML content from Quill, you'd use {!! Str::limit(strip_tags($post->content), 150) !!} --}}
                                {{-- For now, assuming plain text or you'll handle HTML rendering carefully --}}
                                <p>{{ Str::limit(strip_tags($post->content), 150) }}</p>
                            </div>
                            <a href="{{ route('blog.show', $post->slug) }}" class="mt-auto inline-block text-indigo-600 hover:text-indigo-800 font-semibold text-sm">
                                Read More &rarr;
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->links() }} {{-- Pagination links --}}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <p class="text-xl text-gray-500">No blog posts found at the moment. Check back soon!</p>
            </div>
        @endif
    </div>
</div>
@endsection
