{{-- File: resources/views/admin/menus/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Create New Menu')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Create New Menu</h1>
        <a href="{{ route('admin.menus.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back to All Menus
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
        <form action="{{ route('admin.menus.store') }}" method="POST" id="createMenuForm">
            @csrf {{-- CSRF protection token --}}

            {{-- Menu Name --}}
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Menu Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                       value="{{ old('name') }}" required autofocus
                       placeholder="e.g., Main Header Navigation, Footer Social Links">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Menu Slug (Optional - will be auto-generated from name if left blank) --}}
            <div class="mb-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Menu Slug (Optional)</label>
                <input type="text" name="slug" id="slug"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('slug') border-red-500 @enderror"
                       value="{{ old('slug') }}"
                       placeholder="e.g., main-header, footer-social (auto-generated if blank)">
                <p class="mt-1 text-xs text-gray-500">A unique identifier for this menu (e.g., 'main-header'). Used in code to fetch this menu. If left blank, it will be generated from the name.</p>
                @error('slug')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                <textarea name="description" id="description" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-500 @enderror"
                          placeholder="A brief description of where this menu is used or its purpose.">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.menus.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md shadow-sm mr-3 transition duration-150 ease-in-out">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
                    <i class="fas fa-save mr-2"></i>Create Menu
                </button>
            </div>
        </form>
    </div>
@endsection
