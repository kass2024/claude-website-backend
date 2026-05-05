<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Event::query()
            ->with('category')
            ->where('is_published', true);

        if ($request->filled('upcoming')) {
            $query->where('starts_at', '>=', now()->subDays(1));
        }

        if ($request->filled('category')) {
            $categorySlug = $request->string('category')->toString();
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        if ($request->filled('featured')) {
            $query->where('featured', true);
        }

        return EventResource::collection(
            $query->orderBy('starts_at')->orderByDesc('featured')->orderByDesc('id')->get()
        );
    }

    public function show(Event $event): EventResource
    {
        abort_unless($event->is_published, 404);
        $event->loadMissing('category');
        return EventResource::make($event);
    }
}

