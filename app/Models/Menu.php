<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get all menu items associated with this menu, ordered correctly.
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('order', 'asc');
    }

    /**
     * Get only the top-level (parent) menu items for this menu.
     */
    public function parentItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)
                    ->whereNull('parent_id') // Only items with no parent
                    ->orderBy('order', 'asc');
    }
}
