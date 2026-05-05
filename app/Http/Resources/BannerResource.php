<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Banner
 */
class BannerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_fr' => $this->title_fr,
            'message' => $this->message,
            'message_fr' => $this->message_fr,
            'badge' => $this->badge,
            'cta_label' => $this->cta_label,
            'cta_label_fr' => $this->cta_label_fr,
            'cta_url' => $this->cta_url,
            'featured' => (bool) $this->featured,
            'priority' => (int) $this->priority,
            'image_url' => $this->image_path ? asset('storage/'.$this->image_path) : null,
            'starts_at' => $this->starts_at?->toIso8601String(),
            'ends_at' => $this->ends_at?->toIso8601String(),
            'published_at' => $this->created_at?->toIso8601String(),
            $this->mergeWhen((bool) $request->user(), [
                'image_path' => $this->image_path,
                'is_published' => (bool) $this->is_published,
            ]),
        ];
    }
}

