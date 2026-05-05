<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OfferController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Offer::query()
            ->with('category')
            ->where('is_published', true);

        if ($request->filled('active')) {
            $now = now();
            $query->where(function ($q) use ($now) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })->where(function ($q) use ($now) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', $now);
            });
        }

        if ($request->filled('category')) {
            $categorySlug = $request->string('category')->toString();
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        if ($request->filled('featured')) {
            $query->where('featured', true);
        }

        return OfferResource::collection(
            $query->orderByDesc('featured')->orderByDesc('starts_at')->orderByDesc('id')->get()
        );
    }

    public function show(Offer $offer): OfferResource
    {
        abort_unless($offer->is_published, 404);
        $offer->loadMissing('category');
        return OfferResource::make($offer);
    }
}

