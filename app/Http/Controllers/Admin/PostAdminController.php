<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PostAdminController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(
            Post::query()->with('category')->orderByDesc('published_at')->orderByDesc('id')->get()
        );
    }

    public function store(Request $request): PostResource
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'excerpt' => ['required', 'string', 'max:500'],
            'excerpt_fr' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'content_fr' => ['nullable', 'string'],
            'featured_image_path' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'author_id' => ['nullable', 'integer', 'exists:users,id'],
            'published_at' => ['nullable', 'date'],
        ]);

        $post = Post::query()->create($data);
        $post->loadMissing('category');

        return PostResource::make($post);
    }

    public function show(Post $post): PostResource
    {
        $post->loadMissing('category');
        return PostResource::make($post);
    }

    public function update(Request $request, Post $post): PostResource
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', 'unique:posts,slug,'.$post->id],
            'excerpt' => ['sometimes', 'required', 'string', 'max:500'],
            'excerpt_fr' => ['nullable', 'string', 'max:500'],
            'content' => ['sometimes', 'required', 'string'],
            'content_fr' => ['nullable', 'string'],
            'featured_image_path' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'author_id' => ['nullable', 'integer', 'exists:users,id'],
            'published_at' => ['nullable', 'date'],
        ]);

        $post->update($data);
        $post->loadMissing('category');

        return PostResource::make($post);
    }

    public function destroy(Post $post): Response
    {
        $post->delete();
        return response()->noContent();
    }
}

