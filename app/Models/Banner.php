<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_fr',
        'message',
        'message_fr',
        'badge',
        'cta_label',
        'cta_label_fr',
        'cta_url',
        'image_path',
        'featured',
        'priority',
        'starts_at',
        'ends_at',
        'is_published',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'priority' => 'integer',
        'is_published' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
}

