<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Project::query()->where('is_published', true);

        if ($request->filled('category')) {
            $query->where('category', $request->string('category')->toString());
        }

        if ($request->filled('country')) {
            $query->where('country', $request->string('country')->toString());
        }

        return ProjectResource::collection(
            $query->orderByDesc('completion_date')->orderByDesc('id')->get()
        );
    }

    public function show(Project $project): ProjectResource
    {
        abort_unless((bool) $project->is_published, 404);

        return ProjectResource::make($project);
    }
}

