<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting; // Import the Setting model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan; // For clearing cache
use Illuminate\Support\Facades\Cache; // For caching
use Illuminate\Support\Facades\Log; // For logging

class SettingController extends Controller
{
    /**
     * Display the general site settings form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all settings to pass to the view
        $settings = Setting::getAllSettings(); // Returns a collection keyed by 'key'

        // For convenience in the view, ensure specific keys exist with defaults
        $siteName = $settings->get('site_name', config('app.name', 'ItezSoft'));
        $siteLogo = $settings->get('site_logo', null);
        $footerCopyright = $settings->get('footer_copyright_text', '© ' . date('Y') . ' ' . config('app.name', 'ItezSoft'));
        $contactEmail = $settings->get('contact_email', 'info@example.com');
        $contactPhone = $settings->get('contact_phone', '');
        $socialFacebookUrl = $settings->get('social_facebook_url', '');
        $socialTwitterUrl = $settings->get('social_twitter_url', '');
        $socialLinkedinUrl = $settings->get('social_linkedin_url', '');
        $socialInstagramUrl = $settings->get('social_instagram_url', '');

        return view('admin.settings.index', compact(
            'siteName',
            'siteLogo',
            'footerCopyright',
            'contactEmail',
            'contactPhone',
            'socialFacebookUrl',
            'socialTwitterUrl',
            'socialLinkedinUrl',
            'socialInstagramUrl'
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
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Max 2MB
            'remove_site_logo' => 'nullable|boolean',
            'footer_copyright_text' => 'nullable|string|max:500',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'social_facebook_url' => 'nullable|url|max:255',
            'social_twitter_url' => 'nullable|url|max:255',
            'social_linkedin_url' => 'nullable|url|max:255',
            'social_instagram_url' => 'nullable|url|max:255',
        ]);

        // Update Site Name
        Setting::setValue('site_name', $validatedData['site_name']);

        // Update Footer Copyright Text
        Setting::setValue('footer_copyright_text', $validatedData['footer_copyright_text'] ?? '');

        // Update Contact Email
        Setting::setValue('contact_email', $validatedData['contact_email'] ?? '');

        // Update Contact Phone
        Setting::setValue('contact_phone', $validatedData['contact_phone'] ?? '');

        // Update Social Media URLs
        Setting::setValue('social_facebook_url', $validatedData['social_facebook_url'] ?? '');
        Setting::setValue('social_twitter_url', $validatedData['social_twitter_url'] ?? '');
        Setting::setValue('social_linkedin_url', $validatedData['social_linkedin_url'] ?? '');
        Setting::setValue('social_instagram_url', $validatedData['social_instagram_url'] ?? '');


        // Handle Logo Upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo if it exists
            $oldLogoPath = Setting::getValue('site_logo');
            if ($oldLogoPath) {
                Storage::disk('public')->delete($oldLogoPath);
            }

            // Store new logo
            $path = $request->file('site_logo')->store('site_assets', 'public'); // Stores in storage/app/public/site_assets
            Setting::setValue('site_logo', $path, 'image_path');
        } elseif ($request->input('remove_site_logo')) {
            // Delete logo if "remove" checkbox is checked
            $oldLogoPath = Setting::getValue('site_logo');
            if ($oldLogoPath) {
                Storage::disk('public')->delete($oldLogoPath);
                Setting::setValue('site_logo', null, 'image_path');
            }
        }

        // Clear relevant caches
        // The Setting model's boot method handles individual setting caches.
        // For settings used globally (like in view composers), ensure that cache is cleared.
        Cache::forget('global_site_settings_for_composer'); // If you named your composer cache like this
        // Or a more general cache clear if settings are used in many places:
        Artisan::call('cache:clear');
        Artisan::call('config:clear'); // If settings might affect config values that are cached

        return redirect()->route('admin.settings.index')->with('success', 'Site settings updated successfully!');
    }
}
