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
            return secure_asset($path);
        }

        // Fallback to storage - using secure_asset handles potential symlink issues better
        // if the file is in public/storage, secure_asset('storage/'.$path) works perfectly.
        return secure_asset('storage/' . $path);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}