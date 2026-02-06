<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DebugController extends Controller
{
    public function debugImages()
    {
        $testPath = 'images/projects/1770048299_0.jpg';
        
        return response()->json([
            'APP_URL' => config('app.url'),
            'APP_ENV' => config('app.env'),
            'public_path' => public_path(),
            'storage_path' => storage_path('app/public'),
            'symlink_exists' => File::exists(public_path('storage')),
            'symlink_is_link' => is_link(public_path('storage')),
            'test_file_in_public' => File::exists(public_path($testPath)),
            'test_file_size' => File::exists(public_path($testPath)) ? File::size(public_path($testPath)) : 0,
            'test_file_perms' => File::exists(public_path($testPath)) ? substr(sprintf('%o', fileperms(public_path($testPath))), -4) : 'none',
            'test_file_in_storage' => Storage::disk('public')->exists($testPath),
            'model_logic_test' => (function($path) {
                if (file_exists(public_path($path))) {
                    return secure_asset($path);
                }
                return secure_asset('storage/' . $path);
            })($testPath),
            'public_dir_contents' => scandir(public_path()),
            'example_projects' => \App\Models\Project::with('images')->take(3)->get()->map(function($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'image_url' => $p->image_url,
                    'images_count' => $p->images->count(),
                    'first_image_url' => $p->images->first()?->image_url,
                ];
            }),
            'server_protocol' => isset($_SERVER['HTTPS']) ? 'https' : 'http',
        ]);
    }
}
