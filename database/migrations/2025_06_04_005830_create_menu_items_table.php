<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade'); // Belongs to a menu
            $table->string('title'); // e.g., "Home", "About Us"
            $table->enum('link_type', ['route', 'url', 'page_slug'])->default('url');
            // 'route' -> value is a named route like 'home', 'contact'
            // 'url' -> value is an absolute URL like 'https://example.com'
            // 'page_slug' -> value is a slug from your 'pages' table, e.g., 'about-our-company'
            $table->string('link_value');
            $table->unsignedBigInteger('parent_id')->nullable(); // For sub-items (nested menus)
            $table->integer('order')->default(0); // To control display order
            $table->string('target')->default('_self'); // e.g., _self, _blank
            $table->string('icon_class')->nullable(); // Optional: For Font Awesome class e.g., 'fas fa-home'
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign key for parent_id (self-referencing)
            $table->foreign('parent_id')->references('id')->on('menu_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
