<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ServiceController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ServiceResource::collection(
            Service::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get()
        );
    }

    public function show(Service $service): ServiceResource
    {
        abort_unless((bool) $service->is_published, 404);

        return ServiceResource::make($service);
    }
}

