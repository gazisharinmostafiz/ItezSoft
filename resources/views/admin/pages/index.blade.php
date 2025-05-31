{{-- File: resources/views/admin/pages/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manage Pages')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Pages</h1>
        <a href="{{ route('admin.pages.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
            <i class="fas fa-plus mr-2"></i>Create New Page
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Slug
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Last Updated
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($pages as $page)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($page->title, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{-- Link to view page on frontend --}}
                            @if($page->is_published)
                                <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">
                                    /{{ $page->slug }}
                                </a>
                            @else
                                <span class="text-gray-400">/{{ $page->slug }} (Draft)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($page->is_published)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Published
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $page->updated_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                            @if($page->is_published)
                                <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-800" title="View on Frontend">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @else
                                <span class="text-gray-400 cursor-not-allowed" title="Page is not published">
                                    <i class="fas fa-external-link-alt"></i>
                                </span>
                            @endif
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="text-indigo-600 hover:text-indigo-800" title="Edit Page">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete Page">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                            No pages found.
                            <a href="{{ route('admin.pages.create') }}" class="ml-2 text-indigo-600 hover:text-indigo-800 font-medium">Create one now!</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($pages->hasPages())
        <div class="mt-8">
            {{ $pages->links() }} {{-- Pagination links --}}
        </div>
    @endif

@endsection
