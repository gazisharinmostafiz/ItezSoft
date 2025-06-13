<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController; // For static AND dynamic frontend pages
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\MenuItemController as AdminMenuItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Frontend Static Page Routes (handled by PageController)
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/careers', [PageController::class, 'careers'])->name('careers.index');

Route::prefix('services')->name('services.')->group(function () {
    Route::get('/graphics-design', [PageController::class, 'graphicsDesign'])->name('graphics');
    Route::get('/pos-solutions', [PageController::class, 'posSolutions'])->name('pos');
    Route::get('/website-design', [PageController::class, 'websiteDesign'])->name('webdesign');
    Route::get('/digital-solutions', [PageController::class, 'digitalSolutions'])->name('digital');
});

// Frontend Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');


// Jetstream Authenticated Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


// Admin Routes - Protected
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'is_admin'])
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('posts', AdminPostController::class);
        Route::resource('users', AdminUserController::class);
        Route::resource('pages', AdminPageController::class);
        Route::resource('hero-slides', AdminHeroSlideController::class);
        
        // Menu Management Routes
        Route::resource('menus', AdminMenuController::class); 
        
        // Nested Resource Routes for Menu Items
        // Removed ->shallow() to ensure routes like admin.menus.items.edit are fully nested
        // and expect both {menu} and {menu_item} parameters, matching the controller and view.
        Route::resource('menus.items', AdminMenuItemController::class)
             ->parameters(['items' => 'menu_item']); 

        // You might add a route for reordering items later:
        // Route::post('menus/{menu}/items/reorder', [AdminMenuItemController::class, 'updateOrder'])->name('menus.items.reorder');


        // Site Settings Routes
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });

// Frontend Route for Dynamic Pages
Route::get('/{page:slug}', [PageController::class, 'showDynamicPage'])->name('page.show');

