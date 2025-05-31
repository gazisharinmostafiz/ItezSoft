@extends('layouts.admin')

@section('title', 'Add New User')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Add New User</h1>
        <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back to All Users
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf {{-- CSRF protection token --}}

            {{-- Name --}}
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                       value="{{ old('name') }}" required autofocus>
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-500 @enderror"
                       value="{{ old('email') }}" required>
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" id="password"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('password') border-red-500 @enderror"
                       required autocomplete="new-password">
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                       required autocomplete="new-password">
            </div>

            {{-- Is Admin Checkbox --}}
            <div class="mb-6">
                <label for="is_admin" class="flex items-center text-sm font-medium text-gray-700">
                    <input type="checkbox" name="is_admin" id="is_admin" value="1"
                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                           {{ old('is_admin') ? 'checked' : '' }}>
                    <span class="ml-2">Assign as Administrator</span>
                </label>
                @error('is_admin')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-md shadow-sm mr-3 transition duration-150 ease-in-out">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out">
                    <i class="fas fa-user-plus mr-2"></i>Create User
                </button>
            </div>
        </form>
    </div>
@endsection