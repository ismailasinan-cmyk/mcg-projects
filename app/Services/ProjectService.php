<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ProjectService
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get dashboard statistics (Cached for 10 minutes)
     */
    public function getDashboardStats()
    {
        return Cache::remember('project_stats_dashboard', 600, function () {
            $rawStats = Project::selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status');

            // Fix discrepancy: map 'operation' or other variants to 'operational'
            $stats = [
                'ongoing' => $rawStats['ongoing'] ?? 0,
                'completed' => $rawStats['completed'] ?? 0,
                'suspended' => $rawStats['suspended'] ?? 0,
                'operational' => ($rawStats['operational'] ?? 0) + ($rawStats['operation'] ?? 0),
            ];

            $projectsByStateData = Project::selectRaw('state, count(*) as count')
                ->groupBy('state')
                ->orderBy('count', 'desc')
                ->take(10)
                ->get();

            $projectsByYearData = Project::select('awarded_at', 'created_at')
                ->get()
                ->groupBy(function($project) {
                    return $project->awarded_at ? $project->awarded_at->year : $project->created_at->year;
                })
                ->map(function($group, $year) {
                    return (object) [
                        'year' => (string) $year,
                        'count' => $group->count()
                    ];
                })
                ->values()
                ->sortBy('year')
                ->values();

            return [
                'totalProjects' => array_sum($stats),
                'ongoingProjects' => $stats['ongoing'],
                'completedProjects' => $stats['completed'],
                'suspendedProjects' => $stats['suspended'],
                'operationalProjects' => $stats['operational'],
                'projectsByStateData' => $projectsByStateData,
                'projectsByYearData' => $projectsByYearData
            ];
        });
    }

    /**
     * Clear project caches
     */
    public function clearCaches()
    {
        Cache::forget('project_stats_dashboard');
        Cache::forget('projects_states_list');
    }

    /**
     * Get projects with pagination and search
     */
    public function getProjectsPaged($filters = [], $perPage = 20)
    {
        $query = Project::query();
        $searchTerm = $filters['search'] ?? null;
        $status = $filters['status'] ?? null;

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('state', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('status', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        return $query->orderBy('id', 'asc')->paginate($perPage);
    }

    /**
     * Create project with images
     */
    public function createProject(array $data, array $images = [], array $captions = [])
    {
        return DB::transaction(function () use ($data, $images, $captions) {
            $project = Project::create([
                'name' => $data['name'],
                'state' => $data['state'],
                'status' => $data['status'],
                'description' => $data['description'] ?? null,
                'awarded_at' => $data['awarded_at'] ?? null,
            ]);

            foreach ($images as $index => $image) {
                $imagePath = $this->fileUploadService->uploadFile($image, 'images/projects');
                $project->images()->create([
                    'image_path' => $imagePath,
                    'caption' => $captions[$index] ?? null,
                    'order' => $index,
                ]);
            }

            $this->clearCaches();
            $this->logActivity('create', $project, null, "Created project: {$project->name}");
            return $project;
        });
    }

    /**
     * Update project with images and deletions
     */
    public function updateProject(Project $project, array $data, array $newImages = [], array $captions = [], array $deleteImageIds = [])
    {
        return DB::transaction(function () use ($project, $data, $newImages, $captions, $deleteImageIds) {
            $project->update([
                'name' => $data['name'],
                'state' => $data['state'],
                'status' => $data['status'],
                'description' => $data['description'] ?? null,
                'awarded_at' => $data['awarded_at'] ?? null,
            ]);

            foreach ($deleteImageIds as $imageId) {
                $image = ProjectImage::find($imageId);
                if ($image) {
                    $this->fileUploadService->deleteFile($image->image_path);
                    $image->delete();
                }
            }

            $startOrder = $project->images()->max('order') + 1;
            foreach ($newImages as $index => $image) {
                $imagePath = $this->fileUploadService->uploadFile($image, 'images/projects');
                $project->images()->create([
                    'image_path' => $imagePath,
                    'caption' => $captions[$index] ?? null,
                    'order' => $startOrder + $index,
                ]);
            }

            $this->clearCaches();
            $this->logActivity('update', $project, $project->getChanges(), "Updated project: {$project->name}");
            return $project;
        });
    }

    /**
     * Delete project and its assets
     */
    public function deleteProject(Project $project)
    {
        return DB::transaction(function () use ($project) {
            foreach ($project->images as $image) {
                $this->fileUploadService->deleteFile($image->image_path);
            }

            if ($project->image) {
                $this->fileUploadService->deleteFile('images/projects/' . $project->image);
            }

            $this->clearCaches();
            $this->logActivity('delete', $project, $project->toArray(), "Deleted project: {$project->name}");
            return $project->delete();
        });
    }

    /**
     * Bulk delete projects
     */
    public function bulkDelete(array $ids)
    {
        return DB::transaction(function () use ($ids) {
            $count = 0;
            foreach ($ids as $id) {
                $project = Project::find($id);
                if ($project && $this->deleteProject($project)) {
                    $count++;
                }
            }
            return $count;
        });
    }

    /**
     * Log administrative activity
     */
    private function logActivity($action, $subject, $changes = null, $description = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => get_class($subject),
            'subject_id' => $subject->id,
            'changes' => $changes,
            'description' => $description,
            'ip_address' => Request::ip()
        ]);
    }
}
