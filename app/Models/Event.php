<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_fr',
        'slug',
        'excerpt',
        'excerpt_fr',
        'description',
        'description_fr',
        'badge',
        'featured',
        'image_path',
        'category_id',
        'starts_at',
        'ends_at',
        'location',
        'is_online',
        'registration_url',
        'is_published',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'is_online' => 'boolean',
        'is_published' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

