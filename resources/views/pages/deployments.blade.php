@extends('layouts.app')
@section('content')
<div x-data="deploymentsApp()">
<!-- Main Content -->
<div class="mx-auto px-6 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Deployments</h1>
        <p class="text-sm text-gray-400">
            All deployments from <span class="font-mono text-white">all projects</span>
        </p>
    </div>

    <!-- Filters Bar -->
    <div class="flex items-center gap-4 mb-6">
        <!-- Date Range Filter -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" 
                    class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm">
                <i class="far fa-calendar"></i>
                <span x-text="dateRange || 'Select Date Range'"></span>
            </button>
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition
                 class="absolute left-0 mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-10">
                <button @click="setDateRange('today'); open = false" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                    Today
                </button>
                <button @click="setDateRange('yesterday'); open = false" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                    Yesterday
                </button>
                <button @click="setDateRange('week'); open = false" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                    Last 7 Days
                </button>
                <button @click="setDateRange('month'); open = false" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                    Last 30 Days
                </button>
                <button @click="setDateRange('all'); open = false" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                    All Time
                </button>
            </div>
        </div>

        <!-- Author Filter -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" 
                    class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm">
                <i class="fas fa-user"></i>
                <span x-text="selectedAuthor || 'All Authors...'"></span>
                <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition
                 class="absolute left-0 mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-10 max-h-60 overflow-y-auto">
                <button @click="selectedAuthor = null; open = false" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                    All Authors
                </button>
                <template x-for="author in authors" :key="author">
                    <button @click="selectedAuthor = author; open = false" 
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                        <span x-text="author"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Environment Filter -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" 
                    class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm">
                <span x-text="selectedEnvironment || 'All Environments'"></span>
                <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition
                 class="absolute left-0 mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-10">
                <button @click="selectedEnvironment = null; open = false" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                    All Environments
                </button>
                <template x-for="env in environments" :key="env">
                    <button @click="selectedEnvironment = env; open = false" 
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                        <span x-text="env"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Status Filter -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" 
                    class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm">
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                </div>
                <span>Status <span x-text="filteredDeployments.length + '/' + allDeployments.length"></span></span>
                <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition
                 class="absolute left-0 mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-10">
                <button @click="selectedStatus = null; open = false" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                    All Status
                </button>
                <button @click="selectedStatus = 'Ready'; open = false" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    Ready
                </button>
                <button @click="selectedStatus = 'Building'; open = false" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors flex items-center gap-2">
                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                    Building
                </button>
                <button @click="selectedStatus = 'Error'; open = false" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors flex items-center gap-2">
                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                    Error
                </button>
            </div>
        </div>
    </div>

    <!-- Deployments List -->
    <div class="space-y-0 border border-gray-800 rounded-lg overflow-hidden">
        <template x-if="filteredDeployments.length === 0">
            <!-- Empty State -->
            <div class="px-6 py-12 text-center">
                <div class="text-gray-500 mb-2">
                    <i class="fas fa-filter text-4xl mb-4"></i>
                </div>
                <p class="text-gray-400">No deployments found</p>
                <p class="text-sm text-gray-600 mt-1">Try adjusting your filters</p>
            </div>
        </template>
        
        <template x-for="deployment in filteredDeployments" :key="deployment.id">
        <a :href="'/project/' + deployment.project.id">
        <div class="border-b border-gray-800 last:border-b-0 hover:bg-gray-900/50 transition-colors">
            <div class="px-6 py-4 flex items-center gap-6">
                <!-- Deployment ID & Status -->
                <div class="flex-shrink-0 w-32">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full" :class="{
                                'bg-green-500': deployment.status === 'Ready',
                                'bg-yellow-500': deployment.status === 'Building',
                                'bg-red-500': deployment.status === 'Error'
                            }"></div>
                            <span class="text-sm text-gray-400" x-text="deployment.status"></span>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 mt-1" x-text="deployment.deployment_id"></div>
                    <div class="text-xs text-gray-600 mt-0.5">
                        <span x-text="deployment.environment"></span>
                        <i class="fas fa-circle text-[4px] align-middle mx-1"></i> 
                        <span x-show="deployment.is_current" class="text-blue-400">Current</span>
                    </div>
                </div>

                <!-- Time -->
                <div class="flex-shrink-0 w-24 text-xs text-gray-500" x-text="deployment.time_formatted"></div>

                <!-- Project & Commit Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3">
                        <!-- Project Icon -->
                        <div class="w-6 h-6 bg-white rounded flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-triangle text-black text-[8px]"></i>
                        </div>
                        
                        <!-- Project Name -->
                        <div class="min-w-0">
                            <div class="text-sm font-medium text-white truncate" x-text="deployment.project.name"></div>
                        </div>
                    </div>

                    <!-- Branch & Commit -->
                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-code-branch text-[10px]"></i>
                            <span x-text="deployment.branch"></span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-dot-circle text-[8px]"></i>
                            <span x-text="deployment.commit_hash"></span>
                            <span class="text-gray-600" x-text="deployment.commit_message"></span>
                        </div>
                    </div>
                </div>

                <!-- Author & Time Ago -->
                <div class="flex-shrink-0 text-right">
                    <div class="text-sm text-gray-400" x-text="deployment.deployed_at_human"></div>
                    <div class="text-xs text-gray-600 mt-1">
                        by <span x-text="deployment.author"></span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex-shrink-0">
                    <button class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-800 transition-colors text-gray-400">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>
            </div>
        </div>
        </a>
        </template>
    </div>
</div>

<script>
function deploymentsApp() {
    return {
        allDeployments: @json($deployments),
        authors: @json($authors),
        environments: @json($environments),
        selectedAuthor: null,
        selectedEnvironment: null,
        selectedStatus: null,
        dateRange: null,
        
        get filteredDeployments() {
            let filtered = this.allDeployments;
            
            // Filter by author
            if (this.selectedAuthor) {
                filtered = filtered.filter(d => d.author === this.selectedAuthor);
            }
            
            // Filter by environment
            if (this.selectedEnvironment) {
                filtered = filtered.filter(d => d.environment === this.selectedEnvironment);
            }
            
            // Filter by status
            if (this.selectedStatus) {
                filtered = filtered.filter(d => d.status === this.selectedStatus);
            }
            
            // Filter by date range
            if (this.dateRange && this.dateRange !== 'all') {
                const now = new Date();
                filtered = filtered.filter(d => {
                    const deployedDate = new Date(d.deployed_at);
                    
                    switch(this.dateRange) {
                        case 'today':
                            return deployedDate.toDateString() === now.toDateString();
                        case 'yesterday':
                            const yesterday = new Date(now);
                            yesterday.setDate(yesterday.getDate() - 1);
                            return deployedDate.toDateString() === yesterday.toDateString();
                        case 'week':
                            const weekAgo = new Date(now);
                            weekAgo.setDate(weekAgo.getDate() - 7);
                            return deployedDate >= weekAgo;
                        case 'month':
                            const monthAgo = new Date(now);
                            monthAgo.setDate(monthAgo.getDate() - 30);
                            return deployedDate >= monthAgo;
                        default:
                            return true;
                    }
                });
            }
            
            return filtered;
        },
        
        setDateRange(range) {
            this.dateRange = range;
        }
    }
}
</script>
</div>
@endsection
