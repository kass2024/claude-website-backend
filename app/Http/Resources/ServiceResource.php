<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Service
 */
class ServiceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_fr' => $this->title_fr,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'short_description_fr' => $this->short_description_fr,
            'full_description' => $this->full_description,
            'full_description_fr' => $this->full_description_fr,
            'sections' => is_array($this->sections) ? $this->sections : [],
            'icon' => $this->icon,
            'image_url' => $this->image_path ? asset('storage/'.$this->image_path) : null,
            $this->mergeWhen((bool) $request->user(), [
                'image_path' => $this->image_path,
                'sort_order' => $this->sort_order,
                'is_published' => (bool) $this->is_published,
            ]),
        ];
    }
}

