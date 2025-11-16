<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DeploymentController;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Detailed Health Check - Shows all service statuses
Route::get('/health', function () {
    $checks = [
        'app' => ['status' => 'ok', 'message' => 'Application running'],
        'timestamp' => now()->toIso8601String(),
    ];

    // Check APP_KEY
    try {
        $key = config('app.key');
        if (empty($key)) {
            $checks['app_key'] = ['status' => 'error', 'message' => 'APP_KEY is not set'];
        } elseif (!str_starts_with($key, 'base64:')) {
            $checks['app_key'] = ['status' => 'error', 'message' => 'APP_KEY must start with base64:'];
        } else {
            $decoded = base64_decode(substr($key, 7), true);
            if ($decoded === false || strlen($decoded) !== 32) {
                $checks['app_key'] = ['status' => 'error', 'message' => 'APP_KEY has invalid length (need 32 bytes)'];
            } else {
                $checks['app_key'] = ['status' => 'ok', 'message' => 'Valid 32-byte key'];
            }
        }
    } catch (\Exception $e) {
        $checks['app_key'] = ['status' => 'error', 'message' => $e->getMessage()];
    }

    // Check Database Connection
    try {
        DB::connection()->getPdo();
        $dbName = DB::connection()->getDatabaseName();
        $checks['database'] = ['status' => 'ok', 'message' => "Connected to: {$dbName}"];
    } catch (\Exception $e) {
        $checks['database'] = ['status' => 'error', 'message' => $e->getMessage()];
    }

    // Check Redis Connection
    try {
        if (config('cache.default') === 'redis' || config('database.redis.client')) {
            \Illuminate\Support\Facades\Redis::connection()->ping();
            $checks['redis'] = ['status' => 'ok', 'message' => 'Redis connected'];
        } else {
            $checks['redis'] = ['status' => 'disabled', 'message' => 'Redis not configured'];
        }
    } catch (\Exception $e) {
        $checks['redis'] = ['status' => 'error', 'message' => $e->getMessage()];
    }

    // Check Storage Permissions
    $storagePaths = [
        'storage/logs' => storage_path('logs'),
        'storage/framework/cache' => storage_path('framework/cache'),
        'storage/framework/sessions' => storage_path('framework/sessions'),
        'storage/framework/views' => storage_path('framework/views'),
        'bootstrap/cache' => base_path('bootstrap/cache'),
    ];

    $checks['storage'] = [];
    foreach ($storagePaths as $name => $path) {
        if (!is_dir($path)) {
            $checks['storage'][$name] = ['status' => 'error', 'message' => 'Directory does not exist'];
        } elseif (!is_writable($path)) {
            $checks['storage'][$name] = ['status' => 'error', 'message' => 'Not writable'];
        } else {
            $checks['storage'][$name] = ['status' => 'ok', 'message' => 'Writable'];
        }
    }

    // Overall Status
    $hasErrors = false;
    foreach ($checks as $key => $check) {
        if (is_array($check) && isset($check['status']) && $check['status'] === 'error') {
            $hasErrors = true;
            break;
        }
        if ($key === 'storage') {
            foreach ($check as $storageCheck) {
                if (isset($storageCheck['status']) && $storageCheck['status'] === 'error') {
                    $hasErrors = true;
                    break 2;
                }
            }
        }
    }

    return response()->json([
        'overall_status' => $hasErrors ? 'unhealthy' : 'healthy',
        'checks' => $checks,
    ], $hasErrors ? 503 : 200);
});



// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Socialite Routes
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('socialite.callback');

// Dashboard Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('home');
    Route::get('/dashboard', [ProjectController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/deployments', [DeploymentController::class, 'page'])->name('deployments');
    
    Route::get('/project/{project}', [ProjectController::class, 'overview'])->name('project.overview');
    
    // Storage/Database Routes
    Route::get('/storage', [DatabaseController::class, 'index'])->name('storage.index');
    Route::post('/databases', [DatabaseController::class, 'store'])->name('databases.store');
    Route::delete('/databases/{database}', [DatabaseController::class, 'destroy'])->name('databases.destroy');
    
    // Project CRUD Routes
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::patch('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});
