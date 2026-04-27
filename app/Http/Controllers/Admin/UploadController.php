<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Store an uploaded file under storage/app/public/uploads/{folder}.
     *
     * Returns { path, url }.
     *
     * @return array<string, string>
     */
    public function store(Request $request): array
    {
        $data = $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'folder' => ['required', 'string'],
        ]);

        $folder = (string) $data['folder'];
        abort_unless(in_array($folder, ['board-members', 'partners'], true), 422);

        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $request->file('file');

        $path = $file->store("uploads/{$folder}", 'public');

        return [
            'path' => $path,
            // serve via /files/* to avoid relying on storage:link
            'url' => url('/files/'.$path),
        ];
    }
}

