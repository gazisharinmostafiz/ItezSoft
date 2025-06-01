<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting; // Import the Setting model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan; // For clearing cache
use Illuminate\Support\Facades\Cache;   // Import Cache facade
use Illuminate\Support\Facades\Log;     // For logging

class SettingController extends Controller
{
    /**
     * Display the general site settings form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settings = Setting::getAllSettings(); // Returns a collection keyed by 'key'

        $siteName = $settings->get('site_name', config('app.name', 'ItezSoft'));
        $siteLogo = $settings->get('site_logo', null);
        $footerCopyright = $settings->get('footer_copyright_text', '© ' . date('Y') . ' ' . config('app.name', 'ItezSoft'));
        $contactEmail = $settings->get('contact_email', 'info@example.com');
        $contactPhone = $settings->get('contact_phone', '');
        $socialFacebookUrl = $settings->get('social_facebook_url', '');
        $socialTwitterUrl = $settings->get('social_twitter_url', '');
        $socialLinkedinUrl = $settings->get('social_linkedin_url', '');
        $socialInstagramUrl = $settings->get('social_instagram_url', '');

        // Slider Settings
        $sliderAutoplay = filter_var($settings->get('slider_autoplay', '1'), FILTER_VALIDATE_BOOLEAN); // Default to true
        $sliderDuration = (int) $settings->get('slider_duration', '5000'); // Default to 5000ms
        $sliderNavigationDots = filter_var($settings->get('slider_navigation_dots', '1'), FILTER_VALIDATE_BOOLEAN); // Default to true

        return view('admin.settings.index', compact(
            'siteName',
            'siteLogo',
            'footerCopyright',
            'contactEmail',
            'contactPhone',
            'socialFacebookUrl',
            'socialTwitterUrl',
            'socialLinkedinUrl',
            'socialInstagramUrl',
            'sliderAutoplay',
            'sliderDuration',
            'sliderNavigationDots'
        ));
    }

    /**
     * Update the general site settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'remove_site_logo' => 'nullable|boolean',
            'footer_copyright_text' => 'nullable|string|max:500',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'social_facebook_url' => 'nullable|url|max:255',
            'social_twitter_url' => 'nullable|url|max:255',
            'social_linkedin_url' => 'nullable|url|max:255',
            'social_instagram_url' => 'nullable|url|max:255',
            // Slider Settings Validation
            'slider_autoplay' => 'required|boolean',
            'slider_duration' => 'required|integer|min:1000|max:30000', // e.g., 1-30 seconds
            'slider_navigation_dots' => 'required|boolean',
        ]);

        Setting::setValue('site_name', $validatedData['site_name']);
        Setting::setValue('footer_copyright_text', $validatedData['footer_copyright_text'] ?? '');
        Setting::setValue('contact_email', $validatedData['contact_email'] ?? '');
        Setting::setValue('contact_phone', $validatedData['contact_phone'] ?? '');
        Setting::setValue('social_facebook_url', $validatedData['social_facebook_url'] ?? '');
        Setting::setValue('social_twitter_url', $validatedData['social_twitter_url'] ?? '');
        Setting::setValue('social_linkedin_url', $validatedData['social_linkedin_url'] ?? '');
        Setting::setValue('social_instagram_url', $validatedData['social_instagram_url'] ?? '');

        // Update Slider Settings
        // When a checkbox is unchecked, it's not present in the request,
        // so $request->input('slider_autoplay', '0') provides a default if not present.
        Setting::setValue('slider_autoplay', $request->input('slider_autoplay', '0'), 'boolean');
        Setting::setValue('slider_duration', (string)$validatedData['slider_duration'], 'integer');
        Setting::setValue('slider_navigation_dots', $request->input('slider_navigation_dots', '0'), 'boolean');


        if ($request->hasFile('site_logo')) {
            $oldLogoPath = Setting::getValue('site_logo');
            if ($oldLogoPath) {
                Storage::disk('public')->delete($oldLogoPath);
            }
            $path = $request->file('site_logo')->store('site_assets', 'public');
            Setting::setValue('site_logo', $path, 'image_path');
        } elseif ($request->input('remove_site_logo')) {
            $oldLogoPath = Setting::getValue('site_logo');
            if ($oldLogoPath) {
                Storage::disk('public')->delete($oldLogoPath);
                Setting::setValue('site_logo', null, 'image_path');
            }
        }

        // Clear the specific cache used by SettingsComposer and other general caches
        Cache::forget('global_site_settings_for_composer');
        Artisan::call('cache:clear'); // Clears default application cache
        Artisan::call('config:clear'); // Important if settings are used in config files that are cached

        return redirect()->route('admin.settings.index')->with('success', 'Site settings updated successfully!');
    }
}
