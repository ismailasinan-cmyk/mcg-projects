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

        // Check if file exists in the physical public directory (legacy/seed images)
        if (file_exists(public_path($path))) {
            $url = asset($path);
        } else {
            // Assume it's in storage (new uploads)
            $url = \Illuminate\Support\Facades\Storage::disk('public')->url($path);
        }

        // Hard-force HTTPS in production to fix Mixed Content
        if (config('app.env') === 'production') {
            return str_replace('http://', 'https://', $url);
        }

        return $url;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}