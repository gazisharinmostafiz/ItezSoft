<?php

namespace App\Providers;

use Illuminate\Support\Facades\View; // Import View facade
use App\Http\View\Composers\SettingsComposer; // Import your SettingsComposer
use App\Http\View\Composers\MenuComposer;     // Import your new MenuComposer
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // For defaultStringLength

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Share global site settings with specified views
        View::composer(
            ['layouts.app', 'partials.header', 'partials.footer', 'layouts.admin'], // Views that need global site settings
            SettingsComposer::class
        );

        // Share dynamic menu data with specified views
        // This makes $mainHeaderMenu, $footerQuickLinksMenu, etc., available
        View::composer(
            ['partials.header', 'partials.footer'], // Views that will display these dynamic menus
            MenuComposer::class
        );
    }
}
