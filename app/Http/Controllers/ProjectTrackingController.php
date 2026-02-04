<?php

namespace App\Http\Controllers;

use App\Models\ProjectTracking;
use App\Models\TrackingDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectTrackingController extends Controller
{
    protected $fileUploadService;

    public function __construct(\App\Services\FileUploadService $fileUploadService)
    {
        $this->middleware('auth');
        $this->fileUploadService = $fileUploadService;
    }

    // List all project trackings
    public function index(Request $request)
    {
        $query = ProjectTracking::with('documents');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('project', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('client', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('state', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('responsible', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by state
        if ($request->has('state') && $request->state != '') {
            $query->where('state', $request->state);
        }

        $trackings = $query->orderBy('id', 'asc')->paginate(15);
        $searchTerm = $request->search ?? '';
        $statusFilter = $request->status ?? '';
        $stateFilter = $request->state ?? '';

        if ($request->ajax()) {
            return view('admin.tracking._table', compact('trackings', 'searchTerm', 'statusFilter', 'stateFilter'));
        }

        return view('admin.tracking.index', compact('trackings', 'searchTerm', 'statusFilter', 'stateFilter'));
    }

    // Show create form
    public function create()
    {
        $statusOptions = config('options.tracking_status');
        $states = config('options.states');
        return view('admin.tracking.create', compact('statusOptions', 'states'));
    }



    // Store new project tracking
    public function store(\App\Http\Requests\StoreTrackingRequest $request)
    {
        $tracking = ProjectTracking::create($request->validated());

        // Handle document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $fileSize = $this->fileUploadService->formatFileSize($file->getSize());
                
                $filePath = $this->fileUploadService->uploadFile($file, 'documents/tracking');

                $fileType = match ($extension) {
                    'pdf' => 'pdf',
                    'doc', 'docx' => 'word',
                    'xls', 'xlsx' => 'excel',
                    default => 'other',
                };

                $tracking->documents()->create([
                    'file_name' => $originalName,
                    'file_path' => $filePath,
                    'file_type' => $fileType,
                    'file_size' => $fileSize,
                ]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Project tracking created successfully!',
                'redirect' => route('admin.tracking.index')
            ]);
        }

        return redirect()->route('admin.tracking.index')
            ->with('success', 'Project tracking created successfully!');
    }

    // Show edit form
    public function edit(ProjectTracking $tracking)
    {
        $statusOptions = config('options.tracking_status');
        $states = config('options.states');
        return view('admin.tracking.edit', compact('tracking', 'statusOptions', 'states'));
    }

    // Update tracking


    // Update project tracking
    public function update(\App\Http\Requests\UpdateTrackingRequest $request, ProjectTracking $tracking)
    {
        $tracking->update($request->validated());

        // Delete selected documents
        if ($request->has('delete_documents')) {
            foreach ($request->delete_documents as $docId) {
                $doc = TrackingDocument::find($docId);
                if ($doc) {
                    $this->fileUploadService->deleteFile($doc->file_path);
                    $doc->delete();
                }
            }
        }

        // Handle new document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $fileSize = $this->fileUploadService->formatFileSize($file->getSize());

                $filePath = $this->fileUploadService->uploadFile($file, 'documents/tracking');

                $fileType = match ($extension) {
                    'pdf' => 'pdf',
                    'doc', 'docx' => 'word',
                    'xls', 'xlsx' => 'excel',
                    default => 'other',
                };

                $tracking->documents()->create([
                    'file_name' => $originalName,
                    'file_path' => $filePath,
                    'file_type' => $fileType,
                    'file_size' => $fileSize,
                ]);
            }
        }

        return redirect()->route('admin.tracking.index')
            ->with('success', 'Project tracking updated successfully!');
    }

    // Delete tracking
    public function destroy(ProjectTracking $tracking)
    {
        foreach ($tracking->documents as $doc) {
            $this->fileUploadService->deleteFile($doc->file_path);
        }

        $tracking->delete();

        return redirect()->route('admin.tracking.index')
            ->with('success', 'Project tracking deleted successfully!');
    }

    // Download document
    public function downloadDocument(TrackingDocument $document)
    {
        $filePath = public_path($document->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath, $document->file_name);
        }

        return back()->with('error', 'File not found.');
    }

    // Delete single document
    public function deleteDocument(TrackingDocument $document)
    {
        // Delete file from storage
        $this->fileUploadService->deleteFile($document->file_path);
        
        // Delete record
        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }



    // Download all project trackings as CSV
    public function exportTrackings(Request $request)
    {
        $query = ProjectTracking::with('documents');

        // Apply same filters as index if any
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('project', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('client', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('state', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('responsible', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('state') && $request->state != '') {
            $query->where('state', $request->state);
        }

        $trackings = $query->orderBy('created_at', 'desc')->get();

        $filename = 'project_tracking_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($trackings) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Add CSV header row
            fputcsv($file, [
                'S/N',
                'Date',
                'Company',
                'Client',
                'Project',
                'State',
                'Cost (₦)',
                'Activity',
                'Progress',
                'Responsible',
                'Status',
                'Documents Count',
                'Created Date'
            ]);

            // Status labels
            $statusLabels = [
                'moving_forward' => 'Moving Forward to Contract Award',
                'in_progress' => 'In Progress',
                'no_progress' => 'No Progress'
            ];

            // Add data rows
            $sn = 1;
            foreach ($trackings as $tracking) {
                fputcsv($file, [
                    $sn++,
                    $tracking->date ? $tracking->date->format('M d, Y') : 'N/A',
                    $tracking->company,
                    $tracking->client,
                    $tracking->project,
                    $tracking->state,
                    $tracking->cost ? number_format($tracking->cost, 2) : 'N/A',
                    $tracking->activity ?? 'N/A',
                    $tracking->progress ?? 'N/A',
                    $tracking->responsible ?? 'N/A',
                    $statusLabels[$tracking->status] ?? $tracking->status,
                    $tracking->documents->count(),
                    $tracking->created_at->format('M d, Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Import project trackings from CSV
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('file');
        $fileHandle = fopen($file->getRealPath(), 'r');
        
        // Skip header row
        fgetcsv($fileHandle);

        $importedCount = 0;

        while (($row = fgetcsv($fileHandle)) !== false) {
            // Basic validation - check minimum column count (adjust based on expected CSV structure)
            if (count($row) < 5) continue;

            try {
                // Map CSV columns to database fields
                // Expected format: Date, Company, Client, Project, State, Cost, Activity, Progress, Responsible, Status
                
                ProjectTracking::create([
                    'date' => !empty($row[0]) ? date('Y-m-d', strtotime($row[0])) : null,
                    'company' => $row[1] ?? 'Unknown',
                    'client' => $row[2] ?? 'Unknown',
                    'project' => $row[3] ?? 'Imported Project',
                    'country' => $row[4] ?? 'Nigeria',
                    'state' => $row[5] ?? 'Unknown',
                    'lga' => $row[6] ?? null,
                    'cost' => !empty($row[7]) ? floatval(str_replace(',', '', $row[7])) : null,
                    'activity' => $row[8] ?? null,
                    'progress' => $row[9] ?? null,
                    'responsible' => $row[10] ?? null,
                    // Basic status mapping
                    'status' => $this->mapImportStatus($row[11] ?? ''),
                ]);

                $importedCount++;
            } catch (\Exception $e) {
                // Log error or continue
                continue;
            }
        }

        fclose($fileHandle);

        return redirect()->back()->with('success', "$importedCount project trackings imported successfully!");
    }

    private function mapImportStatus($status)
    {
        $status = strtolower(trim($status));
        if (str_contains($status, 'moving') || str_contains($status, 'award')) return 'moving_forward';
        if (str_contains($status, 'progress')) return 'in_progress';
        return 'no_progress';
    }

    // Download CSV template
    public function downloadTemplate()
    {
        $filename = 'tracking_import_template.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Date', 'Company', 'Client', 'Project', 'Country', 'State', 'LGA', 'Cost', 'Activity', 'Progress', 'Responsible', 'Status']);
            
            // Sample row
            fputcsv($file, ['2024-01-15', 'MCG', 'Federal Ministry of Works', 'Abuja-Kano Road', 'Nigeria', 'FCT', 'Municipal Area Council', '50000000', 'Site Clearing', '15%', 'Engr. Musa', 'in_progress']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}