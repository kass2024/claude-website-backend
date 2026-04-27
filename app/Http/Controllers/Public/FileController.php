<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function show(string $path): StreamedResponse
    {
        $path = ltrim($path, '/');
        abort_unless(str_starts_with($path, 'uploads/board-members/')
            || str_starts_with($path, 'uploads/partners/'), 404);

        abort_unless(Storage::disk('public')->exists($path), 404);

        $res = Storage::disk('public')->response($path);
        $res->headers->set('Access-Control-Allow-Origin', '*');
        return $res;
    }
}

