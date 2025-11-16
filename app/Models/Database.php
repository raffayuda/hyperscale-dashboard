<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'region',
        'connection_limit',
        'storage_size',
        'auto_backup',
        'status',
        'env_vars',
        'connection_string',
        'host',
        'port',
        'username',
        'password',
    ];

    protected $casts = [
        'env_vars' => 'array',
        'auto_backup' => 'boolean',
        'connection_limit' => 'integer',
        'storage_size' => 'integer',
        'port' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
