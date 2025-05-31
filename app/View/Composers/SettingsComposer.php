<?php

// namespace App\Providers;
namespace App\View\Composers;
use Illuminate\Support\Facades\View; // Import View facade
use App\View\Composers\SettingsComposer; // Import your SettingsComposer
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
        Schema::defaultStringLength(191); // Often needed for older MySQL versions with utf8mb4

        // Share settings with specific views using a View Composer
        // You can specify individual views or use a wildcard for a directory
        View::composer(['layouts.app', 'partials.header', 'partials.footer'], SettingsComposer::class);
        // If you want them in the admin layout too (though admin settings page fetches directly):
        // View::composer('layouts.admin', SettingsComposer::class);
    }
}
