<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PartnerAdminController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PartnerResource::collection(
            Partner::query()->orderBy('sort_order')->orderBy('name')->get()
        );
    }

    public function store(Request $request): PartnerResource
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_fr' => ['nullable', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'tagline_fr' => ['nullable', 'string', 'max:255'],
            'website_url' => ['nullable', 'string', 'max:500'],
            'logo_path' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $partner = Partner::query()->create($data);

        return PartnerResource::make($partner);
    }

    public function show(Partner $partner): PartnerResource
    {
        return PartnerResource::make($partner);
    }

    public function update(Request $request, Partner $partner): PartnerResource
    {
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'name_fr' => ['nullable', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'tagline_fr' => ['nullable', 'string', 'max:255'],
            'website_url' => ['nullable', 'string', 'max:500'],
            'logo_path' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $partner->update($data);

        return PartnerResource::make($partner->fresh());
    }

    public function destroy(Partner $partner): Response
    {
        $partner->delete();

        return response()->noContent();
    }
}

