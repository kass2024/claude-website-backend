<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Project
 */
class ProjectResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $gallery = is_array($this->gallery_paths) ? $this->gallery_paths : [];

        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_fr' => $this->title_fr,
            'slug' => $this->slug,
            'category' => $this->category,
            'category_fr' => $this->category_fr,
            'client_name' => $this->client_name,
            'country' => $this->country,
            'short_description' => $this->short_description,
            'short_description_fr' => $this->short_description_fr,
            'full_description' => $this->full_description,
            'full_description_fr' => $this->full_description_fr,
            'completion_date' => $this->completion_date?->toDateString(),
            'cover_image_url' => $this->cover_image_path ? asset('storage/'.$this->cover_image_path) : null,
            'gallery_image_urls' => array_values(array_filter(array_map(
                fn ($path) => is_string($path) && $path !== '' ? asset('storage/'.$path) : null,
                $gallery
            ))),
            $this->mergeWhen((bool) $request->user(), [
                'cover_image_path' => $this->cover_image_path,
                'gallery_paths' => $gallery,
                'is_published' => (bool) $this->is_published,
            ]),
        ];
    }
}

