<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'company',
        'client',
        'project',
        'country',
        'state',
        'lga',
        'cost',
        'activity',
        'progress',
        'responsible',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'cost' => 'decimal:2',
    ];

    public function documents()
    {
        return $this->hasMany(TrackingDocument::class);
    }



    // Get status color
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'moving_forward' => 'success',
            'in_progress' => 'warning',
            'no_progress' => 'danger',
            default => 'secondary',
        };
    }

    // Get status background color for table
    public function getStatusBgColorAttribute()
    {
        return match ($this->status) {
            'moving_forward' => '#28a745',
            'in_progress' => '#ffc107',
            'no_progress' => '#dc3545',
            default => '#6c757d',
        };
    }
}