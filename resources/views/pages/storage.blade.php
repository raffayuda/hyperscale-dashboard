@extends('layouts.app')
@section('content')
    <div x-data="storageApp()">
        <!-- Main Content Area -->
        <div class="flex w-full bg-black">
            <div class="p-6 w-full">
                <!-- Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2">Storage & Databases</h2>
                        <p class="text-gray-400 text-sm">Manage your databases and storage solutions</p>
                    </div>
                    <button @click="showNewDatabaseModal = true"
                        class="bg-white text-black px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Create Database
                    </button>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400 text-sm">Total Databases</span>
                            <i class="fas fa-database text-blue-500"></i>
                        </div>
                        <div class="text-2xl font-bold text-white" x-text="databases.length"></div>
                    </div>
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400 text-sm">Active</span>
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="text-2xl font-bold text-white" x-text="activeDatabases"></div>
                    </div>
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400 text-sm">Total Storage</span>
                            <i class="fas fa-hdd text-purple-500"></i>
                        </div>
                        <div class="text-2xl font-bold text-white" x-text="totalStorage + ' GB'"></div>
                    </div>
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-400 text-sm">Backups Enabled</span>
                            <i class="fas fa-cloud-upload-alt text-yellow-500"></i>
                        </div>
                        <div class="text-2xl font-bold text-white" x-text="backupsEnabled"></div>
                    </div>
                </div>

                <!-- Databases List -->
                @if ($databases->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20">
                        <div
                            class="w-16 h-16 bg-gray-900 border border-gray-800 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-database text-gray-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">No databases yet</h3>
                        <p class="text-gray-400 text-sm mb-6">
                            Create your first database to get started
                        </p>
                        <button @click="showNewDatabaseModal = true"
                            class="bg-white text-black px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Create Database
                        </button>
                    </div>
                @else
                    <div class="space-y-3">
                        <template x-for="db in databases" :key="db.id">
                            <div
                                class="bg-gray-900 border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4 flex-1">
                                        <!-- Database Icon -->
                                        <div class="w-12 h-12 bg-black border border-gray-800 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-database text-blue-400 text-xl"></i>
                                        </div>

                                        <!-- Database Info -->
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-1">
                                                <h3 class="text-white font-medium" x-text="db.name"></h3>
                                                <span class="px-2 py-1 text-xs rounded-full"
                                                    :class="db.status === 'active' ? 'bg-green-500/10 text-green-400' :
                                                        'bg-yellow-500/10 text-yellow-400'"
                                                    x-text="db.status">
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-4 text-sm text-gray-400">
                                                <span class="flex items-center gap-2">
                                                    <i class="fas fa-server text-xs"></i>
                                                    <span x-text="db.type"></span>
                                                </span>
                                                <span class="flex items-center gap-2">
                                                    <i class="fas fa-globe text-xs"></i>
                                                    <span x-text="db.region"></span>
                                                </span>
                                                <span class="flex items-center gap-2">
                                                    <i class="fas fa-hdd text-xs"></i>
                                                    <span x-text="db.storage_size + ' GB'"></span>
                                                </span>
                                                <template x-if="db.auto_backup">
                                                    <span class="flex items-center gap-2 text-green-400">
                                                        <i class="fas fa-cloud-upload-alt text-xs"></i>
                                                        <span>Auto Backup</span>
                                                    </span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center gap-2">
                                        <button @click="showConnectionString(db)"
                                            class="px-3 py-2 bg-black border border-gray-800 rounded-lg text-sm text-gray-300 hover:text-white hover:border-gray-700 transition-colors">
                                            <i class="fas fa-link mr-2"></i>Connection
                                        </button>
                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open"
                                                class="px-3 py-2 bg-black border border-gray-800 rounded-lg text-gray-400 hover:text-white hover:border-gray-700 transition-colors">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div x-show="open" @click.away="open = false" x-transition
                                                class="absolute right-0 mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-10">
                                                <button @click="showConnectionString(db); open = false"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                                    <i class="fas fa-link w-4 mr-2"></i> View Connection
                                                </button>
                                                <button @click="deleteDatabase(db.id); open = false"
                                                    class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-800 hover:text-red-300 transition-colors">
                                                    <i class="fas fa-trash w-4 mr-2"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Expandable Connection Details -->
                                <div x-show="selectedDb && selectedDb.id === db.id" x-transition
                                    class="mt-4 pt-4 border-t border-gray-800">
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-xs text-gray-400 mb-1">Host</label>
                                            <div class="flex items-center gap-2">
                                                <input type="text" readonly :value="db.host"
                                                    class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                                <button @click="copyToClipboard(db.host)"
                                                    class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-400 mb-1">Port</label>
                                            <input type="text" readonly :value="db.port"
                                                class="w-full px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-400 mb-1">Username</label>
                                            <div class="flex items-center gap-2">
                                                <input type="text" readonly :value="db.username"
                                                    class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                                <button @click="copyToClipboard(db.username)"
                                                    class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-400 mb-1">Password</label>
                                            <div class="flex items-center gap-2">
                                                <input :type="showPassword ? 'text' : 'password'" readonly
                                                    :value="db.password"
                                                    class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                                <button @click="showPassword = !showPassword"
                                                    class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white">
                                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                                </button>
                                                <button @click="copyToClipboard(db.password)"
                                                    class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">Connection String</label>
                                        <div class="flex items-center gap-2">
                                            <input type="text" readonly :value="db.connection_string"
                                                class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm font-mono">
                                            <button @click="copyToClipboard(db.connection_string)"
                                                class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                @endif
            </div>
        </div>

        <!-- New Database Modal (same as dashboard) -->
        <div x-show="showNewDatabaseModal" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            @click.self="showNewDatabaseModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80"
            style="backdrop-filter: blur(4px);">
            <div class="bg-black border border-gray-800 rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                @click.stop x-transition:enter="transition ease-out duration-200 transform"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

                <!-- Modal Header -->
                <div class="border-b border-gray-800 p-8">
                    <h1 class="text-2xl font-bold text-white mb-2">Create New Database</h1>
                    <p class="text-sm text-gray-400">
                        Set up a new database for your project
                    </p>
                </div>

                <form action="{{ route('databases.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <!-- Database Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Database Name</label>
                        <input type="text" name="name" x-model="newDatabase.name" required
                            class="w-full px-4 py-2 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm"
                            placeholder="my-database">
                        <p class="text-xs text-gray-500 mt-1">Choose a unique name for your database</p>
                    </div>

                    <!-- Database Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Database Type</label>
                        <div x-data="{ open: false }" class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-left">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-database text-gray-400"></i>
                                    <span class="text-white text-sm" x-text="newDatabase.type"></span>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute w-full mt-2 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl z-10 overflow-hidden">
                                <template x-for="dbType in ['PostgreSQL', 'MySQL', 'MongoDB', 'Redis']" :key="dbType">
                                    <button type="button" @click="newDatabase.type = dbType; open = false"
                                        class="w-full px-4 py-3 hover:bg-gray-800 transition-colors text-left border-b border-gray-800 last:border-b-0">
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-database text-gray-400"></i>
                                            <span class="text-white text-sm" x-text="dbType"></span>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>
                        <input type="hidden" name="type" x-model="newDatabase.type">
                    </div>

                    <!-- Region -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Region</label>
                        <div x-data="{ open: false }" class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-left">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-globe text-gray-400"></i>
                                    <span class="text-white text-sm" x-text="newDatabase.region"></span>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute w-full mt-2 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl z-10 max-h-60 overflow-y-auto">
                                <template
                                    x-for="region in ['US East (N. Virginia)', 'US West (Oregon)', 'Europe (Frankfurt)', 'Asia Pacific (Singapore)', 'Asia Pacific (Tokyo)']"
                                    :key="region">
                                    <button type="button" @click="newDatabase.region = region; open = false"
                                        class="w-full px-4 py-3 hover:bg-gray-800 transition-colors text-left border-b border-gray-800 last:border-b-0">
                                        <span class="text-white text-sm" x-text="region"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                        <input type="hidden" name="region" x-model="newDatabase.region">
                    </div>

                    <!-- Collapsible Sections -->
                    <div class="space-y-3">
                        <!-- Advanced Settings -->
                        <div x-data="{ open: false }" class="border border-gray-800 rounded-lg">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between px-4 py-3 text-left">
                                <span class="text-white text-sm font-medium">Advanced Settings</span>
                                <i class="fas fa-chevron-down text-gray-400 text-xs"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="open" x-transition class="px-4 pb-4 space-y-4">
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Connection Limit</label>
                                    <input type="number" name="connection_limit" x-model="newDatabase.connectionLimit"
                                        placeholder="100"
                                        class="w-full px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Storage Size (GB)</label>
                                    <input type="number" name="storage_size" x-model="newDatabase.storageSize"
                                        placeholder="10"
                                        class="w-full px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="auto_backup" x-model="newDatabase.autoBackup"
                                        class="w-4 h-4 bg-black border border-gray-800 rounded">
                                    <label class="text-xs text-gray-400">Enable automatic backups</label>
                                </div>
                            </div>
                        </div>

                        <!-- Environment Variables -->
                        <div x-data="{ open: false }" class="border border-gray-800 rounded-lg">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between px-4 py-3 text-left">
                                <span class="text-white text-sm font-medium">Environment Variables</span>
                                <i class="fas fa-chevron-down text-gray-400 text-xs"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="open" x-transition class="px-4 pb-4">
                                <div class="space-y-2 mb-3">
                                    <template x-for="(envVar, index) in newDatabase.envVars" :key="index">
                                        <div class="flex gap-2">
                                            <input type="text" :name="'env_vars[]'" x-model="envVar.key"
                                                placeholder="KEY"
                                                class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                            <input type="text" :name="'env_value[]'" x-model="envVar.value"
                                                placeholder="value"
                                                class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                            <button type="button" @click="newDatabase.envVars.splice(index, 1)"
                                                class="px-3 py-2 text-gray-400 hover:text-red-400 transition-colors">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                <button type="button" @click="newDatabase.envVars.push({ key: '', value: '' })"
                                    class="text-sm text-blue-400 hover:text-blue-300">
                                    <i class="fas fa-plus mr-1"></i> Add Variable
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Create Button -->
                    <div class="flex gap-3">
                        <button type="button" @click="showNewDatabaseModal = false"
                            class="flex-1 px-4 py-3 bg-black border border-gray-800 text-white rounded-lg font-medium hover:bg-gray-900 transition-colors text-sm">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 bg-white text-black rounded-lg font-medium hover:bg-gray-200 transition-colors text-sm">
                            Create Database
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function storageApp() {
                return {
                    showNewDatabaseModal: false,
                    databases: @json($databases),
                    selectedDb: null,
                    showPassword: false,
                    newDatabase: {
                        name: '',
                        type: 'PostgreSQL',
                        region: 'US East (N. Virginia)',
                        connectionLimit: 100,
                        storageSize: 10,
                        autoBackup: true,
                        envVars: []
                    },

                    get activeDatabases() {
                        return this.databases.filter(db => db.status === 'active').length;
                    },

                    get totalStorage() {
                        return this.databases.reduce((sum, db) => sum + db.storage_size, 0);
                    },

                    get backupsEnabled() {
                        return this.databases.filter(db => db.auto_backup).length;
                    },

                    showConnectionString(db) {
                        if (this.selectedDb && this.selectedDb.id === db.id) {
                            this.selectedDb = null;
                        } else {
                            this.selectedDb = db;
                        }
                    },

                    copyToClipboard(text) {
                        navigator.clipboard.writeText(text).then(() => {
                            // You can add a toast notification here
                            alert('Copied to clipboard!');
                        });
                    },

                    deleteDatabase(id) {
                        if (confirm('Are you sure you want to delete this database? This action cannot be undone.')) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/databases/${id}`;
                            
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = csrfToken;
                            
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            
                            form.appendChild(csrfInput);
                            form.appendChild(methodInput);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    }
                }
            }
        </script>
    </div>
@endsection
