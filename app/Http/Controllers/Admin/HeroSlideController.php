<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; 
// use Illuminate\Support\Facades\URL; // Not strictly needed if using redirect() with path

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
            'text_color' => 'nullable|string|max:7',
            'order' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'background_image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('background_image_path')) {
            $path = $request->file('background_image_path')->store('hero_slides_backgrounds', 'public');
            $validatedData['background_image_path'] = $path;
        }

        HeroSlide::create($validatedData);

        return redirect('/admin/hero-slides')->with('success', 'Hero slide created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroSlide $heroSlide)
    {
        // For admin, typically redirect to edit or show a simplified view.
        return view('admin.hero_slides.edit', compact('heroSlide'));
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
            'background_image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'remove_background_image' => 'nullable|boolean',
        ]);

        if ($request->input('remove_background_image')) {
            if ($heroSlide->background_image_path) {
                Storage::disk('public')->delete($heroSlide->background_image_path);
                $validatedData['background_image_path'] = null;
            }
        } elseif ($request->hasFile('background_image_path')) {
            if ($heroSlide->background_image_path) {
                Storage::disk('public')->delete($heroSlide->background_image_path);
            }
            $path = $request->file('background_image_path')->store('hero_slides_backgrounds', 'public');
            $validatedData['background_image_path'] = $path;
        }
        // Note: If 'background_image_path' is not in $validatedData (e.g. no new image, not removing),
        // the existing $heroSlide->background_image_path will be preserved during update.
        // To be explicit if $validatedData doesn't contain it and you don't want to change it:
        // unset($validatedData['background_image_path']); // if it's not set in request

        $heroSlide->update($validatedData);
        return redirect('/admin/hero-slides')->with('success', 'Hero slide updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->background_image_path) {
            Storage::disk('public')->delete($heroSlide->background_image_path);
        }
        $heroSlide->delete();

        // Logging for debug, can be removed once confirmed working
        Log::info('Hero slide ID ' . $heroSlide->id . ' deleted. Attempting redirect to /admin/hero-slides.');

        return redirect('/admin/hero-slides')->with('success', 'Hero slide deleted successfully.');
    }
}
