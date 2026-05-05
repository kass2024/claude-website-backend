<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
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
        'benefit',
        'benefit_fr',
        'badge',
        'featured',
        'image_path',
        'category_id',
        'starts_at',
        'expires_at',
        'is_published',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'is_published' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

