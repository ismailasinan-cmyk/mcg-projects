<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Upload a file to the specified path.
     *
     * @param UploadedFile $file
     * @param string $destinationPath relative to disk root
     * @return string The relative path to the uploaded file
     */
    public function uploadFile(UploadedFile $file, string $destinationPath): string
    {
        return $file->store($destinationPath);
    }

    /**
     * Delete a file if it exists.
     *
     * @param string|null $path relative to disk root
     * @return bool
     */
    public function deleteFile(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        if (Storage::exists($path)) {
            return Storage::delete($path);
        }

        return false;
    }

    /**
     * Format file size in bytes to human readable string.
     *
     * @param int $bytes
     * @return string
     */
    public function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
