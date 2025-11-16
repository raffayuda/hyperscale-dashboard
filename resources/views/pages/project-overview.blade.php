@extends('layouts.app')
@section('content')
<div x-data="projectOverviewApp()">

<!-- Main Content -->
<div class="mx-auto px-6 py-8">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-sm text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Back to Projects
        </a>
    </div>

    <!-- Project Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center">
                <i class="fas fa-triangle text-black text-xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-white">{{ $project->name }}</h1>
                <a href="https://{{ $project->url }}" target="_blank" class="text-sm text-blue-400 hover:underline">
                    <span>{{ $project->url }}</span>
                    <i class="fas fa-external-link-alt text-xs ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-800 mb-8">
        <nav class="flex gap-6">
            <button @click="activeTab = 'overview'" 
                    :class="activeTab === 'overview' ? 'border-b-2 border-white text-white' : 'text-gray-400 hover:text-white'"
                    class="pb-3 text-sm font-medium transition-colors">
                Overview
            </button>
            <button @click="activeTab = 'deployments'" 
                    :class="activeTab === 'deployments' ? 'border-b-2 border-white text-white' : 'text-gray-400 hover:text-white'"
                    class="pb-3 text-sm font-medium transition-colors">
                Deployments
            </button>
            <button @click="activeTab = 'analytics'" 
                    :class="activeTab === 'analytics' ? 'border-b-2 border-white text-white' : 'text-gray-400 hover:text-white'"
                    class="pb-3 text-sm font-medium transition-colors">
                Analytics
            </button>
            <button @click="activeTab = 'speed'" 
                    :class="activeTab === 'speed' ? 'border-b-2 border-white text-white' : 'text-gray-400 hover:text-white'"
                    class="pb-3 text-sm font-medium transition-colors">
                Speed Insights
            </button>
            <button @click="activeTab = 'logs'" 
                    :class="activeTab === 'logs' ? 'border-b-2 border-white text-white' : 'text-gray-400 hover:text-white'"
                    class="pb-3 text-sm font-medium transition-colors">
                Logs
            </button>
            <button @click="activeTab = 'observability'" 
                    :class="activeTab === 'observability' ? 'border-b-2 border-white text-white' : 'text-gray-400 hover:text-white'"
                    class="pb-3 text-sm font-medium transition-colors">
                Observability
            </button>
            <button @click="activeTab = 'firewall'" 
                    :class="activeTab === 'firewall' ? 'border-b-2 border-white text-white' : 'text-gray-400 hover:text-white'"
                    class="pb-3 text-sm font-medium transition-colors">
                Firewall
            </button>
            <button @click="activeTab = 'ai'" 
                    :class="activeTab === 'ai' ? 'border-b-2 border-white text-white' : 'text-gray-400 hover:text-white'"
                    class="pb-3 text-sm font-medium transition-colors">
                AI
            </button>
            <button @click="activeTab = 'storage'" 
                    :class="activeTab === 'storage' ? 'border-b-2 border-white text-white' : 'text-gray-400 hover:text-white'"
                    class="pb-3 text-sm font-medium transition-colors">
                Storage
            </button>
            <button @click="activeTab = 'flags'" 
                    :class="activeTab === 'flags' ? 'border-b-2 border-white text-white' : 'text-gray-400 hover:text-white'"
                    class="pb-3 text-sm font-medium transition-colors">
                Flags
            </button>
            <button @click="activeTab = 'settings'" 
                    :class="activeTab === 'settings' ? 'border-b-2 border-white text-white' : 'text-gray-400 hover:text-white'"
                    class="pb-3 text-sm font-medium transition-colors">
                Settings
            </button>
        </nav>
    </div>

    <!-- Overview Tab Content -->
    <div x-show="activeTab === 'overview'">
        <!-- Project Preview & Info -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <!-- Left Column - Preview -->
            <div class="col-span-2">
                <div class="bg-gray-900 rounded-lg border border-gray-800 overflow-hidden">
                    <div class="aspect-video bg-gray-950 flex items-center justify-center relative">
                        <img :src="project.preview_image || '/images/preview-placeholder.png'" 
                             :alt="project.name + ' preview'"
                             class="w-full h-full object-cover"
                             >
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-image text-gray-700 text-6xl mb-4"></i>
                                <p class="text-gray-600 text-sm">Preview</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Info -->
            <div class="space-y-4">
                <!-- Production Deployment -->
                <div class="bg-gray-900 rounded-lg border border-gray-800 p-6">
                    <h3 class="text-sm font-semibold text-white mb-4">Production Deployment</h3>
                    
                    <div class="space-y-3">
                        <!-- Domains -->
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Domains</p>
                            <a href="https://{{ $project->url }}" 
                               target="_blank"
                               class="text-sm text-blue-400 hover:underline flex items-center gap-1">
                                <span class="truncate">{{ $project->url }}</span>
                                <i class="fas fa-external-link-alt text-xs"></i>
                            </a>
                        </div>

                        <!-- Status -->
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Status</p>
                            <div class="flex items-center gap-2">
                                <div class="{{ $project->status === 'Ready' ? 'bg-green-500' : 'bg-yellow-500' }} w-2 h-2 rounded-full"></div>
                                <span class="text-sm text-white">{{ $project->status }}</span>
                            </div>
                        </div>

                        <!-- Created -->
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Created</p>
                            <p class="text-sm text-white">
                                {{ $project->created_at->format('M d, Y') }} 
                                @if($project->github_repo)
                                by {{ explode('/', $project->github_repo)[0] }}
                                @endif
                            </p>
                        </div>

                        <!-- Source -->
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Source</p>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-sm">
                                    <i class="fas fa-code-branch text-gray-400 text-xs"></i>
                                    <span class="text-white">{{ $project->branch ?? 'main' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <i class="fas fa-dot-circle text-gray-400 text-xs"></i>
                                    <span class="text-gray-400 truncate">{{ $project->last_commit ?? 'No commits yet' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deployments Button -->
                    <a href="{{ route('deployments') }}" 
                       class="w-full mt-6 px-4 py-2 bg-white text-black rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-list"></i>
                        <span>Deployments</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Deployment Settings -->
        <div class="bg-gray-900 rounded-lg border border-gray-800 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <h3 class="text-lg font-semibold text-white">Deployment Settings</h3>
                    <span class="px-2 py-0.5 bg-blue-500/20 text-blue-400 rounded text-xs font-medium">
                        3 Recommendations
                    </span>
                </div>
            </div>
            
            <div class="mt-4 p-4 bg-gray-950 rounded-lg border border-gray-800">
                <p class="text-sm text-gray-400">
                    To update your Production Deployment, push to the 
                    <span class="font-mono text-white">{{ $project->branch ?? 'main' }}</span> branch.
                </p>
            </div>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-3 gap-6">
            <!-- Firewall -->
            <div class="bg-gray-900 rounded-lg border border-gray-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-semibold text-white">Firewall</h3>
                        <span class="text-xs text-gray-500">24h</span>
                    </div>
                    <button class="text-gray-400 hover:text-white">
                        <i class="fas fa-shield-alt text-blue-400"></i>
                    </button>
                </div>

                <div class="flex items-center justify-center py-8">
                    <div class="text-center">
                        <i class="fas fa-shield-alt text-blue-400 text-5xl mb-4"></i>
                        <p class="text-blue-400 text-sm font-medium">Firewall is active</p>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-800">
                    <span class="text-xs text-gray-500">Enable Bot Protection</span>
                    <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
                </div>
            </div>

            <!-- Observability -->
            <div class="bg-gray-900 rounded-lg border border-gray-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-semibold text-white">Observability</h3>
                        <span class="text-xs text-gray-500">6h</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
                </div>

                <div class="space-y-4">
                    <!-- Edge Requests -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2">Edge Requests</p>
                        <p class="text-2xl font-bold text-white">205</p>
                        <div class="mt-2 h-12 relative">
                            <svg class="w-full h-full" viewBox="0 0 200 50">
                                <polyline fill="none" stroke="#3b82f6" stroke-width="2" 
                                          points="0,45 40,43 80,42 120,38 160,35 200,30"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Function Invocations -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2">Function Invocations</p>
                        <p class="text-2xl font-bold text-white">151</p>
                        <div class="mt-2 h-12 relative">
                            <svg class="w-full h-full" viewBox="0 0 200 50">
                                <polyline fill="none" stroke="#3b82f6" stroke-width="2" 
                                          points="0,48 40,47 80,45 120,42 160,38 200,32"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Error Rate -->
                    <div>
                        <p class="text-xs text-gray-500 mb-2">Error Rate</p>
                        <p class="text-2xl font-bold text-white">0%</p>
                    </div>
                </div>
            </div>

            <!-- Analytics -->
            <div class="bg-gray-900 rounded-lg border border-gray-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-semibold text-white">Analytics</h3>
                        <span class="text-xs text-gray-500">1w</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
                </div>

                <div class="flex items-center justify-center py-16">
                    <div class="text-center">
                        <p class="text-gray-500 text-sm mb-2">No data</p>
                        <p class="text-2xl font-bold text-white">0 <span class="text-sm font-normal text-gray-500">online</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Tabs (Placeholder) -->
    <div x-show="activeTab !== 'overview'" class="text-center py-16">
        <p class="text-gray-400">
            <span class="capitalize" x-text="activeTab"></span> content coming soon...
        </p>
    </div>
</div>

<script>
function projectOverviewApp() {
    return {
        activeTab: 'overview'
    }
}
</script>

</div>
@endsection
