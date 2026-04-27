<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardMember extends Model
{
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_fr',
        'role',
        'role_fr',
        'bio',
        'bio_fr',
        'email',
        'phone',
        'linkedin_url',
        'image_path',
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

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute(): string|null
    {
        if (!$this->image_path) {
            return null;
        }

        // If it's already a full URL, return as is
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        // Otherwise, construct the URL from the path
        return config('app.url') . '/storage/' . $this->image_path;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Log when a board member is deleted
        static::deleted(function ($boardMember) {
            \Log::info('Board member deleted from model event', [
                'id' => $boardMember->id,
                'name' => $boardMember->name,
                'hard_delete' => !$boardMember->trashed()
            ]);
        });

        // Log when a board member is force deleted
        static::forceDeleted(function ($boardMember) {
            \Log::info('Board member force deleted from model event', [
                'id' => $boardMember->id,
                'name' => $boardMember->name
            ]);
        });
    }
}
