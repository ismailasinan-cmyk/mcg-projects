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
            'public_dir_contents' => scandir(public_path()),
            'storage_dir_exists' => File::exists(storage_path('app/public')),
            'storage_dir_contents' => File::exists(storage_path('app/public')) ? scandir(storage_path('app/public')) : 'dir_not_found',
            'images_projects_dir_contents' => File::exists(storage_path('app/public/images/projects')) ? scandir(storage_path('app/public/images/projects')) : 'dir_not_found',
            'example_projects' => \App\Models\Project::with('images')->whereHas('images')->get()->map(function($p) {
                $firstImage = $p->images->first();
                $imagePath = $firstImage ? ltrim($firstImage->image_path, '/') : null;
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'db_image_path' => $imagePath,
                    'exists_in_public' => $imagePath && File::exists(public_path($imagePath)),
                    'exists_in_storage' => $imagePath && Storage::disk('public')->exists($imagePath),
                    'final_url' => $p->image_url ?: ($firstImage ? $firstImage->image_url : null),
                ];
            }),
            'server_protocol' => isset($_SERVER['HTTPS']) ? 'https' : 'http',
        ]);
    }
}
