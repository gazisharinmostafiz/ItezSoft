<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import Storage facade for file operations

class HeroSlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = HeroSlide::orderBy('order')->paginate(10);
        return view('admin.hero_slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero_slides.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'main_headline' => 'required|string|max:255',
            'sub_headline' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'text_color' => 'nullable|string|max:7', // For hex color like #FFFFFF
            'order' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'background_image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validation for image
        ]);

        if ($request->hasFile('background_image_path')) {
            // Store in 'public/hero_slides_backgrounds' directory
            // Ensure you've run `php artisan storage:link`
            $path = $request->file('background_image_path')->store('hero_slides_backgrounds', 'public');
            $validatedData['background_image_path'] = $path; // Store the path
        }

        HeroSlide::create($validatedData);

        return redirect()->route('admin.hero_slides.index')->with('success', 'Hero slide created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroSlide $heroSlide)
    {
        return view('admin.hero_slides.edit', compact('heroSlide')); // Or a dedicated show view if you prefer
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero_slides.edit', compact('heroSlide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validatedData = $request->validate([
            'main_headline' => 'required|string|max:255',
            'sub_headline' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'text_color' => 'nullable|string|max:7',
            'order' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'background_image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // For new image uploads
            'remove_background_image' => 'nullable|boolean', // For removing existing image
        ]);

        // Handle background image upload/removal
        if ($request->input('remove_background_image')) {
            if ($heroSlide->background_image_path) {
                Storage::disk('public')->delete($heroSlide->background_image_path);
                $validatedData['background_image_path'] = null; // Set to null in database
            }
        } elseif ($request->hasFile('background_image_path')) {
            // Delete old image if it exists and a new one is uploaded
            if ($heroSlide->background_image_path) {
                Storage::disk('public')->delete($heroSlide->background_image_path);
            }
            // Store new image
            $path = $request->file('background_image_path')->store('hero_slides_backgrounds', 'public');
            $validatedData['background_image_path'] = $path;
        }
        // If neither remove_background_image is checked nor a new file is uploaded,
        // $validatedData will not contain 'background_image_path', so the existing one remains.


        $heroSlide->update($validatedData);

        return redirect()->route('admin.hero_slides.index')->with('success', 'Hero slide updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroSlide $heroSlide)
    {
        // Delete associated background image from storage if it exists
        if ($heroSlide->background_image_path) {
            Storage::disk('public')->delete($heroSlide->background_image_path);
        }

        $heroSlide->delete();
        return redirect()->route('admin.hero_slides.index')->with('success', 'Hero slide deleted successfully.');
    }
}
