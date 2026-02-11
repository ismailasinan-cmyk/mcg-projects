<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (auth()->user()->isViewer()) {
            abort(403, 'Unauthorized action.');
        }

        $query = ActivityLog::with(['user', 'subject']);

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('user', function($u) use ($searchTerm) {
                      $u->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        $activities = $query->latest()->paginate(30);

        if ($request->ajax()) {
            return view('admin.activity._table', compact('activities'));
        }

        return view('admin.activity.index', [
            'activities' => $activities,
            'searchTerm' => $request->search,
            'actionFilter' => $request->action
        ]);
    }
}
