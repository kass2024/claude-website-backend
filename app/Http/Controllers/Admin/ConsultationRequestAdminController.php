<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationRequestAdminController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = ConsultationRequest::query()->orderByDesc('id');

        if ($request->filled('email')) {
            $query->where('email', $request->string('email')->toString());
        }

        return JsonResource::collection($query->paginate(25));
    }

    public function show(ConsultationRequest $consultationRequest): JsonResource
    {
        return JsonResource::make($consultationRequest);
    }
}

