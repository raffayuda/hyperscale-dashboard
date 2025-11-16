<?php

namespace App\Http\Controllers;

use App\Models\Database;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DatabaseController extends Controller
{
    public function index()
    {
        $databases = auth()->user()->databases()->latest()->get();
        return view('pages.storage', compact('databases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:PostgreSQL,MySQL,MongoDB,Redis',
            'region' => 'required|string',
            'connection_limit' => 'nullable|integer|min:1',
            'storage_size' => 'nullable|integer|min:1',
            'auto_backup' => 'nullable',
            'env_key' => 'nullable|array',
            'env_value' => 'nullable|array',
        ]);

        // Process environment variables
        $envVars = [];
        if ($request->has('env_key') && is_array($request->env_key)) {
            foreach ($request->env_key as $index => $key) {
                if (!empty($key) && isset($request->env_value[$index])) {
                    $envVars[$key] = $request->env_value[$index];
                }
            }
        }

        // Generate database credentials
        $username = 'db_' . Str::random(8);
        $password = Str::random(16);
        $host = $this->generateHost($validated['type'], $validated['region']);
        $port = $this->getDefaultPort($validated['type']);

        $database = Database::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'type' => $validated['type'],
            'region' => $validated['region'],
            'connection_limit' => $validated['connection_limit'] ?? 100,
            'storage_size' => $validated['storage_size'] ?? 10,
            'auto_backup' => $request->has('auto_backup'),
            'status' => 'active',
            'env_vars' => $envVars,
            'host' => $host,
            'port' => $port,
            'username' => $username,
            'password' => $password,
            'connection_string' => $this->generateConnectionString(
                $validated['type'],
                $host,
                $port,
                $validated['name'],
                $username,
                $password
            ),
        ]);

        return redirect()->route('storage.index')->with('success', 'Database created successfully!');
    }

    public function destroy(Database $database)
    {
        // Check if user owns this database
        if ($database->user_id !== auth()->id()) {
            abort(403);
        }

        $database->delete();

        return redirect()->route('storage.index')->with('success', 'Database deleted successfully!');
    }

    private function generateHost($type, $region)
    {
        $regionCode = Str::slug(explode(' ', $region)[0]);
        return strtolower($type) . '-' . $regionCode . '.hyperscale.cloud';
    }

    private function getDefaultPort($type)
    {
        return match ($type) {
            'PostgreSQL' => 5432,
            'MySQL' => 3306,
            'MongoDB' => 27017,
            'Redis' => 6379,
            default => 5432,
        };
    }

    private function generateConnectionString($type, $host, $port, $dbname, $username, $password)
    {
        return match ($type) {
            'PostgreSQL' => "postgresql://{$username}:{$password}@{$host}:{$port}/{$dbname}",
            'MySQL' => "mysql://{$username}:{$password}@{$host}:{$port}/{$dbname}",
            'MongoDB' => "mongodb://{$username}:{$password}@{$host}:{$port}/{$dbname}",
            'Redis' => "redis://:{$password}@{$host}:{$port}",
            default => "postgresql://{$username}:{$password}@{$host}:{$port}/{$dbname}",
        };
    }
}
