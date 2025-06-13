<?php

namespace App\Http\View\Composers;

use App\Models\Setting; // Import your Setting model
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log; // Import Log facade

class SettingsComposer
{
    protected $settings;

    /**
     * Create a new settings composer.
     */
    public function __construct()
    {
        try {
            $this->settings = Cache::rememberForever('global_site_settings_for_composer', function () {
                Log::info('SettingsComposer: Fetching settings from DB for global_site_settings_for_composer cache.');
                return Setting::all()->pluck('value', 'key');
            });
            // Log::info('SettingsComposer: Settings loaded in constructor.', ['count' => $this->settings->count()]);
        } catch (\Exception $e) {
            Log::error('SettingsComposer __construct error: ' . $e->getMessage());
            $this->settings = collect(); // Initialize as empty collection on error
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        Log::info('SettingsComposer: Composing view - ' . $view->getName());
        try {
            $siteName = $this->settings->get('site_name', config('app.name', 'ItezSoft (Default)'));
            $siteLogo = $this->settings->get('site_logo', null);
            $footerCopyright = $this->settings->get('footer_copyright_text', '© ' . date('Y') . ' ' . config('app.name', 'ItezSoft (Default)'));
            $contactEmail = $this->settings->get('contact_email', 'composer_default_contact@example.com');
            $contactPhone = $this->settings->get('contact_phone', 'COMPOSER_DEFAULT_PHONE');
            
            $socialFacebookUrl = $this->settings->get('social_facebook_url', '');
            $socialTwitterUrl = $this->settings->get('social_twitter_url', '');
            $socialLinkedinUrl = $this->settings->get('social_linkedin_url', '');
            $socialInstagramUrl = $this->settings->get('social_instagram_url', '');

            $sliderAutoplay = filter_var($this->settings->get('slider_autoplay', '1'), FILTER_VALIDATE_BOOLEAN);
            $sliderDuration = (int) $this->settings->get('slider_duration', '5000');
            $sliderNavigationDots = filter_var($this->settings->get('slider_navigation_dots', '1'), FILTER_VALIDATE_BOOLEAN);

            $view->with('globalSiteName', $siteName);
            $view->with('globalSiteLogo', $siteLogo);
            $view->with('globalFooterCopyright', $footerCopyright);
            $view->with('globalContactEmail', $contactEmail);
            $view->with('globalContactPhone', $contactPhone);
            $view->with('globalSocialFacebookUrl', $socialFacebookUrl);
            $view->with('globalSocialTwitterUrl', $socialTwitterUrl);
            $view->with('globalSocialLinkedinUrl', $socialLinkedinUrl);
            $view->with('globalSocialInstagramUrl', $socialInstagramUrl);
            $view->with('globalSliderAutoplay', $sliderAutoplay);
            $view->with('globalSliderDuration', $sliderDuration);
            $view->with('globalSliderNavigationDots', $sliderNavigationDots);

            Log::info('SettingsComposer: globalContactEmail bound with value: ' . $contactEmail . ' for view ' . $view->getName());

        } catch (\Exception $e) {
            Log::error('SettingsComposer compose error: ' . $e->getMessage() . ' for view ' . $view->getName());
            // Bind default error values so the view doesn't completely break
            $view->with('globalContactEmail', 'error_in_composer@example.com');
            // Bind other defaults as needed
            $view->with('globalSiteName', config('app.name', 'ItezSoft (Error)'));
            // ... and so on for other global variables
        }
    }
}
