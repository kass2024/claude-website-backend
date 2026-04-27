<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactMessageAdminController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = ContactMessage::query()->orderByDesc('id');

        if ($request->filled('email')) {
            $query->where('email', $request->string('email')->toString());
        }

        return JsonResource::collection($query->paginate(25));
    }

    public function show(ContactMessage $contactMessage): JsonResource
    {
        return JsonResource::make($contactMessage);
    }
}

