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
            $table->string('type')->default('string');
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
                'value' => 'info@itezsoft.com', // Default contact email
                'type' => 'string',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_phone',
                'value' => '+44 XXXXXXXXXX', // Default contact phone
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
            ]
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
