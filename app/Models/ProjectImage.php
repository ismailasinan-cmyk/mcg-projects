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

        // 1. If file exists in public/ (Git-committed legacy files)
        if (file_exists(public_path($path))) {
            return secure_asset($path);
        }

        // 2. If using S3, return the S3 URL
        if (config('filesystems.default') === 's3') {
            return \Illuminate\Support\Facades\Storage::disk('s3')->url($path);
        }

        // 3. Fallback to our proxy route at /storage/{path}
        return secure_url('storage/' . $path);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}