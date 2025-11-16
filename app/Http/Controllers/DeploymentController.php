<?php

namespace App\Http\Controllers;

use App\Models\Deployment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DeploymentController extends Controller
{
    public function page()
    {
        $deployments = Deployment::with('project')->latest('deployed_at')->get();

        // Transform deployments for Alpine.js
        $deployments = $deployments->map(function($deployment) {
            return [
                'id' => $deployment->id,
                'deployment_id' => $deployment->deployment_id,
                'status' => $deployment->status,
                'environment' => $deployment->environment,
                'is_current' => $deployment->is_current,
                'branch' => $deployment->branch,
                'commit_hash' => $deployment->commit_hash,
                'commit_message' => $deployment->commit_message,
                'author' => $deployment->author,
                'deployed_at' => $deployment->deployed_at,
                'deployed_at_human' => $deployment->deployed_at->diffForHumans(),
                'time_formatted' => $deployment->deployed_at->format('h:i A'),
                'project' => [
                    'id' => $deployment->project->id,
                    'name' => $deployment->project->name,
                ],
            ];
        });

        // Get unique authors and environments for filters
        $authors = $deployments->pluck('author')->unique()->values();
        $environments = $deployments->pluck('environment')->unique()->values();

        return view('pages.deployments', compact('deployments', 'authors', 'environments'));
    }
}
