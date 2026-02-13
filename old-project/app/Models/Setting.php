<?php
/**
 * Application Setting Model
 * 
 * Purpose: Manages persistent configuration key-value pairs.
 * 
 * Features: 
 * - Support for multiple data types (string, boolean, json, etc.)
 * - Optional encryption for sensitive values (API keys, secrets).
 * - Automatic cache busting via Eloquent events (if implemented, else handled by Helper).
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSetting
 */
class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'options',
        'label',
        'description',
        'is_encrypted',
        'is_public',
        'sort_order',
    ];

    protected $casts = [
        'is_encrypted' => 'boolean',
        'is_public' => 'boolean',
        'options' => 'array',
    ];
}
