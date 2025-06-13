<?php

namespace App\Http\Controllers;

use App\Models\Page;    // Import the Page model
use App\Models\HeroSlide; // Import the HeroSlide model
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        // Fetch active hero slides, ordered by the 'order' column
        $heroSlides = HeroSlide::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        // You might want to fetch other specific data for the homepage here later
        return view('home', compact('heroSlides')); // Pass heroSlides to the view
    }

    public function about(): View
    {
        // If you want 'About Us' to be a dynamic page from the 'pages' table:
        // try {
        //     $page = Page::where('slug', 'about-us')->where('is_published', true)->firstOrFail();
        //     return view('pages.show', compact('page'));
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        //     abort(404);
        // }
        return view('about'); // Current static view
    }

    // public function contact(): View
    // {
    //     // If you want 'Contact Us' to be a dynamic page:
    //     // try {
    //     //     $page = Page::where('slug', 'contact-us')->where('is_published', true)->firstOrFail();
    //     //     return view('pages.show', compact('page'));
    //     // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //     //     abort(404);
    //     // }
    //     return view('contact'); // Current static view
    // }

    public function contact()
    {
        return view('contact', [
            'globalSocialFacebookUrl' => config('site.facebook'), // or hardcode or fetch from DB
            'globalSocialTwitterUrl' => config('site.twitter'),
            'globalSocialLinkedinUrl' => config('site.linkedin'),
            'globalSocialInstagramUrl' => config('site.instagram'),
            'globalContactEmail' => 'contact@itezsoft.com', // Replace with actual email
            'globalContactPhone' => '+8801234567890',       // Replace with actual phone
        ]);
    }
    public function careers(): View
    {
        return view('careers.index');
    }

    // Service Pages (Can also be converted to dynamic pages if desired)
    public function graphicsDesign(): View
    {
        return view('services.graphics');
    }

    public function posSolutions(): View
    {
        return view('services.pos');
    }

    public function websiteDesign(): View
    {
        return view('services.webdesign');
    }

    public function digitalSolutions(): View
    {
        return view('services.digital');
    }

    /**
     * Display a dynamic page from the 'pages' table by its slug.
     *
     * @param  \App\Models\Page  $page (Route model binding by slug)
     * @return \Illuminate\View\View
     */
    public function showDynamicPage(Page $page) // Route model binding will find the page by its slug
    {
        // Ensure the page is published
        if (!$page->is_published) {
            abort(404);
        }

        // The 'pages.show' view will be created next to display the page content
        return view('pages.show', compact('page'));
    }
}
