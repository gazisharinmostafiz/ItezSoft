<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.menus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:menus,name',
            'slug' => 'nullable|string|max:255|unique:menus,slug',
            'description' => 'nullable|string|max:500',
        ]);

        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        } else {
            $validatedData['slug'] = Str::slug($validatedData['slug']); // Ensure it's URL-friendly
        }

        // Ensure slug is unique after potential auto-generation or manual input sanitization
        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Menu::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = "{$originalSlug}-{$count}";
            $count++;
        }

        Menu::create($validatedData);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    /**
     * Display the specified resource.
     * For menus, we'll likely redirect to the edit page or a page to manage its items.
     */
    public function show(Menu $menu)
    {
        // Redirect to edit, or later to a page for managing items of this menu
        return redirect()->route('admin.menus.edit', $menu->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:menus,name,' . $menu->id,
            'slug' => 'nullable|string|max:255|unique:menus,slug,' . $menu->id,
            'description' => 'nullable|string|max:500',
        ]);

        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        } else {
            $validatedData['slug'] = Str::slug($validatedData['slug']);
        }
        
        // Ensure slug is unique after potential auto-generation or manual input sanitization
        if ($menu->slug !== $validatedData['slug'] || $menu->name !== $validatedData['name'] && empty($request->slug) ) {
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Menu::where('slug', $validatedData['slug'])->where('id', '!=', $menu->id)->exists()) {
                $validatedData['slug'] = "{$originalSlug}-{$count}";
                $count++;
            }
        }


        $menu->update($validatedData);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Consider what happens to menu items when a menu is deleted.
        // The 'cascade' onDelete in the menu_items migration for menu_id will delete them.
        // If you have default menus (e.g., 'main-header') that shouldn't be deleted, add checks here.
        // Example:
        // if (in_array($menu->slug, ['main-header', 'footer-quick-links'])) {
        //     return redirect()->route('admin.menus.index')->with('error', 'Core menus cannot be deleted.');
        // }

        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }
}
