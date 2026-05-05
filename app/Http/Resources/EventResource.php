<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Event
 */
class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_fr' => $this->title_fr,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'excerpt_fr' => $this->excerpt_fr,
            'description' => $this->description,
            'description_fr' => $this->description_fr,
            'badge' => $this->badge,
            'featured' => (bool) $this->featured,
            'image_url' => $this->image_path ? asset('storage/'.$this->image_path) : null,
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null,
            'starts_at' => $this->starts_at?->toIso8601String(),
            'ends_at' => $this->ends_at?->toIso8601String(),
            'location' => $this->location,
            'is_online' => (bool) $this->is_online,
            'registration_url' => $this->registration_url,
            'published_at' => $this->created_at?->toIso8601String(),
            $this->mergeWhen((bool) $request->user(), [
                'image_path' => $this->image_path,
                'category_id' => $this->category_id,
                'is_published' => (bool) $this->is_published,
            ]),
        ];
    }
}

