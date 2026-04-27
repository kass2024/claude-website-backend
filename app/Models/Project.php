<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'title_fr',
        'slug',
        'category',
        'category_fr',
        'client_name',
        'country',
        'short_description',
        'short_description_fr',
        'full_description',
        'full_description_fr',
        'cover_image_path',
        'gallery_paths',
        'completion_date',
        'is_published',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'gallery_paths' => 'array',
        'completion_date' => 'date',
        'is_published' => 'boolean',
    ];
}

