<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BannerController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Banner::query()->where('is_published', true);

        $now = now();
        $query->where(function ($q) use ($now) {
            $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
        });

        return BannerResource::collection(
            $query->orderByDesc('featured')->orderByDesc('priority')->orderByDesc('id')->get()
        );
    }
}

