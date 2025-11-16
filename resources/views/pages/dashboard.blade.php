@extends('layouts.app')
@section('content')
    <div x-data="dashboardApp()">
        <!-- Main Content Area with Sidebar -->
        <div class="flex w-full">

            <!-- Main Content Area -->
            <div class="flex bg-black w-full">
                <div class="p-6 w-full">
                    <!-- Search Bar and Controls -->
                    <div class="mb-6 w-full">
                        <div class="flex items-center gap-5 justify-between w-full">
                            <div class="flex-1 relative">
                                <input type="text" x-model="searchQuery" placeholder="Search Projects..."
                                    class="w-full pl-10 pr-4 py-2 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm placeholder-gray-500">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                            </div>

                            <div class="flex gap-0 border border-gray-800 rounded-lg overflow-hidden">
                                <button @click="viewMode = 'grid'"
                                    :class="viewMode === 'grid' ? 'bg-gray-800' : 'bg-black'"
                                    class="px-3 py-2 text-gray-400 hover:text-white transition-colors border-l border-gray-800">
                                    <i class="fas fa-th text-sm"></i>
                                </button>
                                <button @click="viewMode = 'list'"
                                    :class="viewMode === 'list' ? 'bg-gray-800' : 'bg-black'"
                                    class="px-3 py-2 text-gray-400 hover:text-white transition-colors border-l border-gray-800">
                                    <i class="fas fa-list text-sm"></i>
                                </button>
                            </div>

                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                    class="bg-white text-black px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center gap-2">
                                    <span>Add New...</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition
                                    class="absolute right-0 mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-10">
                                    <button @click="showNewProjectModal = true; open = false"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                        <i class="fas fa-plus w-4"></i> Project
                                    </button>
                                    <button @click="showNewDatabaseModal = true; open = false"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                        <i class="fas fa-database w-4"></i> Database
                                    </button>
                                    <button
                                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                        <i class="fas fa-globe w-4"></i> Domain
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Projects Header -->
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-white">Projects</h2>

                    </div>

                    <!-- Empty State -->
                    @if ($projects->isEmpty())
                        <div class="flex flex-col items-center justify-center py-20">
                            <div
                                class="w-16 h-16 bg-gray-900 border border-gray-800 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-folder-open text-gray-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-white mb-2">No projects yet</h3>
                            <p class="text-gray-400 text-sm mb-6">
                                Get started by deploying your first project
                            </p>
                            <button @click="showNewProjectModal = true"
                                class="bg-white text-black px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                                <i class="fas fa-plus mr-2"></i>New Project
                            </button>
                        </div>
                    @else
                        <!-- Projects Grid -->
                        <div x-show="filteredProjects.length === 0 && searchQuery"
                            class="flex flex-col items-center justify-center py-20">
                            <div
                                class="w-16 h-16 bg-gray-900 border border-gray-800 rounded-lg flex items-center justify-center mb-4">
                                <i class="fas fa-search text-gray-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-white mb-2">No results found</h3>
                            <p class="text-gray-400 text-sm mb-6">
                                Try searching with different keywords
                            </p>
                        </div>

                        <div x-show="filteredProjects.length > 0"
                            :class="{
                                'grid grid-cols-1 lg:grid-cols-4 gap-4': viewMode === 'grid',
                                'grid grid-cols-1 lg:grid-cols-2 gap-4': viewMode === 'mixed',
                                'space-y-2': viewMode === 'list'
                            }">
                            <template x-for="project in filteredProjects" :key="project.id">
                                <a :href="'/project/' + project.id"
                                    :class="{
                                        'bg-gray-900 border border-gray-800 rounded-lg hover:border-gray-700 transition-all cursor-pointer': true,
                                        'flex items-center': viewMode === 'list'
                                    }">
                                    <div :class="viewMode === 'list' ? 'p-4 flex items-center gap-4 w-full' : 'p-5'">
                                        <!-- Project Header -->
                                        <div
                                            :class="viewMode === 'list' ? 'flex items-center gap-3 flex-1' :
                                                'flex items-start justify-between mb-4'">
                                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                                <div
                                                    class="w-10 h-10 bg-white rounded flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-triangle text-black text-xs"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="font-semibold text-white text-sm mb-1 truncate"
                                                        x-text="project.name"></h3>
                                                    <p class="text-xs text-gray-500 truncate"
                                                        x-text="project.url ? project.url.replace('https://', '') : ''"></p>
                                                </div>
                                            </div>
                                            <div
                                                :class="viewMode === 'list' ? 'flex items-center gap-4' :
                                                    'flex items-center gap-2'">
                                                <template x-if="viewMode !== 'list'">
                                                    <button
                                                        class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white transition-colors">
                                                        <i class="fas fa-chart-line text-sm"></i>
                                                    </button>
                                                </template>
                                                <button onclick="event.preventDefault(); event.stopPropagation();"
                                                    class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white transition-colors">
                                                    <i class="fas fa-ellipsis-h text-sm"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <template x-if="viewMode !== 'list'">
                                            <div>
                                                <!-- GitHub Info -->
                                                <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                                                    <i class="fab fa-github"></i>
                                                    <span x-text="project.github_repo || 'No repository'"></span>
                                                </div>

                                                <!-- Status -->
                                                <div class="flex items-center gap-2 mb-2">
                                                    <div class="w-2 h-2 rounded-full"
                                                        :class="project.status === 'Ready' ? 'bg-green-500' : 'bg-yellow-500'">
                                                    </div>
                                                    <p class="text-sm text-gray-300" x-text="project.status"></p>
                                                </div>

                                                <!-- Commit Info -->
                                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                                    <span x-text="project.updated_at_human"></span>
                                                    <span>on</span>
                                                    <i class="fas fa-code-branch text-[10px]"></i>
                                                    <span x-text="project.branch || 'main'"></span>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="viewMode === 'list'">
                                            <div class="flex items-center gap-4">
                                                <!-- Status -->
                                                <div class="flex items-center gap-2">
                                                    <div class="w-2 h-2 rounded-full"
                                                        :class="project.status === 'Ready' ? 'bg-green-500' : 'bg-yellow-500'">
                                                    </div>
                                                    <p class="text-sm text-gray-300" x-text="project.status"></p>
                                                </div>

                                                <!-- Branch -->
                                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                                    <i class="fas fa-code-branch text-[10px]"></i>
                                                    <span x-text="project.branch || 'main'"></span>
                                                </div>

                                                <!-- Time -->
                                                <div class="text-xs text-gray-500">
                                                    <span x-text="project.updated_at_human"></span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </a>
                            </template>
                        </div>
                    @endif
                </div>
            </div>

            <!-- New Project Modal -->
            <div x-show="showNewProjectModal" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                @click.self="showNewProjectModal = false"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80"
                style="backdrop-filter: blur(4px);">
                <div class="bg-[#0a0a0a] border border-gray-800 rounded-xl shadow-2xl max-w-7xl w-full max-h-[90vh] overflow-y-auto"
                    @click.stop x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

                    <!-- Modal Content -->
                    <div class="p-8">
                        <!-- Close Button -->
                        <div class="flex justify-end mb-4">
                            <button @click="showNewProjectModal = false"
                                class="text-gray-400 hover:text-white transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <div class="w-full">
                            <!-- Left Section - Import Git Repository -->
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-6">Import Git Repository</h2>

                                <!-- User Dropdown -->
                                <div x-data="{ openUser: false }" class="relative mb-4">
                                    <button @click="openUser = !openUser"
                                        class="w-full flex items-center justify-between px-4 py-3 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-left">
                                        <div class="flex items-center gap-3">
                                            <i class="fab fa-github text-gray-400 text-lg"></i>
                                            <span class="text-white text-sm">raffayuda</span>
                                        </div>
                                        <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform"
                                            :class="openUser ? 'rotate-180' : ''"></i>
                                    </button>
                                </div>

                                <!-- Search Bar -->
                                <div class="mb-6">
                                    <div class="relative">
                                        <i
                                            class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm"></i>
                                        <input type="text" placeholder="Search..."
                                            class="w-full pl-11 pr-4 py-3 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm placeholder-gray-500">
                                    </div>
                                </div>

                                <!-- Repository List -->
                                <div
                                    class="border border-gray-800 rounded-lg overflow-hidden max-h-[400px] overflow-y-auto">
                                    <template x-for="repo in repositories" :key="repo.id">
                                        <div
                                            class="flex items-center justify-between px-4 py-4 bg-black hover:bg-gray-900 border-b border-gray-800 last:border-b-0 transition-colors">
                                            <div class="flex items-center gap-3">
                                                <i class="fab fa-github text-gray-500 text-lg"></i>
                                                <div>
                                                    <div class="text-white text-sm font-medium" x-text="repo.name"></div>
                                                    <div class="text-gray-500 text-xs" x-text="repo.updated"></div>
                                                </div>
                                            </div>
                                            <button @click="selectRepository(repo)"
                                                class="px-4 py-1.5 bg-white text-black rounded-md text-xs font-medium hover:bg-gray-200 transition-colors">
                                                Import
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>

        
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Database Modal -->
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
                                    <template x-for="region in ['US East (N. Virginia)', 'US West (Oregon)', 'Europe (Frankfurt)', 'Asia Pacific (Singapore)', 'Asia Pacific (Tokyo)']" :key="region">
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
                                                <input type="text" :name="'env_key[]'" x-model="envVar.key"
                                                    placeholder="KEY"
                                                    class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                                <input type="text" :name="'env_value[]'" x-model="envVar.value"
                                                    placeholder="value"
                                                    class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                                <button type="button"
                                                    @click="newDatabase.envVars.splice(index, 1)"
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

            <!-- Deploy Configuration Modal -->
            <div x-show="showDeployModal" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                @click.self="showDeployModal = false"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80"
                style="backdrop-filter: blur(4px);">
                <div class="bg-black border border-gray-800 rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                    @click.stop x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

                    <!-- Modal Header -->
                    <div class="border-b border-gray-800 p-8">
                        <h1 class="text-2xl font-bold text-white mb-2">New Project</h1>

                        <!-- Importing Info -->
                        <div class="flex items-center gap-2 text-sm text-gray-400 mt-4">
                            <i class="fab fa-github"></i>
                            <span x-text="selectedRepo ? selectedRepo.fullName : 'Custom Import'"></span>
                        </div>
                    </div>

                    <form action="{{ route('projects.store') }}" method="POST" class="p-8 space-y-6">
                        @csrf
                        <p class="text-sm text-gray-400 mb-6">
                            Choose where you want to create the project and give it a name.
                        </p>

                        <!-- Project Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Project Name</label>
                            <input type="text" name="name" x-model="newProject.name" required
                                class="w-full px-4 py-2 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm">
                            <input type="hidden" name="github_repo" x-model="selectedRepo ? selectedRepo.fullName : ''">
                            <input type="hidden" name="git_url" x-model="newProject.gitUrl">
                            <input type="hidden" name="branch" value="main">
                        </div>

                        <!-- Framework Preset -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Framework Preset</label>
                            <div x-data="{ open: false }" class="relative">
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-left">
                                    <span class="text-white text-sm" x-text="newProject.framework"></span>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition
                                    class="absolute w-full mt-2 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl max-h-60 overflow-y-auto z-10">
                                    <template x-for="fw in ['Next.js', 'Vite', 'Laravel', 'Express.js', 'Other']"
                                        :key="fw">
                                        <button type="button" @click="newProject.framework = fw; open = false"
                                            class="w-full px-4 py-2 hover:bg-gray-800 transition-colors text-left text-white text-sm">
                                            <span x-text="fw"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <input type="hidden" name="framework" x-model="newProject.framework">
                        </div>

                        <!-- Root Directory -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Root Directory</label>
                            <div class="flex gap-2">
                                <input type="text" name="root_directory" x-model="newProject.rootDir"
                                    :readonly="!editingRootDir"
                                    class="flex-1 px-4 py-2 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm">
                                <button type="button" @click="editingRootDir = !editingRootDir"
                                    class="px-4 py-2 border border-gray-800 rounded-lg text-sm text-gray-400 hover:text-white hover:border-gray-700 transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Collapsible Sections -->
                        <div class="space-y-3">
                            <!-- Build Settings -->
                            <div x-data="{ open: false }" class="border border-gray-800 rounded-lg">
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-3 text-left">
                                    <span class="text-white text-sm font-medium">Build and Output Settings</span>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs"
                                        :class="open ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="open" x-transition class="px-4 pb-4 space-y-4">
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">Build Command</label>
                                        <input type="text" name="build_command" x-model="newProject.buildCommand"
                                            placeholder="npm run build"
                                            class="w-full px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">Output Directory</label>
                                        <input type="text" name="output_directory" x-model="newProject.outputDir"
                                            placeholder="dist"
                                            class="w-full px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
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
                                        <template x-for="(envVar, index) in newProject.envVars" :key="index">
                                            <div class="flex gap-2">
                                                <input type="text" :name="'environment_variables[' + index + '][key]'"
                                                    x-model="envVar.key" placeholder="KEY"
                                                    class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                                <input type="text"
                                                    :name="'environment_variables[' + index + '][value]'"
                                                    x-model="envVar.value" placeholder="value"
                                                    class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm">
                                                <button type="button" @click="newProject.envVars.splice(index, 1)"
                                                    class="px-3 py-2 text-red-400 hover:text-red-300">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                    <button type="button" @click="newProject.envVars.push({ key: '', value: '' })"
                                        class="text-sm text-blue-400 hover:text-blue-300">
                                        <i class="fas fa-plus mr-1"></i> Add Variable
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Deploy Button -->
                        <button type="submit"
                            class="w-full px-4 py-3 bg-white text-black rounded-lg font-medium hover:bg-gray-200 transition-colors text-sm">
                            Deploy
                        </button>
                    </form>
                </div>
            </div>

            <script>
                function dashboardApp() {
                    return {
                        viewMode: 'grid',
                        searchQuery: '',
                        showNewProjectModal: false,
                        showNewDatabaseModal: false,
                        showDeployModal: false,
                        selectedRepo: null,
                        editingRootDir: false,
                        allProjects: @json($projects),
                        repositories: [{
                                id: 1,
                                name: 'EDA',
                                fullName: 'raffayuda/EDA',
                                updated: '2d ago',
                                url: 'https://github.com/raffayuda/EDA'
                            },
                            {
                                id: 2,
                                name: 'Pemesanan-tiket-bioskop',
                                fullName: 'raffayuda/Pemesanan-tiket-bioskop',
                                updated: '7h ago',
                                url: 'https://github.com/raffayuda/Pemesanan-tiket-bioskop'
                            },
                            {
                                id: 3,
                                name: 'Information-retrieval',
                                fullName: 'raffayuda/Information-retrieval',
                                updated: 'Nov 2',
                                url: 'https://github.com/raffayuda/Information-retrieval'
                            },
                            {
                                id: 4,
                                name: 'Machine-Learning',
                                fullName: 'raffayuda/Machine-Learning',
                                updated: 'Nov 1',
                                url: 'https://github.com/raffayuda/Machine-Learning'
                            },
                            {
                                id: 5,
                                name: 'hyperscale-KWU',
                                fullName: 'raffayuda/hyperscale-KWU',
                                updated: 'Oct 12',
                                url: 'https://github.com/raffayuda/hyperscale-KWU'
                            }
                        ],
                        templates: [{
                                id: 1,
                                name: 'Next.js Boilerplate',
                                description: 'Get started with Next.js and React in seconds.',
                                icon: '⚛️'
                            },
                            {
                                id: 2,
                                name: 'AI Chatbot',
                                description: 'A full-featured, hackable Next.js AI chatbot built by Vercel',
                                icon: '🤖'
                            },
                            {
                                id: 3,
                                name: 'Vite + React Starter',
                                description: 'Vite/React site that can be deployed to Vercel',
                                icon: '⚡'
                            },
                            {
                                id: 4,
                                name: 'Express.js on Vercel',
                                description: 'Simple Express.js + Vercel example that serves html content',
                                icon: '🚀'
                            }
                        ],
                        newProject: {
                            name: '',
                            gitUrl: '',
                            framework: 'Other',
                            rootDir: './',
                            buildCommand: '',
                            outputDir: '',
                            envVars: []
                        },
                        newDatabase: {
                            name: '',
                            type: 'PostgreSQL',
                            region: 'US East (N. Virginia)',
                            connectionLimit: 100,
                            storageSize: 10,
                            autoBackup: true,
                            envVars: []
                        },

                        get filteredProjects() {
                            if (!this.searchQuery) return this.allProjects;

                            const query = this.searchQuery.toLowerCase();
                            return this.allProjects.filter(project =>
                                project.name.toLowerCase().includes(query) ||
                                (project.url && project.url.toLowerCase().includes(query)) ||
                                (project.github_repo && project.github_repo.toLowerCase().includes(query))
                            );
                        },

                        selectRepository(repo) {
                            // Set selected repository
                            this.selectedRepo = repo;

                            // Auto-fill project name from repository name
                            this.newProject.name = repo.name;

                            // Set git URL
                            this.newProject.gitUrl = repo.url;

                            // Close first modal and open deploy modal
                            this.showNewProjectModal = false;
                            this.showDeployModal = true;
                        },

                        selectTemplate(template) {
                            this.newProject.name = template.name.toLowerCase().replace(/\s+/g, '-');
                            this.selectedRepo = null;
                            this.newProject.gitUrl = '';
                            this.showNewProjectModal = false;
                            this.showDeployModal = true;
                        },

                        importRepository() {
                            if (this.newProject.gitUrl) {
                                this.selectedRepo = null;
                                this.showNewProjectModal = false;
                                this.showDeployModal = true;
                            }
                        }
                    }
                }
            </script>
        </div>
    @endsection
