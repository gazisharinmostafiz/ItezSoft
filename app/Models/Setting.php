<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache; // For caching settings

class Setting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // If you store JSON in the 'value' for certain types, you can cast it:
        // 'value' => 'array', // Example if 'type' is 'json'
    ];

    /**
     * The "booted" method of the model.
     *
     * Invalidate settings cache on save/delete.
     */
    protected static function booted(): void
    {
        static::saved(function (Setting $setting) {
            Cache::forget('site_settings'); // Invalidate cache when a setting is saved
            Cache::forget('setting_' . $setting->key); // Invalidate specific setting cache
        });

        static::deleted(function (Setting $setting) {
            Cache::forget('site_settings'); // Invalidate cache when a setting is deleted
            Cache::forget('setting_' . $setting->key);
        });
    }

    /**
     * Helper function to get a setting value by its key.
     * Caches the result for better performance.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValue(string $key, $default = null)
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            if ($setting) {
                // Optionally, handle type casting here based on $setting->type
                // For example, if $setting->type is 'boolean', convert '1'/'0' or 'true'/'false' to boolean.
                // If $setting->type is 'json', json_decode($setting->value).
                // For now, we return the raw value.
                return $setting->value;
            }
            return $default;
        });
    }

    /**
     * Helper function to get all settings, useful for a settings page or global config.
     * Caches the result.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getAllSettings()
    {
        return Cache::rememberForever('site_settings', function () {
            return self::all()->pluck('value', 'key'); // Returns a collection like ['key' => 'value', ...]
        });
    }

    /**
     * Helper function to set/update a setting value by its key.
     *
     * @param string $key
     * @param mixed $value
     * @param string $type (optional)
     * @return Setting
     */
    public static function setValue(string $key, $value, string $type = 'string'): Setting
    {
        // Optionally, handle type casting for saving here based on $type
        // For example, if $type is 'json', json_encode($value).
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
        return $setting;
    }
}
