<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page; // Your Page model
use Illuminate\Http\Request;
use Illuminate\Support\Str; // For generating slugs

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::latest()->paginate(10); // Get all pages, latest first
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:pages,title',
            'content' => 'nullable|string', // Quill sends HTML
            'is_published' => 'required|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            // 'slug' => 'nullable|string|max:255|unique:pages,slug', // Optional: allow manual slug, otherwise model handles it
        ]);

        // The Page model's boot method should handle slug generation automatically if title is provided
        // and no slug is manually entered.
        // If you want to allow manual slug input and override:
        // if (empty($validatedData['slug'])) {
        //     $validatedData['slug'] = Str::slug($validatedData['title']);
        // } else {
        //     $validatedData['slug'] = Str::slug($validatedData['slug']); // Ensure it's URL-friendly
        // }
        // Ensure uniqueness if manually setting slug (model boot method already does this for auto-generated)

        Page::create($validatedData);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified resource.
     * (Often not used for admin page management, edit is preferred)
     */
    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page')); // You might not create this view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:pages,title,' . $page->id,
            'content' => 'nullable|string', // Quill sends HTML
            'is_published' => 'required|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            // 'slug' => 'nullable|string|max:255|unique:pages,slug,'.$page->id, // Optional
        ]);

        // The Page model's boot method should handle slug update if title changes
        // and no slug is manually entered and differs from the auto-generated one.
        // if ($request->filled('slug')) {
        //    $validatedData['slug'] = Str::slug($request->slug);
        // } elseif ($page->title !== $validatedData['title']) {
        //    // If title changed and slug was not manually provided, regenerate slug
        //    $validatedData['slug'] = Str::slug($validatedData['title']);
        // }
        // Ensure uniqueness if manually setting/changing slug (model boot method already does this for auto-generated)

        $page->update($validatedData);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        // Add any specific checks if certain pages should not be deletable (e.g., core pages like 'home' if managed here)
        // For example:
        // if (in_array($page->slug, ['home', 'about-us'])) {
        //     return redirect()->route('admin.pages.index')->with('error', 'This core page cannot be deleted.');
        // }

        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
}
