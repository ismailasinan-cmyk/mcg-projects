<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state',
        'status',
        'description',
        'image',
        'awarded_at',
    ];

    protected $casts = [
        'awarded_at' => 'date',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;
        
        $path = 'images/projects/' . $this->image;
        
        // If file exists in public/ (Git-committed legacy files)
        if (file_exists(public_path($path))) {
            return secure_asset($path);
        }
        
        // Fallback to our proxy route at /storage/{path}
        return secure_url('storage/' . $path);
    }

    // Relationship with project images
    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('order');
    }



    // Scope to get projects by state
    public function scopeByState($query, $state)
    {
        return $query->where('state', $state);
    }

    // Scope to get projects by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}