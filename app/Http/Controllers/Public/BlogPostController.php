<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogPostController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Post::query()
            ->with('category')
            ->whereNotNull('published_at');

        if ($request->filled('category')) {
            $categorySlug = $request->string('category')->toString();
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        return PostResource::collection(
            $query->orderByDesc('published_at')->orderByDesc('id')->get()
        );
    }

    public function show(Post $post): PostResource
    {
        abort_unless($post->published_at !== null, 404);

        $post->loadMissing('category');

        return PostResource::make($post);
    }
}

