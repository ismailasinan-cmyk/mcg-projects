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
        // Images are stored in public/images/projects/, not in storage
        return asset($this->image_path);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}