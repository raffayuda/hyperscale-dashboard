<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Deployment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function dashboard()
    {
        $projects = auth()->check() 
            ? auth()->user()->projects()->latest()->get()
            : Project::latest()->get();
        
        // Transform projects to include formatted data for Alpine.js
        $projects = $projects->map(function($project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'url' => $project->url,
                'github_repo' => $project->github_repo,
                'git_url' => $project->git_url,
                'branch' => $project->branch ?? 'main',
                'status' => $project->status,
                'updated_at_human' => $project->updated_at->diffForHumans(),
                'created_at' => $project->created_at,
            ];
        });
            
        return view('pages.dashboard', compact('projects'));
    }

    public function overview(Project $project)
    {
        $project->load('deployments');
        return view('pages.project-overview', compact('project'));
    }

    public function index()
    {
        $projects = auth()->check() 
            ? auth()->user()->projects()->latest()->get()
            : Project::latest()->get();
            
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'github_repo' => 'nullable|string',
            'git_url' => 'nullable|url',
            'branch' => 'nullable|string|max:255',
            'framework' => 'nullable|string|max:255',
            'root_directory' => 'nullable|string|max:255',
            'build_command' => 'nullable|string|max:255',
            'output_directory' => 'nullable|string|max:255',
            'environment_variables' => 'nullable|array',
        ]);

        $url = Str::slug($validated['name']) . '.hyperscale.work';

        $project = Project::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'url' => $url,
            'github_repo' => $validated['github_repo'] ?? null,
            'git_url' => $validated['git_url'] ?? null,
            'branch' => $validated['branch'] ?? 'main',
            'framework' => $validated['framework'] ?? 'Other',
            'root_directory' => $validated['root_directory'] ?? './',
            'build_command' => $validated['build_command'] ?? null,
            'output_directory' => $validated['output_directory'] ?? null,
            'environment_variables' => $validated['environment_variables'] ?? null,
            'last_commit' => 'Initial commit',
            'status' => 'Building',
        ]);

        // Create deployment record
        Deployment::create([
            'project_id' => $project->id,
            'deployment_id' => Str::random(9),
            'status' => 'Building',
            'environment' => 'Production',
            'is_current' => true,
            'branch' => $validated['branch'] ?? 'main',
            'commit_hash' => substr(md5(now()), 0, 7),
            'commit_message' => 'Initial commit',
            'author' => auth()->user()->name ?? 'Unknown',
            'build_time' => rand(4, 127),
            'deployed_at' => now(),
        ]);
        
        return redirect()->route('dashboard')->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $project->load('deployments');
        return response()->json($project);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:Building,Ready,Error,Deploying',
            'last_commit' => 'nullable|string',
        ]);

        $project->update($validated);

        return redirect()->back()->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Project deleted successfully!');
    }
}
