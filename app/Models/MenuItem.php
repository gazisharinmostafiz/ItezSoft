<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route as RouteFacade; // Alias to avoid conflict
use App\Models\Page; // If using 'page_slug' link type

class MenuItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'menu_id',
        'title',
        'link_type',
        'link_value',
        'parent_id',
        'order',
        'target',
        'icon_class',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the menu that this item belongs to.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Get the parent menu item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Get the direct children menu items (for submenus), ordered correctly.
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order', 'asc');
    }

    /**
     * Get all children menu items recursively, ordered correctly at each level.
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
        // The orderBy('order', 'asc') is already on the children() relationship,
        // so it will be applied at each level of the recursion.
    }


    /**
     * Check if this menu item has children.
     */
    public function hasChildren(): bool
    {
        // Check the loaded relationship if available, otherwise query
        if ($this->relationLoaded('childrenRecursive')) {
            return $this->childrenRecursive->isNotEmpty();
        }
        if ($this->relationLoaded('children')) {
            return $this->children->isNotEmpty();
        }
        return $this->children()->count() > 0;
    }

    /**
     * Get the actual URL for the menu item based on its type.
     *
     * @return string
     */
    public function getUrl(): string
    {
        switch ($this->link_type) {
            case 'route':
                if (RouteFacade::has($this->link_value)) {
                    try {
                        // Attempt to generate route. Handle potential missing parameters gracefully.
                        // For routes without parameters, this is fine.
                        // For routes with parameters, this might fail if parameters aren't provided
                        // or if the link_value doesn't contain necessary parameter info.
                        // This basic example assumes routes don't require parameters for the menu.
                        return route($this->link_value);
                    } catch (\Exception $e) {
                        // Log error or handle missing parameters for named routes
                        return '#_route_error_[' . e($this->link_value) . ']';
                    }
                }
                return '#_route_not_found_[' . e($this->link_value) . ']';
            case 'page_slug':
                $page = Page::where('slug', $this->link_value)->where('is_published', true)->first();
                if ($page && RouteFacade::has('page.show')) {
                    return route('page.show', $this->link_value);
                }
                return '#_page_not_found_[' . e($this->link_value) . ']';
            case 'url':
            default:
                return filter_var($this->link_value, FILTER_VALIDATE_URL) ? $this->link_value : '#_invalid_url';
        }
    }
}
