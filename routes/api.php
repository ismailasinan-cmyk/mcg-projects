<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Specific routes FIRST
Route::get('/projects/statistics', [ProjectController::class, 'getStatistics']);
Route::get('/projects/states-with-projects', [ProjectController::class, 'getStatesWithProjects']);
Route::get('/projects/state/{state}', [ProjectController::class, 'getByState']);

// Wildcard LAST
Route::get('/projects/{id}', [ProjectController::class, 'getProject']);
