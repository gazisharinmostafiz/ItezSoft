@extends('layouts.admin')

@section('title', 'Manage Hero Slides')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Hero Slides</h1>
        <a href="{{ route('admin.hero-slides.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
            <i class="fas fa-plus mr-2"></i>Add New Slide
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Order
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Image
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Main Headline
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Button Text
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($slides as $slide)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $slide->order }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if ($slide->background_image_path)
                                <img src="{{ Storage::url($slide->background_image_path) }}" alt="{{ Str::limit($slide->main_headline, 20) }} background" class="h-10 w-16 object-cover rounded shadow">
                            @else
                                <div class="h-10 w-16 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Image</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($slide->main_headline, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $slide->button_text ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($slide->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                            <a href="{{ route('admin.hero-slides.edit', $slide->id) }}" class="text-indigo-600 hover:text-indigo-800" title="Edit Slide">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.hero-slides.destroy', $slide->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this slide?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete Slide">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500"> {{-- Increased colspan to 6 --}}
                            No hero slides found.
                            <a href="{{ route('admin.hero-slides.create') }}" class="ml-2 text-indigo-600 hover:text-indigo-800 font-medium">Create one now!</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($slides->hasPages())
        <div class="mt-8">
            {{ $slides->links() }} {{-- Pagination links --}}
        </div>
    @endif

@endsection
