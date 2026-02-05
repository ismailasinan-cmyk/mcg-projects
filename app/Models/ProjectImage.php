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
        // Check if image exists in public folder (legacy/committed images)
        if (file_exists(public_path($this->image_path))) {
            return asset($this->image_path);
        }
        
        // Fall back to Storage::url() for cloud-uploaded images
        return \Illuminate\Support\Facades\Storage::url($this->image_path);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}