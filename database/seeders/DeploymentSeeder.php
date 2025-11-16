<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Deployment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DeploymentSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Sample projects data
        $projects = [
            [
                'name' => 'pemesanan-tiket-bioskop',
                'url' => 'pemesanan-tiket-bioskop.hyperscale.work',
                'github_repo' => 'raffayuda/Pemesanan-tiket-bioskop',
                'branch' => 'main',
                'framework' => 'Laravel',
            ],
            [
                'name' => 'raffa-yuda-pratama',
                'url' => 'raffa-yuda-pratama.hyperscale.work',
                'github_repo' => 'raffayuda/raffa-yuda-pratama',
                'branch' => 'master',
                'framework' => 'Next.js',
            ],
            [
                'name' => 'portfolio-raffayuda',
                'url' => 'portfolio-raffayuda.hyperscale.work',
                'github_repo' => 'raffayuda/portfolio',
                'branch' => 'master',
                'framework' => 'React',
            ],
        ];

        foreach ($projects as $projectData) {
            $project = Project::create([
                'user_id' => $user->id,
                'name' => $projectData['name'],
                'url' => $projectData['url'],
                'github_repo' => $projectData['github_repo'],
                'branch' => $projectData['branch'],
                'framework' => $projectData['framework'],
                'root_directory' => './',
                'last_commit' => 'feat: add prisma seed script for default chat room',
                'status' => 'Ready',
                'deployed_at' => now()->subDays(rand(1, 90)),
            ]);

            // Create multiple deployments for each project
            $deploymentsData = [
                [
                    'deployment_id' => Str::random(9),
                    'status' => 'Ready',
                    'is_current' => true,
                    'commit_message' => 'feat: add prisma seed script',
                    'build_time' => rand(4, 127),
                    'deployed_at' => now()->subHours(rand(1, 12)),
                ],
                [
                    'deployment_id' => Str::random(9),
                    'status' => 'Ready',
                    'is_current' => false,
                    'commit_message' => 'Add Umami analytics support',
                    'build_time' => rand(50, 90),
                    'deployed_at' => now()->subDays(rand(20, 80)),
                ],
            ];

            foreach ($deploymentsData as $deploymentData) {
                Deployment::create([
                    'project_id' => $project->id,
                    'deployment_id' => $deploymentData['deployment_id'],
                    'status' => $deploymentData['status'],
                    'environment' => 'Production',
                    'is_current' => $deploymentData['is_current'],
                    'branch' => $projectData['branch'],
                    'commit_hash' => substr(md5(Str::random()), 0, 7),
                    'commit_message' => $deploymentData['commit_message'],
                    'author' => 'raffayuda',
                    'build_time' => $deploymentData['build_time'],
                    'deployed_at' => $deploymentData['deployed_at'],
                ]);
            }
        }
    }
}
