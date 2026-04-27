<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Partner
 */
class PartnerResource extends JsonResource
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
            'tagline' => $this->tagline,
            'tagline_fr' => $this->tagline_fr,
            'website_url' => $this->website_url,
            'logo_url' => $this->logo_path ? url('/files/'.$this->logo_path) : null,
            'sort_order' => (int) $this->sort_order,
            $this->mergeWhen((bool) $request->user(), [
                'logo_path' => $this->logo_path,
                'is_published' => (bool) $this->is_published,
            ]),
        ];
    }
}

