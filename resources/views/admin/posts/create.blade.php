
@extends('layouts.admin')

@section('title', 'Create New Blog Post')

@push('styles')
{{-- Quill.js default theme CSS --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<style>
    /* Basic styling for Quill editor container */
    #quill-editor-container {
        border: 1px solid #d1d5db; /* border-gray-300 */
        border-radius: 0.375rem; /* rounded-md */
        background-color: white;
    }
    .ql-toolbar.ql-snow {
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
        border-bottom: 1px solid #d1d5db; /* border-gray-300 */
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
        min-height: 250px; /* Adjust as needed */
    }
</style>
@endpush

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Create New Blog Post</h1>
        <a href="{{ route('admin.posts.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back to All Posts
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" id="createPostForm">
            @csrf {{-- CSRF protection token --}}

            {{-- Title --}}
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content (Quill.js Target) --}}
            <div class="mb-6">
                <label for="quill-editor" class="block text-sm font-medium text-gray-700 mb-1">Content <span class="text-red-500">*</span></label>
                <div id="quill-editor-container">
                    <div id="quill-editor">
                        {!! old('content') !!} {{-- Populate with old HTML content if validation failed --}}
                    </div>
                </div>
                <input type="hidden" name="content" id="content_output"> {{-- Hidden input to store Quill's HTML output --}}
                @error('content')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p> {{-- This error will be for the hidden 'content_output' field --}}
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('status') border-red-500 @enderror" required>
                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Published At --}}
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Publish Date & Time (Optional)</label>
                    <input type="datetime-local" name="published_at" id="published_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('published_at') border-red-500 @enderror" value="{{ old('published_at') }}">
                    @error('published_at')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="mb-6">
                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Featured Image (Optional)</label>
                <input type="file" name="featured_image" id="featured_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('featured_image') border-red-500 @enderror">
                @error('featured_image')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- SEO Meta Title --}}
            <div class="mb-6">
                <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">SEO Meta Title (Optional)</label>
                <input type="text" name="meta_title" id="meta_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('meta_title') border-red-500 @enderror" value="{{ old('meta_title') }}">
                @error('meta_title')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- SEO Meta Description --}}
            <div class="mb-6">
                <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">SEO Meta Description (Optional)</label>
                <textarea name="meta_description" id="meta_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('meta_description') border-red-500 @enderror">{{ old('meta_description') }}</textarea>
                @error('meta_description')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.posts.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md shadow-sm mr-3 transition duration-150 ease-in-out">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
                    <i class="fas fa-save mr-2"></i>Save Post
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
{{-- Quill.js Core --}}
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quill = new Quill('#quill-editor', {
            theme: 'snow', // 'snow' is the default theme with a toolbar
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                    [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                    [{ 'direction': 'rtl' }],                         // text direction
                    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],                       // link, image, video
                    ['clean']                                         // remove formatting button
                ]
            },
            placeholder: 'Start writing your amazing post...',
        });

        // Get the hidden input
        const contentOutput = document.getElementById('content_output');

        // If there was old content (e.g., from validation failure), set it in Quill
        // Note: old('content') would contain the HTML string
        const oldContentHTML = `{!! old('content', '') !!}`;
        if (oldContentHTML) {
            quill.root.innerHTML = oldContentHTML;
            // Also update the hidden input if there's old content
            if (contentOutput) {
                contentOutput.value = oldContentHTML;
            }
        }


        // When text changes in Quill, update the hidden input
        quill.on('text-change', function(delta, oldDelta, source) {
            if (contentOutput) {
                contentOutput.value = quill.root.innerHTML; // Store the HTML content
            }
        });

        // When the form is submitted, ensure the hidden input has the latest Quill content
        const form = document.getElementById('createPostForm');
        if (form) {
            form.addEventListener('submit', function(event) {
                if (contentOutput) {
                    contentOutput.value = quill.root.innerHTML; // Ensure it's the latest before submit
                }
            });
        }
    });
</script>
@endpush
