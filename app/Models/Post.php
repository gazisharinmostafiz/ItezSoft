<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import Str for slug generation

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'featured_image',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Optional: Automatically generate a slug when a title is set
    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
                // Ensure slug is unique
                $originalSlug = $post->slug;
                $count = 1;
                while (static::whereSlug($post->slug)->exists()) {
                    $post->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug_manually_set)) { // slug_manually_set is a hypothetical flag if you allow manual slug edits
                $post->slug = Str::slug($post->title);
                $originalSlug = $post->slug;
                $count = 1;
                while (static::whereSlug($post->slug)->where('id', '!=', $post->id)->exists()) {
                    $post->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });
    }

    // Optional: Define relationship to User model (if you have authors)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Alias for author for better readability
    public function author()
    {
        // return $this->user();
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}