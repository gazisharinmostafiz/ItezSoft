{{-- File: resources/views/admin/menus/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Menu: ' . $menu->name)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Menu: <span class="font-normal">{{ $menu->name }}</span></h1>
        <a href="{{ route('admin.menus.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back to All Menus
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" id="editMenuForm">
            @csrf
            @method('PUT') {{-- Method spoofing for UPDATE operation --}}

            {{-- Menu Name --}}
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Menu Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                       value="{{ old('name', $menu->name) }}" required autofocus>
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Menu Slug --}}
            <div class="mb-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Menu Slug</label>
                <input type="text" name="slug" id="slug"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('slug') border-red-500 @enderror"
                       value="{{ old('slug', $menu->slug) }}"
                       placeholder="e.g., main-header (auto-updated if blank & name changes)">
                <p class="mt-1 text-xs text-gray-500">A unique identifier. If you change the name and leave this blank, the slug might auto-update. Change with caution if already used in code.</p>
                @error('slug')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                <textarea name="description" id="description" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-500 @enderror"
                          placeholder="A brief description of where this menu is used or its purpose.">{{ old('description', $menu->description) }}</textarea>
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
                    <i class="fas fa-save mr-2"></i>Update Menu
                </button>
            </div>
        </form>
    </div>

    {{-- Section to manage Menu Items for THIS menu --}}
    <div class="mt-12">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Manage Items for: {{ $menu->name }}</h2>
        <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
            <p class="text-gray-600">
                Functionality to add, edit, reorder, and delete menu items for this specific menu will go here.
                This typically involves a separate controller and set of views for `MenuItems`.
            </p>
            {{-- Example link to a future MenuItem management page for this menu --}}
            {{-- <a href="{{ route('admin.menus.items.index', $menu->id) }}" class="mt-4 inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md shadow-sm">
                Manage Items
            </a> --}}
            <p class="mt-4 text-sm text-yellow-600 bg-yellow-50 p-3 rounded-md">
                <i class="fas fa-exclamation-triangle mr-2"></i>Note: Managing individual menu items (links, submenus) will be the next major step after setting up the main menu containers.
            </p>
        </div>
    </div>

@endsection
