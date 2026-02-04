<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_tracking_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function projectTracking()
    {
        return $this->belongsTo(ProjectTracking::class);
    }

    // Get icon based on file type
    public function getIconAttribute()
    {
        return match ($this->file_type) {
            'pdf' => 'bi-file-earmark-pdf text-danger',
            'excel', 'xlsx', 'xls' => 'bi-file-earmark-excel text-success',
            'word', 'doc', 'docx' => 'bi-file-earmark-word text-primary',
            default => 'bi-file-earmark text-secondary',
        };
    }
}