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

        // If file exists in public/ (Git-committed legacy files)
        if (file_exists(public_path($path))) {
            return secure_asset($path);
        }

        // Fallback to our proxy route at /storage/{path}
        return secure_url('storage/' . $path);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}