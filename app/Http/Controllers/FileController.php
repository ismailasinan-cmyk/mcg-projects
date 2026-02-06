<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * Serve a file from the public storage disk.
     * This acts as a proxy when the storage symlink is broken or unavailable.
     */
    public function serve(string $path): StreamedResponse
    {
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return Storage::disk('public')->response($path, null, [
            'Cache-Control' => 'public, max-age=2592000, immutable',
            'Expires' => gmdate('D, d M Y H:i:s', time() + 2592000) . ' GMT',
        ]);
    }
}
