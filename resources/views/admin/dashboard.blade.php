{{-- File: resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-800 mb-8">Welcome to the ItezSoft Admin Panel</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-indigo-500 text-white rounded-full mr-4">
                    <i class="fas fa-file-alt fa-2x"></i>
                </div>
                <div>
                    <p class="text-3xl font-semibold text-gray-700">{{ \App\Models\Post::count() }}</p>
                    <p class="text-gray-500">Total Blog Posts</p>
                </div>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="block text-right mt-4 text-indigo-600 hover:text-indigo-800 text-sm font-medium">Manage Posts &rarr;</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-green-500 text-white rounded-full mr-4">
                    <i class="fas fa-briefcase fa-2x"></i>
                </div>
                <div>
                    <p class="text-3xl font-semibold text-gray-700">0</p> {{-- Replace with actual job count later --}}
                    <p class="text-gray-500">Active Job Listings</p>
                </div>
            </div>
            <a href="{{-- {{ route('admin.jobs.index') }} --}}#" class="block text-right mt-4 text-green-600 hover:text-green-800 text-sm font-medium">Manage Jobs &rarr;</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-blue-500 text-white rounded-full mr-4">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <div>
                    <p class="text-3xl font-semibold text-gray-700">{{ \App\Models\User::count() }}</p>
                    <p class="text-gray-500">Registered Users</p>
                </div>
            </div>
            <a href="{{-- {{ route('admin.users.index') }} --}}#" class="block text-right mt-4 text-blue-600 hover:text-blue-800 text-sm font-medium">Manage Users &rarr;</a>
        </div>
    </div>

    {{-- Quick Actions / Links to Settings --}}
    <div class="mt-12 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-700 mb-6">Quick Actions & Site Management</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin.posts.create') }}" class="block p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg text-indigo-700 font-medium transition-colors">
                <i class="fas fa-plus-circle mr-2"></i> Add New Blog Post
            </a>
            <a href="{{-- {{ route('admin.jobs.create') }} --}}#" class="block p-4 bg-green-50 hover:bg-green-100 rounded-lg text-green-700 font-medium transition-colors">
                <i class="fas fa-plus-circle mr-2"></i> Add New Job Listing
            </a>
            <a href="{{-- {{ route('admin.pages.create') }} --}}#" class="block p-4 bg-purple-50 hover:bg-purple-100 rounded-lg text-purple-700 font-medium transition-colors">
                <i class="fas fa-plus-circle mr-2"></i> Create New Page
            </a>
            <a href="{{-- {{ route('admin.settings.general') }} --}}#" class="block p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg text-yellow-700 font-medium transition-colors">
                <i class="fas fa-cog mr-2"></i> General Site Settings
            </a>
            <a href="{{-- {{ route('admin.settings.theme') }} --}}#" class="block p-4 bg-pink-50 hover:bg-pink-100 rounded-lg text-pink-700 font-medium transition-colors">
                <i class="fas fa-palette mr-2"></i> Theme & Appearance
            </a>
             <a href="{{-- {{ route('admin.settings.menu') }} --}}#" class="block p-4 bg-teal-50 hover:bg-teal-100 rounded-lg text-teal-700 font-medium transition-colors">
                <i class="fas fa-list-alt mr-2"></i> Menu Management
            </a>
        </div>
    </div>

    {{-- Placeholder for more dashboard widgets/info --}}
    <div class="mt-12">
        <p class="text-gray-600">Further dashboard elements and summaries can be added here.</p>
    </div>

@endsection

@push('scripts')
{{-- You can add page-specific JavaScript here if needed, e.g., for charts --}}
@endpush
