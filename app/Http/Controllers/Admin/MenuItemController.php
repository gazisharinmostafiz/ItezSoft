<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page; // For linking to dynamic pages
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as RouteFacade; // For checking named routes
use Illuminate\Validation\Rule;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the menu items for a specific menu.
     * This page will also serve as the interface to reorder items.
     */
    public function index(Menu $menu) // Route model binding for the parent Menu
    {
        // Eager load children recursively for display, and order them
        // A more efficient way for deep nesting might involve a custom recursive relationship or helper
        $menuItems = $menu->parentItems()->with('childrenRecursive')->get();

        return view('admin.menus.items.index', compact('menu', 'menuItems'));
    }

    /**
     * Show the form for creating a new menu item for a specific menu.
     */
    public function create(Menu $menu)
    {
        $parentItems = $menu->items()->whereNull('parent_id')->orderBy('order')->get(); // For parent dropdown
        $pages = Page::where('is_published', true)->orderBy('title')->get(); // For 'page_slug' link type
        $namedRoutes = $this->getFrontendNamedRoutes(); // Get a list of potential named routes

        return view('admin.menus.items.create', compact('menu', 'parentItems', 'pages', 'namedRoutes'));
    }

    /**
     * Store a newly created menu item in storage.
     */
    public function store(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'link_type' => ['required', Rule::in(['url', 'route', 'page_slug'])],
            'link_value' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id', // Ensure parent_id exists in menu_items table
            'order' => 'required|integer|min:0',
            'target' => ['nullable', Rule::in(['_self', '_blank'])],
            'icon_class' => 'nullable|string|max:100',
            'is_active' => 'required|boolean',
        ]);

        $menuItem = new MenuItem($validatedData);
        $menuItem->menu_id = $menu->id;
        // Ensure parent_id actually belongs to the current menu if set (optional extra validation)
        if ($request->parent_id) {
            $parentItem = MenuItem::where('id', $request->parent_id)->where('menu_id', $menu->id)->first();
            if (!$parentItem) {
                return back()->withInput()->with('error', 'Invalid parent item selected.');
            }
        }
        $menuItem->save();

        return redirect()->route('admin.menus.items.index', $menu->id)->with('success', 'Menu item created successfully.');
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(Menu $menu, MenuItem $menuItem) // Nested route model binding
    {
        if ($menuItem->menu_id !== $menu->id) {
            abort(404); // Ensure the item belongs to the menu
        }
        $parentItems = $menu->items()->whereNull('parent_id')->where('id', '!=', $menuItem->id)->orderBy('order')->get(); // Exclude self
        $pages = Page::where('is_published', true)->orderBy('title')->get();
        $namedRoutes = $this->getFrontendNamedRoutes();

        return view('admin.menus.items.edit', compact('menu', 'menuItem', 'parentItems', 'pages', 'namedRoutes'));
    }

    /**
     * Update the specified menu item in storage.
     */
    public function update(Request $request, Menu $menu, MenuItem $menuItem)
    {
        if ($menuItem->menu_id !== $menu->id) {
            abort(404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'link_type' => ['required', Rule::in(['url', 'route', 'page_slug'])],
            'link_value' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id|not_in:'.$menuItem->id, // Cannot be its own parent
            'order' => 'required|integer|min:0',
            'target' => ['nullable', Rule::in(['_self', '_blank'])],
            'icon_class' => 'nullable|string|max:100',
            'is_active' => 'required|boolean',
        ]);

        // Ensure parent_id actually belongs to the current menu if set
        if ($request->parent_id) {
            $parentItem = MenuItem::where('id', $request->parent_id)->where('menu_id', $menu->id)->first();
            if (!$parentItem) {
                return back()->withInput()->with('error', 'Invalid parent item selected.');
            }
        }
        // Prevent setting an item as a child of one of its own descendants (more complex logic needed for deep nesting)

        $menuItem->update($validatedData);

        return redirect()->route('admin.menus.items.index', $menu->id)->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified menu item from storage.
     */
    public function destroy(Menu $menu, MenuItem $menuItem)
    {
        if ($menuItem->menu_id !== $menu->id) {
            abort(404);
        }
        // Deleting a parent item will also delete its children due to onDelete('cascade') in migration
        $menuItem->delete();
        return redirect()->route('admin.menus.items.index', $menu->id)->with('success', 'Menu item deleted successfully.');
    }

    /**
     * Helper to get a list of relevant frontend named routes.
     * This is a basic example and might need refinement.
     */
    protected function getFrontendNamedRoutes(): array
    {
        $routes = RouteFacade::getRoutes()->getRoutesByName();
        $frontendRoutes = [];
        $excludedPrefixes = ['admin.', 'livewire.', 'ignition.', 'sanctum.', 'profile.', 'verification.', 'password.', 'two-factor.']; // Add more as needed

        foreach ($routes as $name => $route) {
            $isExcluded = false;
            foreach ($excludedPrefixes as $prefix) {
                if (str_starts_with($name, $prefix)) {
                    $isExcluded = true;
                    break;
                }
            }
            // Only include GET routes that don't require parameters or only simple ones for now
            // This logic might need to be more sophisticated for routes with complex parameters
            if (!$isExcluded && in_array('GET', $route->methods()) && !preg_match('/\{.*\}/', $route->uri())) {
                 $frontendRoutes[$name] = $name . ' (/' . $route->uri() . ')';
            }
        }
        ksort($frontendRoutes);
        return $frontendRoutes;
    }

    // You will likely need a method to handle reordering menu items
    // public function updateOrder(Request $request, Menu $menu) { ... }
}
