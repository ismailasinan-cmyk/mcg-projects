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

        // Force HTTPS for all URLs in production
        $isProduction = config('app.env') === 'production';
        
        // Check if file exists in the public directory directly
        if (file_exists(public_path($path))) {
            return $isProduction ? secure_asset($path) : asset($path);
        }

        // Otherwise assume it's in storage
        if ($isProduction) {
            return secure_url('storage/' . $path);
        }

        return asset('storage/' . $path);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}