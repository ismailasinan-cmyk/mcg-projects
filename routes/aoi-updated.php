<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Project;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Get project statistics
Route::get('/projects/statistics', function () {
    return response()->json([
        'total' => Project::count(),
        'ongoing' => Project::where('status', 'ongoing')->count(),
        'completed' => Project::where('status', 'completed')->count(),
        'suspended' => Project::where('status', 'suspended')->count(),
        'operational' => Project::where('status', 'operation')->count(),
    ]);
});

// Get states that have projects
Route::get('/projects/states-with-projects', function () {
    return response()->json(
        Project::distinct()->pluck('state')->toArray()
    );
});

// Get projects by state
Route::get('/projects/state/{state}', function ($state) {
    $projects = Project::where('state', $state)
        ->with('images')
        ->select('id', 'name', 'state', 'status')
        ->get();

    return response()->json($projects);
});

// Get single project details with images
Route::get('/projects/{id}', function ($id) {
    $project = Project::with('images')->findOrFail($id);

    // Format images as array of paths
    $imagePaths = $project->images->pluck('image_path')->toArray();

    return response()->json([
        'id' => $project->id,
        'name' => $project->name,
        'state' => $project->state,
        'status' => $project->status,
        'description' => $project->description,
        'images' => $imagePaths, // Array of image filenames
    ]);
});