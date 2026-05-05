<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BannerAdminController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BannerResource::collection(
            Banner::query()->orderByDesc('featured')->orderByDesc('priority')->orderByDesc('id')->get()
        );
    }

    public function store(Request $request): BannerResource
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:500'],
            'message_fr' => ['nullable', 'string', 'max:500'],
            'badge' => ['nullable', 'string', 'max:50'],
            'cta_label' => ['nullable', 'string', 'max:100'],
            'cta_label_fr' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'string', 'max:500'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'featured' => ['nullable', 'boolean'],
            'priority' => ['nullable', 'integer', 'min:0'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $banner = Banner::query()->create($data);
        return BannerResource::make($banner);
    }

    public function show(Banner $banner): BannerResource
    {
        return BannerResource::make($banner);
    }

    public function update(Request $request, Banner $banner): BannerResource
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:500'],
            'message_fr' => ['nullable', 'string', 'max:500'],
            'badge' => ['nullable', 'string', 'max:50'],
            'cta_label' => ['nullable', 'string', 'max:100'],
            'cta_label_fr' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'string', 'max:500'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'featured' => ['nullable', 'boolean'],
            'priority' => ['nullable', 'integer', 'min:0'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $banner->update($data);
        return BannerResource::make($banner);
    }

    public function destroy(Banner $banner): Response
    {
        $banner->delete();
        return response()->noContent();
    }
}

