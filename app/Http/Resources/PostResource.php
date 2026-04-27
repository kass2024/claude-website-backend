<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Post
 */
class PostResource extends JsonResource
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
            'excerpt' => $this->excerpt,
            'excerpt_fr' => $this->excerpt_fr,
            'content' => $this->content,
            'content_fr' => $this->content_fr,
            'featured_image_url' => $this->featured_image_path ? asset('storage/'.$this->featured_image_path) : null,
            'category' => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null,
            'published_at' => $this->published_at?->toIso8601String(),
            $this->mergeWhen((bool) $request->user(), [
                'featured_image_path' => $this->featured_image_path,
                'category_id' => $this->category_id,
                'author_id' => $this->author_id,
            ]),
        ];
    }
}

