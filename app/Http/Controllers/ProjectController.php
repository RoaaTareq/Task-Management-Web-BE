<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->is_admin) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $projects = Project::with('users')->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = \App\Models\User::all();
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'users' => 'array|exists:users,id',
        ]);

        $project = Project::create($request->only('name', 'description'));
        $project->users()->sync($request->input('users', []));
        
        return redirect()->route('projects.index');
    }

    public function edit(Project $project)
    {
        $users = \App\Models\User::all();
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'users' => 'array|exists:users,id',
        ]);

        $project->update($request->only('name', 'description'));
        $project->users()->sync($request->input('users', []));
        
        return redirect()->route('projects.index');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index');
    }
}
