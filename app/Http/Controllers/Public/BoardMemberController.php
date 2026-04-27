<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardMemberResource;
use App\Models\BoardMember;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BoardMemberController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BoardMemberResource::collection(
            BoardMember::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
        );
    }
}
