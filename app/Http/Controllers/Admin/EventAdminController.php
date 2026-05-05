<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EventAdminController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return EventResource::collection(
            Event::query()->with('category')->orderBy('starts_at')->orderByDesc('featured')->orderByDesc('id')->get()
        );
    }

    public function store(Request $request): EventResource
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:events,slug'],
            'excerpt' => ['required', 'string', 'max:500'],
            'excerpt_fr' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'description_fr' => ['nullable', 'string'],
            'badge' => ['nullable', 'string', 'max:50'],
            'featured' => ['nullable', 'boolean'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_online' => ['nullable', 'boolean'],
            'registration_url' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $event = Event::query()->create($data);
        $event->loadMissing('category');
        return EventResource::make($event);
    }

    public function show(Event $event): EventResource
    {
        $event->loadMissing('category');
        return EventResource::make($event);
    }

    public function update(Request $request, Event $event): EventResource
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', 'unique:events,slug,'.$event->id],
            'excerpt' => ['sometimes', 'required', 'string', 'max:500'],
            'excerpt_fr' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'description_fr' => ['nullable', 'string'],
            'badge' => ['nullable', 'string', 'max:50'],
            'featured' => ['nullable', 'boolean'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'starts_at' => ['sometimes', 'required', 'date'],
            'ends_at' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_online' => ['nullable', 'boolean'],
            'registration_url' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $event->update($data);
        $event->loadMissing('category');
        return EventResource::make($event);
    }

    public function destroy(Event $event): Response
    {
        $event->delete();
        return response()->noContent();
    }
}

