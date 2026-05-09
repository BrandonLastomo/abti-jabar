<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterContent extends Model
{
    protected $fillable = [
        'key',
        'label',
        'value',
        'type',
        'sort_order',
    ];

    /**
     * Get all footer content items keyed by their 'key' field.
     * Used in views to easily access: $footer['org_name']->value
     */
    public static function getAll()
    {
        return self::orderBy('sort_order')->get()->keyBy('key');
    }
}
