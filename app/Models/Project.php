<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'url',
        'github_repo',
        'git_url',
        'branch',
        'framework',
        'root_directory',
        'build_command',
        'output_directory',
        'environment_variables',
        'last_commit',
        'status',
        'deployed_at',
    ];

    protected $casts = [
        'environment_variables' => 'array',
        'deployed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deployments()
    {
        return $this->hasMany(Deployment::class);
    }
}