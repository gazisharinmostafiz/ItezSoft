<?php

namespace App\Http\View\Composers;

use App\Models\Setting; // Import your Setting model
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class SettingsComposer
{
    protected $settings;

    /**
     * Create a new settings composer.
     */
    public function __construct()
    {
        // Fetch all settings, using the helper from your Setting model if available,
        // or implement similar logic here.
        // This assumes Setting::getAllSettings() returns a collection keyed by 'key'.
        $this->settings = Cache::rememberForever('global_site_settings_for_composer', function () {
            return Setting::all()->pluck('value', 'key');
        });
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('globalSiteName', $this->settings->get('site_name', config('app.name', 'ItezSoft')));
        $view->with('globalSiteLogo', $this->settings->get('site_logo', null));
        $view->with('globalFooterCopyright', $this->settings->get('footer_copyright_text', '© ' . date('Y') . ' ' . config('app.name', 'ItezSoft')));

        $view->with('globalContactEmail', $this->settings->get('contact_email', 'info@example.com'));
        $view->with('globalContactPhone', $this->settings->get('contact_phone', ''));
        $view->with('globalSocialFacebookUrl', $this->settings->get('social_facebook_url', ''));
        $view->with('globalSocialTwitterUrl', $this->settings->get('social_twitter_url', ''));
        $view->with('globalSocialLinkedinUrl', $this->settings->get('social_linkedin_url', ''));
        $view->with('globalSocialInstagramUrl', $this->settings->get('social_instagram_url', ''));

        // Slider Settings
        // Ensure proper casting for boolean and integer values from string DB storage
        $view->with('globalSliderAutoplay', filter_var($this->settings->get('slider_autoplay', '1'), FILTER_VALIDATE_BOOLEAN));
        $view->with('globalSliderDuration', (int) $this->settings->get('slider_duration', '5000'));
        $view->with('globalSliderNavigationDots', filter_var($this->settings->get('slider_navigation_dots', '1'), FILTER_VALIDATE_BOOLEAN));
    }
}
