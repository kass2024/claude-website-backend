<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_fr',
        'tagline',
        'tagline_fr',
        'website_url',
        'logo_path',
        'sort_order',
        'is_published',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
        'deleted_at' => 'datetime',
    ];
}

