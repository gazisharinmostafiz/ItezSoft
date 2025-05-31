@extends('layouts.admin')

@section('title', 'Add New Hero Slide')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Add New Hero Slide</h1>
        <a href="{{ route('admin.hero-slides.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back to All Slides
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
        <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data" id="createHeroSlideForm">
            @csrf {{-- CSRF protection token --}}

            {{-- Main Headline --}}
            <div class="mb-6">
                <label for="main_headline" class="block text-sm font-medium text-gray-700 mb-1">Main Headline <span class="text-red-500">*</span></label>
                <input type="text" name="main_headline" id="main_headline"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('main_headline') border-red-500 @enderror"
                       value="{{ old('main_headline') }}" required>
                @error('main_headline')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Sub Headline --}}
            <div class="mb-6">
                <label for="sub_headline" class="block text-sm font-medium text-gray-700 mb-1">Sub Headline (Optional)</label>
                <textarea name="sub_headline" id="sub_headline" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('sub_headline') border-red-500 @enderror">{{ old('sub_headline') }}</textarea>
                @error('sub_headline')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Button Text --}}
                <div>
                    <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1">Button Text (Optional)</label>
                    <input type="text" name="button_text" id="button_text"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('button_text') border-red-500 @enderror"
                           value="{{ old('button_text') }}">
                    @error('button_text')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Button Link --}}
                <div>
                    <label for="button_link" class="block text-sm font-medium text-gray-700 mb-1">Button Link (Optional)</label>
                    <input type="url" name="button_link" id="button_link"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('button_link') border-red-500 @enderror"
                           value="{{ old('button_link') }}" placeholder="https://example.com/your-link">
                    @error('button_link')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Background Image --}}
            <div class="mb-6">
                <label for="background_image_path" class="block text-sm font-medium text-gray-700 mb-1">Background Image (Optional)</label>
                <input type="file" name="background_image_path" id="background_image_path"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('background_image_path') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Recommended dimensions: 1920x1080px. Max size: 2MB.</p>
                @error('background_image_path')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Text Color --}}
                <div>
                    <label for="text_color" class="block text-sm font-medium text-gray-700 mb-1">Text Color (Optional)</label>
                    <input type="color" name="text_color" id="text_color"
                           class="mt-1 block w-20 h-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('text_color') border-red-500 @enderror"
                           value="{{ old('text_color', '#FFFFFF') }}">
                    <p class="mt-1 text-xs text-gray-500">Choose a color for the text that contrasts with the background.</p>
                    @error('text_color')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Order --}}
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Order <span class="text-red-500">*</span></label>
                    <input type="number" name="order" id="order" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('order') border-red-500 @enderror"
                           value="{{ old('order', 0) }}" required>
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first.</p>
                    @error('order')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Is Active Checkbox --}}
            <div class="mb-6">
                <label for="is_active" class="flex items-center text-sm font-medium text-gray-700">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <span class="ml-2">Make this slide active</span>
                </label>
                @error('is_active')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.hero-slides.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md shadow-sm mr-3 transition duration-150 ease-in-out">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
                    <i class="fas fa-save mr-2"></i>Create Slide
                </button>
            </div>
        </form>
    </div>
@endsection
