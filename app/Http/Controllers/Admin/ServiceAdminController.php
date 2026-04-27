<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ServiceAdminController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ServiceResource::collection(
            Service::query()->orderBy('sort_order')->orderBy('title')->get()
        );
    }

    public function store(Request $request): ServiceResource
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:services,slug'],
            'short_description' => ['required', 'string', 'max:500'],
            'short_description_fr' => ['nullable', 'string', 'max:500'],
            'full_description' => ['required', 'string'],
            'full_description_fr' => ['nullable', 'string'],
            'sections' => ['nullable', 'array'],
            'sections.*.title' => ['required_with:sections', 'string', 'max:255'],
            'sections.*.title_fr' => ['nullable', 'string', 'max:255'],
            'sections.*.body' => ['required_with:sections', 'string'],
            'sections.*.body_fr' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $service = Service::query()->create($data);

        return ServiceResource::make($service);
    }

    public function show(Service $service): ServiceResource
    {
        return ServiceResource::make($service);
    }

    public function update(Request $request, Service $service): ServiceResource
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', 'unique:services,slug,'.$service->id],
            'short_description' => ['sometimes', 'required', 'string', 'max:500'],
            'short_description_fr' => ['nullable', 'string', 'max:500'],
            'full_description' => ['sometimes', 'required', 'string'],
            'full_description_fr' => ['nullable', 'string'],
            'sections' => ['nullable', 'array'],
            'sections.*.title' => ['required_with:sections', 'string', 'max:255'],
            'sections.*.title_fr' => ['nullable', 'string', 'max:255'],
            'sections.*.body' => ['required_with:sections', 'string'],
            'sections.*.body_fr' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $service->update($data);

        return ServiceResource::make($service);
    }

    public function destroy(Service $service): Response
    {
        $service->delete();

        return response()->noContent();
    }
}

