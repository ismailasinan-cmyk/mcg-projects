<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(\App\Services\ProjectService $projectService)
    {
        $this->projectService = $projectService;
        $this->middleware('auth')->except(['showMap', 'getByState', 'getProject', 'getStatistics', 'getStatesWithProjects']);
    }

    // Public map view (homepage)
    public function showMap()
    {
        return view('map');
    }

    // API endpoint to get projects by state
    public function getByState($state)
    {
        try {
            $projects = Project::with('images')
                ->where('state', $state)
                ->get();

            return response()->json($projects);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // API endpoint to get single project with images
    public function getProject($id)
    {
        try {
            $project = Project::with('images')->findOrFail($id);
            return response()->json($project);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // API endpoint to get project statistics
    public function getStatistics()
    {
        $stats = $this->projectService->getDashboardStats();
        return response()->json([
            'total' => $stats['totalProjects'],
            'ongoing' => $stats['ongoingProjects'],
            'completed' => $stats['completedProjects'],
            'suspended' => $stats['suspendedProjects'],
            'operational' => $stats['operationalProjects'],
        ]);
    }

    // API endpoint to get states that have projects
    public function getStatesWithProjects()
    {
        $states = Project::select('state')->distinct()->pluck('state')->toArray();
        return response()->json($states);
    }

    // Admin dashboard
    public function dashboard(Request $request)
    {
        $filters = [
            'search' => $request->search ?? '',
            'status' => $request->status ?? ''
        ];
        $projects = $this->projectService->getProjectsPaged($filters, 10);
        $stats = $this->projectService->getDashboardStats();

        if ($request->ajax()) {
            return view('admin.dashboard._projects', array_merge($stats, [
                'projects' => $projects,
                'searchTerm' => $filters['search']
            ]));
        }

        return view('admin.dashboard', array_merge($stats, [
            'projects' => $projects,
            'searchTerm' => $filters['search']
        ]));
    }

    // Show all projects (admin)
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->search ?? '',
            'status' => $request->status ?? ''
        ];
        $projects = $this->projectService->getProjectsPaged($filters, 15);
        $searchTerm = $filters['search'];
        $status = $filters['status'];

        if ($request->ajax()) {
            return view('admin.projects._table', compact('projects', 'searchTerm', 'status'));
        }
        return view('admin.projects.index', compact('projects', 'searchTerm', 'status'));
    }

    // Show create form
    public function create()
    {
        return view('admin.projects.create', [
            'states' => config('options.states'),
            'statusOptions' => config('options.project_status')
        ]);
    }

    // Store new project
    public function store(\App\Http\Requests\StoreProjectRequest $request)
    {
        $this->projectService->createProject(
            $request->validated(),
            $request->file('images', []),
            $request->get('captions', [])
        );

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Project created successfully!',
                'redirect' => route('admin.projects.index')
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully!');
    }

    // Show edit form
    public function edit(Project $project)
    {
        return view('admin.projects.edit', [
            'project' => $project,
            'states' => config('options.states'),
            'statusOptions' => config('options.project_status')
        ]);
    }

    // Update project
    public function update(\App\Http\Requests\UpdateProjectRequest $request, Project $project)
    {
        $this->projectService->updateProject(
            $project,
            $request->validated(),
            $request->file('images', []),
            $request->get('captions', []),
            $request->get('delete_images', [])
        );

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Project updated successfully!',
                'redirect' => route('admin.projects.index')
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully!');
    }

    // Delete project
    public function destroy(Project $project)
    {
        $this->projectService->deleteProject($project);
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully!');
    }

    // Bulk Delete
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'No projects selected for deletion.');
        }

        $count = $this->projectService->bulkDelete($ids);
        return redirect()->route('admin.projects.index')->with('success', "Successfully deleted {$count} projects.");
    }

    // Download all projects as CSV (simplified for now, logic can move to service later)
    public function exportProjects()
    {
        $projects = Project::with('images')->orderBy('created_at', 'desc')->get();
        $filename = 'mcg_projects_' . date('Y-m-d_H-i-s') . '.csv';

        $callback = function () use ($projects) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['S/N', 'Project Name', 'State', 'Status', 'Description', 'Images Count', 'Created Date', 'Last Updated']);
            
            $sn = 1;
            foreach ($projects as $project) {
                fputcsv($file, [
                    $sn++, $project->name, $project->state, ucfirst($project->status),
                    $project->description ?? 'N/A', $project->images->count(),
                    $project->created_at->format('M d, Y'), $project->updated_at->format('M d, Y')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    // Import projects from CSV
    public function importProjects(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt|max:10240']);

        $fileHandle = fopen($request->file('file')->getRealPath(), 'r');
        fgetcsv($fileHandle); // Skip header

        $importedCount = 0;
        while (($row = fgetcsv($fileHandle)) !== false) {
            if (count($row) < 3) continue;
            try {
                Project::create([
                    'name' => $row[0] ?? 'Imported Project',
                    'state' => $row[1] ?? 'Unknown',
                    'status' => $this->mapImportStatus($row[2] ?? ''),
                    'description' => $row[3] ?? null,
                ]);
                $importedCount++;
            } catch (\Exception $e) {}
        }
        fclose($fileHandle);
        $this->projectService->clearCaches();

        return redirect()->back()->with('success', "$importedCount projects imported successfully!");
    }

    private function mapImportStatus($status)
    {
        $status = strtolower(trim($status));
        $validStatuses = ['ongoing', 'completed', 'suspended', 'operation', 'pending', 'planned'];
        if (in_array($status, $validStatuses)) return $status;
        
        if (str_contains($status, 'complete')) return 'completed';
        if (str_contains($status, 'suspend')) return 'suspended';
        if (str_contains($status, 'operat')) return 'operation';
        if (str_contains($status, 'pend')) return 'pending';
        if (str_contains($status, 'plan')) return 'planned';
        
        return 'ongoing';
    }

    // Download CSV template
    public function downloadTemplate()
    {
        $filename = 'project_import_template.csv';
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'State', 'Status', 'Description']);
            fputcsv($file, ['Lagos City Monorail', 'Lagos', 'ongoing', 'Construction of urban monorail system phase 1']);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
}