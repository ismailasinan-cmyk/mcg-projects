<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'image_path', 'caption', 'order'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (!$this->image_path) return null;

        $path = ltrim($this->image_path, '/');

        // Check if file exists on the public disk (storage/app/public)
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
        }

        // Fallback to public asset (public/images/projects/...)
        return asset($path);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}