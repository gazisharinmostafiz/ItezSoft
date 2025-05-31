<?php
// In app/Models/Page.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Auto-generate slug
    public static function boot()
    {
        parent::boot();
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
                $originalSlug = $page->slug;
                $count = 1;
                while (static::whereSlug($page->slug)->exists()) {
                    $page->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });

        static::updating(function ($page) {
            if ($page->isDirty('title') && empty($page->slug_manually_set)) { // Check a flag if you allow manual slug edits
                $page->slug = Str::slug($page->title);
                $originalSlug = $page->slug;
                $count = 1;
                while (static::whereSlug($page->slug)->where('id', '!=', $page->id)->exists()) {
                    $page->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });
    }
}