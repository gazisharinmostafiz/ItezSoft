<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Import DB facade

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // e.g., string, boolean, image_path, json, integer
            $table->timestamps();
        });

        DB::table('settings')->insert([
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image_path',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_name',
                'value' => config('app.name', 'ItezSoft'),
                'type' => 'string',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_copyright_text',
                'value' => '© ' . date('Y') . ' ' . config('app.name', 'ItezSoft') . '. All rights reserved.',
                'type' => 'string',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@itezsoft.com',
                'type' => 'string',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_phone',
                'value' => '+44 XXXXXXXXXX',
                'type' => 'string',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_facebook_url',
                'value' => null,
                'type' => 'url',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_twitter_url',
                'value' => null,
                'type' => 'url',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_linkedin_url',
                'value' => null,
                'type' => 'url',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'social_instagram_url',
                'value' => null,
                'type' => 'url',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Slider Settings
            [
                'key' => 'slider_autoplay',
                'value' => '1', // 1 for true (on), 0 for false (off)
                'type' => 'boolean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slider_duration',
                'value' => '5000', // Default 5000 milliseconds (5 seconds)
                'type' => 'integer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'slider_navigation_dots',
                'value' => '1', // 1 for true (show dots), 0 for false (hide dots)
                'type' => 'boolean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
