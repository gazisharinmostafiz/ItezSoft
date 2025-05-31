
@extends('layouts.admin')

@section('title', 'View Blog Post: ' . Str::limit($post->title, 30))

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            View Post: <span class="font-normal">{{ $post->title }}</span>
        </h1>
        <div>
            <a href="{{ route('admin.posts.edit', $post->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-md shadow-sm mr-2 transition duration-150 ease-in-out">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
            <a href="{{ route('admin.posts.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to All Posts
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Main Details Column --}}
            <div class="md:col-span-2 space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Title</h3>
                    <p class="text-gray-800">{{ $post->title }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Slug</h3>
                    <p class="text-gray-500 text-sm">{{ $post->slug }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Content</h3>
                    <div class="prose prose-sm max-w-none p-4 border border-gray-200 rounded-md bg-gray-50">
                        {!! $post->content !!} {{-- Make sure content is sanitized if it contains user-generated HTML --}}
                    </div>
                </div>
            </div>

            {{-- Sidebar Details Column --}}
            <div class="md:col-span-1 space-y-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Status</h3>
                    @if ($post->status == 'published')
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Published
                        </span>
                    @elseif ($post->status == 'draft')
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Draft
                        </span>
                    @else
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            {{ ucfirst($post->status) }}
                        </span>
                    @endif
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Author</h3>
                    <p class="text-gray-700">{{ $post->author->name ?? 'N/A' }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Published At</h3>
                    <p class="text-gray-700">{{ $post->published_at ? $post->published_at->format('d M Y, H:i A') : 'Not Published' }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Created At</h3>
                    <p class="text-gray-700">{{ $post->created_at->format('d M Y, H:i A') }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Last Updated</h3>
                    <p class="text-gray-700">{{ $post->updated_at->format('d M Y, H:i A') }}</p>
                </div>

                @if ($post->featured_image)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Featured Image</h3>
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto rounded-md shadow-md">
                    </div>
                @endif

                @if($post->meta_title)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">SEO Meta Title</h3>
                    <p class="text-gray-700 text-xs">{{ $post->meta_title }}</p>
                </div>
                @endif

                @if($post->meta_description)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">SEO Meta Description</h3>
                    <p class="text-gray-700 text-xs">{{ $post->meta_description }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    {{-- If you use Tailwind Typography for prose styling, ensure it's set up --}}
    {{-- You might need to install it: npm install -D @tailwindcss/typography --}}
    {{-- And add it to your tailwind.config.js plugins: plugins: [require('@tailwindcss/typography')], --}}
@endpush
