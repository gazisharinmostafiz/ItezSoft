{{-- File: resources/views/admin/menus/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Menu Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Menu Management</h1>
        <a href="{{ route('admin.menus.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
            <i class="fas fa-plus mr-2"></i>Create New Menu
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Menu Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Slug
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($menus as $menu)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $menu->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $menu->slug }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ Str::limit($menu->description, 70) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                            {{-- Link to manage items of this menu --}}
                            <a href="{{ route('admin.menus.items.index', $menu->id) }}" class="text-green-600 hover:text-green-800" title="Manage Items for {{ $menu->name }}">
                                <i class="fas fa-list-ul"></i> Items
                            </a>
                            <a href="{{ route('admin.menus.edit', $menu->id) }}" class="text-indigo-600 hover:text-indigo-800" title="Edit Menu Details">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- Prevent deletion of core menus if needed by checking their slugs --}}
                            @if(!in_array($menu->slug, ['main-header', 'footer-quick-links'])) {{-- Example core slugs --}}
                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this menu and all its items?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Delete Menu">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @else
                                <button type="button" class="text-gray-400 cursor-not-allowed" title="Core menus cannot be deleted">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                            No menus found.
                            <a href="{{ route('admin.menus.create') }}" class="ml-2 text-indigo-600 hover:text-indigo-800 font-medium">Create one now!</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($menus->hasPages())
        <div class="mt-8">
            {{ $menus->links() }} {{-- Pagination links --}}
        </div>
    @endif

@endsection
@section('scripts')
    <script>
        // Optional: Add any JavaScript functionality needed for this page
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Confirmation dialog for delete actions
            const deleteForms = document.querySelectorAll('form[action*="destroy"]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    if (!confirm('Are you sure you want to delete this menu and all its items?')) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>