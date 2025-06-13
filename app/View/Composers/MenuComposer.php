<?php

namespace App\Http\View\Composers;

use App\Models\Menu; // Import your Menu model
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MenuComposer
{
    /**
     * Bind data to the view.
     *
     * Specifically, it fetches menu items for predefined menu slugs
     * (e.g., 'main-header', 'footer-quick-links') and makes them available to the views.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Define which menus you want to make available globally or to specific views
        $menuLocations = [
            'mainHeaderMenu' => 'main-header', // Variable name in view => menu slug in DB
            'footerQuickLinksMenu' => 'footer-quick-links',
            // Add other menu locations here if needed, e.g.:
            // 'footerServicesMenu' => 'footer-services',
        ];

        foreach ($menuLocations as $variableName => $menuSlug) {
            try {
                $menuData = Cache::remember('menu_composer_' . $menuSlug, now()->addHours(12), function () use ($menuSlug) {
                    // Log::info("MenuComposer: Fetching menu items for slug '{$menuSlug}' from DB.");
                    $menu = Menu::where('slug', $menuSlug)->first();
                    if ($menu) {
                        // Eager load children recursively for display
                        return $menu->parentItems()->with('childrenRecursive')->get();
                    }
                    return collect(); // Return an empty collection if menu not found
                });
                $view->with($variableName, $menuData);
                // Log::info("MenuComposer: Variable '{$variableName}' bound with " . $menuData->count() . " items for view " . $view->getName());

            } catch (\Exception $e) {
                Log::error("MenuComposer: Error fetching menu '{$menuSlug}': " . $e->getMessage());
                $view->with($variableName, collect()); // Pass an empty collection on error
            }
        }
    }
}
