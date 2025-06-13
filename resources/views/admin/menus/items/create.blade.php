{{-- File: resources/views/admin/menus/items/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Add New Item to Menu: ' . $menu->name)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Add New Item to: <span class="text-indigo-600">{{ $menu->name }}</span></h1>
            <a href="{{ route('admin.menus.items.index', $menu->id) }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                &larr; Back to Items for {{ $menu->name }}
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
        <form action="{{ route('admin.menus.items.store', $menu->id) }}" method="POST" id="createMenuItemForm">
            @csrf {{-- CSRF protection token --}}

            {{-- Title --}}
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('title') border-red-500 @enderror"
                       value="{{ old('title') }}" required placeholder="e.g., Home, About Us, Our Services">
                @error('title')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Link Type and Value Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"
                 x-data="{
                    selectedType: '{{ old('link_type', 'url') }}',
                    urlValue: '{{ old('link_type', 'url') === 'url' ? old('link_value', '#') : '#' }}',
                    routeValue: '{{ old('link_type') === 'route' ? old('link_value', '') : '' }}',
                    pageSlugValue: '{{ old('link_type') === 'page_slug' ? old('link_value', '') : '' }}'
                 }">
                {{-- Link Type --}}
                <div>
                    <label for="link_type" class="block text-sm font-medium text-gray-700 mb-1">Link Type <span class="text-red-500">*</span></label>
                    <select name="link_type" id="link_type"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('link_type') border-red-500 @enderror"
                            required x-model="selectedType">
                        <option value="url">Absolute URL</option>
                        <option value="route">Named Route</option>
                        <option value="page_slug">Dynamic Page (by Slug)</option>
                    </select>
                    @error('link_type')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Link Value --}}
                <div>
                    <label for="link_value_display_area" class="block text-sm font-medium text-gray-700 mb-1">Link Value <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500 mb-1 italic">Content below changes based on 'Link Type'.</p>

                    {{-- Input for URL --}}
                    <div x-show="selectedType === 'url'" id="link_value_display_area_url">
                        <input type="url" id="link_value_url_display" x-model="urlValue"
                               placeholder="https://example.com/path"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @if($errors->has('link_value') && old('link_type', 'url') === 'url') border-red-500 @endif">
                    </div>
                    {{-- Select for Named Route --}}
                    <div x-show="selectedType === 'route'" id="link_value_display_area_route">
                        <select id="link_value_route_display" x-model="routeValue"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @if($errors->has('link_value') && old('link_type') === 'route') border-red-500 @endif">
                            <option value="">Select a Route</option>
                            @foreach($namedRoutes as $routeName => $routeDisplay)
                                <option value="{{ $routeName }}" {{ (old('link_type') === 'route' && old('link_value') == $routeName) ? 'selected' : '' }}>{{ $routeDisplay }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Select for Page Slug --}}
                    <div x-show="selectedType === 'page_slug'" id="link_value_display_area_page">
                        <select id="link_value_page_slug_display" x-model="pageSlugValue"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @if($errors->has('link_value') && old('link_type') === 'page_slug') border-red-500 @endif">
                            <option value="">Select a Page</option>
                            @foreach($pages as $page)
                                <option value="{{ $page->slug }}" {{ (old('link_type') === 'page_slug' && old('link_value') == $page->slug) ? 'selected' : '' }}>{{ $page->title }} (/{{ $page->slug }})</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Hidden input to consolidate link_value based on selectedType --}}
                    <input type="hidden" name="link_value"
                           :value="selectedType === 'url' ? urlValue : (selectedType === 'route' ? routeValue : (selectedType === 'page_slug' ? pageSlugValue : ''))">
                    @error('link_value') {{-- This will catch the consolidated 'link_value' error --}}
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Parent Item (for submenus) --}}
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Parent Item (Optional)</label>
                    <select name="parent_id" id="parent_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('parent_id') border-red-500 @enderror">
                        <option value="">None (Top-level item)</option>
                        @foreach ($parentItems as $item)
                            <option value="{{ $item->id }}" {{ old('parent_id') == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Select a parent to make this a sub-item.</p>
                    @error('parent_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Order --}}
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Order <span class="text-red-500">*</span></label>
                    <input type="number" name="order" id="order" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('order') border-red-500 @enderror"
                           value="{{ old('order', 0) }}" required>
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first in the menu.</p>
                    @error('order')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Target --}}
                <div>
                    <label for="target" class="block text-sm font-medium text-gray-700 mb-1">Link Target (Optional)</label>
                    <select name="target" id="target"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('target') border-red-500 @enderror">
                        <option value="_self" {{ old('target', '_self') == '_self' ? 'selected' : '' }}>Same Window/Tab (_self)</option>
                        <option value="_blank" {{ old('target') == '_blank' ? 'selected' : '' }}>New Window/Tab (_blank)</option>
                    </select>
                    @error('target')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Icon Class --}}
                <div>
                    <label for="icon_class" class="block text-sm font-medium text-gray-700 mb-1">Icon Class (Optional)</label>
                    <input type="text" name="icon_class" id="icon_class"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('icon_class') border-red-500 @enderror"
                           value="{{ old('icon_class') }}" placeholder="e.g., fas fa-home">
                    <p class="mt-1 text-xs text-gray-500">Enter Font Awesome class(es) if you want an icon.</p>
                    @error('icon_class')
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
                    <span class="ml-2">Make this menu item active</span>
                </label>
                @error('is_active')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.menus.items.index', $menu->id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md shadow-sm mr-3 transition duration-150 ease-in-out">
                    Cancel
                </a>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
                    <i class="fas fa-plus-circle mr-2"></i>Add Menu Item
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
{{-- Alpine.js is assumed to be loaded globally via app.js --}}
@endpush
