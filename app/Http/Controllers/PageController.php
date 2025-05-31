<?php

namespace App\Http\Controllers; // This is the correct namespace

use App\Models\Page; // Import the Page model
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        // You might want to fetch specific settings or data for the homepage here later
        return view('home');
    }

    public function about(): View
    {
        // Example of converting 'About Us' to a dynamic page:
        // try {
        //     $page = Page::where('slug', 'about-us')->where('is_published', true)->firstOrFail();
        //     return view('pages.show', compact('page'));
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        //     abort(404);
        // }
        return view('about'); // Current static view
    }

    public function contact(): View
    {
        return view('contact');
    }

    public function careers(): View
    {
        return view('careers.index');
    }

    // Service Pages
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
     */
    public function showDynamicPage(Page $page) // Route model binding will find the page by its slug
    {
        // Ensure the page is published
        if (!$page->is_published) {
            abort(404);
        }
        return view('pages.show', compact('page'));
    }
}