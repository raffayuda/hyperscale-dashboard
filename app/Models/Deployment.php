<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'deployment_id',
        'status',
        'environment',
        'is_current',
        'branch',
        'commit_hash',
        'commit_message',
        'author',
        'build_time',
        'deployed_at',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'deployed_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getTimeAgoAttribute()
    {
        return $this->deployed_at?->diffForHumans() ?? 'just now';
    }

    public function getBuildTimeFormattedAttribute()
    {
        if (!$this->build_time) return 'N/A';
        
        $minutes = floor($this->build_time / 60);
        $seconds = $this->build_time % 60;
        
        if ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        }
        return "{$seconds}s";
    }
}
