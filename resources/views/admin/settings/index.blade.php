{{-- File: resources/views/admin/settings/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Site Settings</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

            {{-- Section: General Settings --}}
            <div class="mb-8 border-b border-gray-200 pb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">General</h2>
                {{-- Site Name --}}
                <div class="mb-6">
                    <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Site Name <span class="text-red-500">*</span></label>
                    <input type="text" name="site_name" id="site_name"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('site_name') border-red-500 @enderror"
                           value="{{ old('site_name', $siteName ?? '') }}" required>
                    @error('site_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Site Logo --}}
                <div class="mb-6">
                    <label for="site_logo" class="block text-sm font-medium text-gray-700 mb-1">Site Logo (Optional)</label>
                    <input type="file" name="site_logo" id="site_logo"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('site_logo') border-red-500 @enderror">
                    @error('site_logo')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    @if ($siteLogo)
                        <div class="mt-4">
                            <p class="text-xs text-gray-500 mb-1">Current Logo:</p>
                            <img src="{{ Storage::url($siteLogo) }}" alt="Current Site Logo" class="h-16 w-auto bg-gray-100 p-2 rounded-md shadow">
                            <div class="mt-2">
                                <label for="remove_site_logo" class="flex items-center text-sm text-gray-600">
                                    <input type="checkbox" name="remove_site_logo" id="remove_site_logo" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <span class="ml-2">Remove current logo</span>
                                </label>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Section: Contact Information --}}
            <div class="mb-8 border-b border-gray-200 pb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Contact Information</h2>
                <div class="mb-6">
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                    <input type="email" name="contact_email" id="contact_email"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('contact_email') border-red-500 @enderror"
                           value="{{ old('contact_email', $contactEmail ?? '') }}">
                    @error('contact_email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                    <input type="text" name="contact_phone" id="contact_phone"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('contact_phone') border-red-500 @enderror"
                           value="{{ old('contact_phone', $contactPhone ?? '') }}">
                    @error('contact_phone')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Section: Social Media Links --}}
            <div class="mb-8 border-b border-gray-200 pb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Social Media Links</h2>
                <div class="mb-6">
                    <label for="social_facebook_url" class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                    <input type="url" name="social_facebook_url" id="social_facebook_url"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('social_facebook_url') border-red-500 @enderror"
                           placeholder="https://facebook.com/yourpage"
                           value="{{ old('social_facebook_url', $socialFacebookUrl ?? '') }}">
                    @error('social_facebook_url')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="social_twitter_url" class="block text-sm font-medium text-gray-700 mb-1">Twitter (X) URL</label>
                    <input type="url" name="social_twitter_url" id="social_twitter_url"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('social_twitter_url') border-red-500 @enderror"
                           placeholder="https://twitter.com/yourprofile"
                           value="{{ old('social_twitter_url', $socialTwitterUrl ?? '') }}">
                    @error('social_twitter_url')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="social_linkedin_url" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                    <input type="url" name="social_linkedin_url" id="social_linkedin_url"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('social_linkedin_url') border-red-500 @enderror"
                           placeholder="https://linkedin.com/in/yourprofile"
                           value="{{ old('social_linkedin_url', $socialLinkedinUrl ?? '') }}">
                    @error('social_linkedin_url')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="social_instagram_url" class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                    <input type="url" name="social_instagram_url" id="social_instagram_url"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('social_instagram_url') border-red-500 @enderror"
                           placeholder="https://instagram.com/yourprofile"
                           value="{{ old('social_instagram_url', $socialInstagramUrl ?? '') }}">
                    @error('social_instagram_url')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Section: Homepage Slider Settings --}}
            <div class="mb-8 border-b border-gray-200 pb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Homepage Slider</h2>
                {{-- Slider Autoplay --}}
                <div class="mb-6">
                    <label for="slider_autoplay" class="flex items-center text-sm font-medium text-gray-700">
                        <input type="hidden" name="slider_autoplay" value="0"> {{-- Send 0 if checkbox not ticked --}}
                        <input type="checkbox" name="slider_autoplay" id="slider_autoplay" value="1"
                               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                               {{ old('slider_autoplay', $sliderAutoplay ?? true) ? 'checked' : '' }}>
                        <span class="ml-2">Enable Autoplay</span>
                    </label>
                    @error('slider_autoplay')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slider Duration --}}
                <div class="mb-6">
                    <label for="slider_duration" class="block text-sm font-medium text-gray-700 mb-1">Autoplay Duration (milliseconds)</label>
                    <input type="number" name="slider_duration" id="slider_duration" min="1000" max="30000" step="500"
                           class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('slider_duration') border-red-500 @enderror"
                           value="{{ old('slider_duration', $sliderDuration ?? 5000) }}">
                    <p class="mt-1 text-xs text-gray-500">Time each slide is visible (e.g., 5000 for 5 seconds).</p>
                    @error('slider_duration')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slider Navigation Dots --}}
                <div class="mb-6">
                    <label for="slider_navigation_dots" class="flex items-center text-sm font-medium text-gray-700">
                        <input type="hidden" name="slider_navigation_dots" value="0">
                        <input type="checkbox" name="slider_navigation_dots" id="slider_navigation_dots" value="1"
                               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                               {{ old('slider_navigation_dots', $sliderNavigationDots ?? true) ? 'checked' : '' }}>
                        <span class="ml-2">Show Navigation Dots</span>
                    </label>
                    @error('slider_navigation_dots')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Section: Footer Settings --}}
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Footer</h2>
                <div class="mb-6">
                    <label for="footer_copyright_text" class="block text-sm font-medium text-gray-700 mb-1">Footer Copyright Text</label>
                    <textarea name="footer_copyright_text" id="footer_copyright_text" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('footer_copyright_text') border-red-500 @enderror">{{ old('footer_copyright_text', $footerCopyright ?? '') }}</textarea>
                    @error('footer_copyright_text')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-start">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md shadow-sm transition duration-150 ease-in-out">
                    <i class="fas fa-save mr-2"></i>Save Settings
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    const siteLogoInput = document.getElementById('site_logo');
    if (siteLogoInput) {
        siteLogoInput.addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                console.log('New logo selected:', file.name);
            }
        });
    }
</script>
@endpush
