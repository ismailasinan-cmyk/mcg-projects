<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTrackingController;
use App\Http\Controllers\PasswordController;

// Public routes
Route::get('/', [ProjectController::class, 'showMap'])->name('home');
Route::get('/debug-images', [\App\Http\Controllers\DebugController::class, 'debugImages']);

// Auth routes
Auth::routes();

// Google Login Routes
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.redirect');

// Password change routes
Route::middleware(['auth'])->group(function () {
    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/change', [PasswordController::class, 'changePassword'])->name('password.perform_change');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ProjectController::class, 'dashboard'])->name('dashboard');

    // Export & Import routes
    Route::get('/projects/export', [ProjectController::class, 'exportProjects'])->name('projects.export');
    Route::post('/projects/import', [ProjectController::class, 'importProjects'])->name('projects.import');
    Route::get('/projects/template', [ProjectController::class, 'downloadTemplate'])->name('projects.template');
    
    Route::get('/tracking/export', [ProjectTrackingController::class, 'exportTrackings'])->name('tracking.export');
    Route::post('/tracking/import', [ProjectTrackingController::class, 'import'])->name('tracking.import');
    Route::get('/tracking/template', [ProjectTrackingController::class, 'downloadTemplate'])->name('tracking.template');

    // Activity Log
    Route::get('/activity', [\App\Http\Controllers\ActivityController::class, 'index'])->name('activity.index');

    // Bulk Actions
    Route::post('/projects/bulk-delete', [ProjectController::class, 'bulkDelete'])->name('projects.bulk-delete');

    // Document routes
    Route::get('/tracking/document/{document}/download', [ProjectTrackingController::class, 'downloadDocument'])->name('tracking.document.download');
    Route::delete('/tracking/document/{document}', [ProjectTrackingController::class, 'deleteDocument'])->name('tracking.document.delete');

    // Resource routes
    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::resource('tracking', ProjectTrackingController::class)->except(['show']);
});