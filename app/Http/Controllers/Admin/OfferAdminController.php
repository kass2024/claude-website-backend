<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OfferAdminController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return OfferResource::collection(
            Offer::query()->with('category')->orderByDesc('featured')->orderByDesc('starts_at')->orderByDesc('id')->get()
        );
    }

    public function store(Request $request): OfferResource
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:offers,slug'],
            'excerpt' => ['required', 'string', 'max:500'],
            'excerpt_fr' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'description_fr' => ['nullable', 'string'],
            'benefit' => ['nullable', 'string', 'max:255'],
            'benefit_fr' => ['nullable', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:50'],
            'featured' => ['nullable', 'boolean'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $offer = Offer::query()->create($data);
        $offer->loadMissing('category');
        return OfferResource::make($offer);
    }

    public function show(Offer $offer): OfferResource
    {
        $offer->loadMissing('category');
        return OfferResource::make($offer);
    }

    public function update(Request $request, Offer $offer): OfferResource
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', 'unique:offers,slug,'.$offer->id],
            'excerpt' => ['sometimes', 'required', 'string', 'max:500'],
            'excerpt_fr' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'description_fr' => ['nullable', 'string'],
            'benefit' => ['nullable', 'string', 'max:255'],
            'benefit_fr' => ['nullable', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:50'],
            'featured' => ['nullable', 'boolean'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $offer->update($data);
        $offer->loadMissing('category');
        return OfferResource::make($offer);
    }

    public function destroy(Offer $offer): Response
    {
        $offer->delete();
        return response()->noContent();
    }
}

