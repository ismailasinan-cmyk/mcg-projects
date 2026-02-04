<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function dashboard(Request $request)
    {
        $searchTerm = $request->get('search');

        // Base query
        $query = Project::with('images');

        // Apply search if present
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('state', 'like', "%{$searchTerm}%")
                    ->orWhere('status', 'like', "%{$searchTerm}%");
            });
        }

        // Get paginated projects
        $projects = $query->latest()->paginate(10);

        // Calculate statistics
        $totalProjects = Project::count();
        $ongoingProjects = Project::where('status', 'ongoing')->count();
        $completedProjects = Project::where('status', 'completed')->count();
        $suspendedProjects = Project::where('status', 'suspended')->count();
        $operationalProjects = Project::where('status', 'operation')->count();

        return view('admin.dashboard', compact(
            'projects',
            'totalProjects',
            'ongoingProjects',
            'completedProjects',
            'suspendedProjects',
            'operationalProjects',
            'searchTerm'
        ));
    }

    /**
     * Show the change password form
     */
    public function showChangePasswordForm()
    {
        return view('admin.change-password');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Update the password
        $user = Auth::user();
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Password updated successfully!');
    }
}