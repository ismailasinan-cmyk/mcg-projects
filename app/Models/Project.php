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