{{-- File: resources/views/admin/pages/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Page: ' . $page->title)

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
        min-height: 300px; /* Adjust as needed */
    }
</style>
@endpush

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Page: <span class="font-normal">{{ $page->title }}</span></h1>
        <a href="{{ route('admin.pages.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back to All Pages
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" id="editPageForm">
            @csrf
            @method('PUT') {{-- Method spoofing for UPDATE operation --}}

            {{-- Title --}}
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Page Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('title') border-red-500 @enderror"
                       value="{{ old('title', $page->title) }}" required autofocus>
                @error('title')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug (Optional - if you want to allow manual setting) --}}
            {{--
            <div class="mb-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">URL Slug</label>
                <input type="text" name="slug" id="slug"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('slug') border-red-500 @enderror"
                       value="{{ old('slug', $page->slug) }}" placeholder="e.g., about-our-company">
                <p class="mt-1 text-xs text-gray-500">If you change the title, the slug will auto-update unless you provide a custom slug here.</p>
                @error('slug')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            --}}

            {{-- Content (Quill.js Target) --}}
            <div class="mb-6">
                <label for="quill-editor" class="block text-sm font-medium text-gray-700 mb-1">Page Content</label>
                <div id="quill-editor-container">
                    <div id="quill-editor">
                        {!! old('content', $page->content) !!} {{-- Populate with existing or old HTML content --}}
                    </div>
                </div>
                <input type="hidden" name="content" id="content_output"> {{-- Hidden input to store Quill's HTML output --}}
                @error('content')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Is Published Checkbox --}}
            <div class="mb-6">
                <label for="is_published" class="flex items-center text-sm font-medium text-gray-700">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" id="is_published" value="1"
                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                           {{ old('is_published', $page->is_published) ? 'checked' : '' }}>
                    <span class="ml-2">Publish this page</span>
                </label>
                @error('is_published')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-6">
            <h2 class="text-lg font-medium text-gray-700 mb-3">SEO Settings (Optional)</h2>

            {{-- Meta Title --}}
            <div class="mb-6">
                <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('meta_title') border-red-500 @enderror"
                       value="{{ old('meta_title', $page->meta_title) }}">
                <p class="mt-1 text-xs text-gray-500">Recommended: 50-60 characters. If blank, page title will be used.</p>
                @error('meta_title')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Meta Description --}}
            <div class="mb-6">
                <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                <textarea name="meta_description" id="meta_description" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('meta_description') border-red-500 @enderror">{{ old('meta_description', $page->meta_description) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Recommended: 150-160 characters.</p>
                @error('meta_description')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.pages.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md shadow-sm mr-3 transition duration-150 ease-in-out">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
                    <i class="fas fa-save mr-2"></i>Update Page
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
        if (document.getElementById('quill-editor')) {
            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'font': [] }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                },
                placeholder: 'Start writing your page content here...',
            });

            const contentOutput = document.getElementById('content_output');
            const form = document.getElementById('editPageForm'); // Changed form ID

            // Set initial content for Quill from existing $page->content or old input
            const initialHTMLContent = `{!! old('content', $page->content ? str_replace(["\n", "\r"], '', addslashes($page->content)) : '') !!}`;
            if (initialHTMLContent) {
                quill.root.innerHTML = initialHTMLContent;
                if (contentOutput) { // Also set initial hidden input value
                    contentOutput.value = initialHTMLContent;
                }
            }

            quill.on('text-change', function(delta, oldDelta, source) {
                if (contentOutput) {
                    contentOutput.value = quill.root.innerHTML;
                }
            });

            if (form) {
                form.addEventListener('submit', function(event) {
                    if (contentOutput) {
                        contentOutput.value = quill.root.innerHTML;
                    }
                });
            }
        }
    });
</script>
@endpush
