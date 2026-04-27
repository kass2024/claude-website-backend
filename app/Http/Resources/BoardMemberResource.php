<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\BoardMember
 */
class BoardMemberResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_fr' => $this->name_fr,
            'role' => $this->role,
            'role_fr' => $this->role_fr,
            'bio' => $this->bio,
            'bio_fr' => $this->bio_fr,
            'email' => $this->email,
            'phone' => $this->phone,
            'linkedin_url' => $this->linkedin_url,
            'image_url' => $this->image_path ? url('/files/'.$this->image_path) : null,
            'sort_order' => (int) $this->sort_order,
            'deleted_at' => $this->deleted_at? $this->deleted_at->format('Y-m-d H:i:s') : null,
            $this->mergeWhen((bool) $request->user(), [
                'image_path' => $this->image_path,
                'is_published' => (bool) $this->is_published,
            ]),
        ];
    }
}
