<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProjectAdminController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProjectResource::collection(
            Project::query()->orderByDesc('completion_date')->orderByDesc('id')->get()
        );
    }

    public function store(Request $request): ProjectResource
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:projects,slug'],
            'category' => ['required', 'string', 'max:255'],
            'category_fr' => ['nullable', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:100'],
            'short_description' => ['required', 'string', 'max:500'],
            'short_description_fr' => ['nullable', 'string', 'max:500'],
            'full_description' => ['required', 'string'],
            'full_description_fr' => ['nullable', 'string'],
            'cover_image_path' => ['nullable', 'string', 'max:255'],
            'gallery_paths' => ['nullable', 'array'],
            'gallery_paths.*' => ['string', 'max:255'],
            'completion_date' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $project = Project::query()->create($data);

        return ProjectResource::make($project);
    }

    public function show(Project $project): ProjectResource
    {
        return ProjectResource::make($project);
    }

    public function update(Request $request, Project $project): ProjectResource
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'title_fr' => ['nullable', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', 'unique:projects,slug,'.$project->id],
            'category' => ['sometimes', 'required', 'string', 'max:255'],
            'category_fr' => ['nullable', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:100'],
            'short_description' => ['sometimes', 'required', 'string', 'max:500'],
            'short_description_fr' => ['nullable', 'string', 'max:500'],
            'full_description' => ['sometimes', 'required', 'string'],
            'full_description_fr' => ['nullable', 'string'],
            'cover_image_path' => ['nullable', 'string', 'max:255'],
            'gallery_paths' => ['nullable', 'array'],
            'gallery_paths.*' => ['string', 'max:255'],
            'completion_date' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $project->update($data);

        return ProjectResource::make($project);
    }

    public function destroy(Project $project): Response
    {
        $project->delete();

        return response()->noContent();
    }
}

