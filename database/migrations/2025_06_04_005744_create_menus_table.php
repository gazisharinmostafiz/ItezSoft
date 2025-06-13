<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., 'Main Header Navigation', 'Footer Quick Links'
            $table->string('slug')->unique(); // e.g., 'main-header', 'footer-quick' (for easy fetching)
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Seed some default menus
        DB::table('menus')->insert([
            [
                'name' => 'Main Header Navigation',
                'slug' => 'main-header',
                'description' => 'The primary navigation menu displayed in the site header.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Footer Quick Links',
                'slug' => 'footer-quick-links',
                'description' => 'Quick links section in the site footer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // You can add more default menu locations if needed
            // [
            //     'name' => 'Footer Services Links',
            //     'slug' => 'footer-services',
            //     'description' => 'Services links section in the site footer.',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
