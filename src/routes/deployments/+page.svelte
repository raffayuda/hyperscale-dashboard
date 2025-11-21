<script lang="ts">
    import { clickOutside } from '$lib/actions/clickOutside';
    import { deployments as deploymentSeed } from '$lib/data/sample-data';
    import type { Deployment } from '$lib/types';

    type DateRange = 'today' | 'yesterday' | 'week' | 'month' | 'all' | null;

    const allDeployments: Deployment[] = deploymentSeed.map((deployment) => ({ ...deployment }));
    const authors = Array.from(new Set(allDeployments.map((deployment) => deployment.author)));
    const environments = Array.from(new Set(allDeployments.map((deployment) => deployment.environment)));

    let selectedAuthor: string | null = null;
    let selectedEnvironment: string | null = null;
    let selectedStatus: string | null = null;
    let dateRange: DateRange = null;
    let dateMenuOpen = false;
    let authorMenuOpen = false;
    let environmentMenuOpen = false;
    let statusMenuOpen = false;

    $: filteredDeployments = allDeployments.filter((deployment) => {
        if (selectedAuthor && deployment.author !== selectedAuthor) return false;
        if (selectedEnvironment && deployment.environment !== selectedEnvironment) return false;
        if (selectedStatus && deployment.status !== selectedStatus) return false;
        if (dateRange && dateRange !== 'all' && !matchesDateRange(deployment.deployedAt, dateRange)) return false;
        return true;
    });

    function matchesDateRange(dateStr: string, range: DateRange) {
        const deployedDate = new Date(dateStr);
        const now = new Date();

        switch (range) {
            case 'today':
                return deployedDate.toDateString() === now.toDateString();
            case 'yesterday': {
                const yesterday = new Date(now);
                yesterday.setDate(now.getDate() - 1);
                return deployedDate.toDateString() === yesterday.toDateString();
            }
            case 'week': {
                const weekAgo = new Date(now);
                weekAgo.setDate(now.getDate() - 7);
                return deployedDate >= weekAgo;
            }
            case 'month': {
                const monthAgo = new Date(now);
                monthAgo.setDate(now.getDate() - 30);
                return deployedDate >= monthAgo;
            }
            default:
                return true;
        }
    }
</script>

<div class="mx-auto px-6 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Deployments</h1>
        <p class="text-sm text-gray-400">All deployments from <span class="font-mono text-white">all projects</span></p>
    </div>

    <div class="flex items-center gap-4 mb-6 flex-wrap">
        <div class="relative" use:clickOutside={() => (dateMenuOpen = false)}>
            <button
                class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm"
                on:click={() => (dateMenuOpen = !dateMenuOpen)}
            >
                <i class="far fa-calendar"></i>
                <span>{dateRange ?? 'Select Date Range'}</span>
            </button>
            {#if dateMenuOpen}
                <div class="absolute left-0 top-full mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-10">
                    {#each ['today', 'yesterday', 'week', 'month', 'all'] as range}
                        <button
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors capitalize"
                            on:click={() => {
                                dateRange = range as DateRange;
                                dateMenuOpen = false;
                            }}
                        >
                            {range === 'all' ? 'All Time' : range}
                        </button>
                    {/each}
                </div>
            {/if}
        </div>

        <div class="relative" use:clickOutside={() => (authorMenuOpen = false)}>
            <button
                class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm"
                on:click={() => (authorMenuOpen = !authorMenuOpen)}
            >
                <i class="fas fa-user"></i>
                <span>{selectedAuthor ?? 'All Authors...'}</span>
                <i class="fas fa-chevron-down text-xs"></i>
            </button>
            {#if authorMenuOpen}
                <div class="absolute left-0 top-full mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-10 max-h-60 overflow-y-auto">
                    <button
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors"
                        on:click={() => {
                            selectedAuthor = null;
                            authorMenuOpen = false;
                        }}
                    >
                        All Authors
                    </button>
                    {#each authors as author}
                        <button
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors"
                            on:click={() => {
                                selectedAuthor = author;
                                authorMenuOpen = false;
                            }}
                        >
                            {author}
                        </button>
                    {/each}
                </div>
            {/if}
        </div>

        <div class="relative" use:clickOutside={() => (environmentMenuOpen = false)}>
            <button
                class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm"
                on:click={() => (environmentMenuOpen = !environmentMenuOpen)}
            >
                <span>{selectedEnvironment ?? 'All Environments'}</span>
                <i class="fas fa-chevron-down text-xs"></i>
            </button>
            {#if environmentMenuOpen}
                <div class="absolute left-0 top-full mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-10">
                    <button
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors"
                        on:click={() => {
                            selectedEnvironment = null;
                            environmentMenuOpen = false;
                        }}
                    >
                        All Environments
                    </button>
                    {#each environments as environment}
                        <button
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors"
                            on:click={() => {
                                selectedEnvironment = environment;
                                environmentMenuOpen = false;
                            }}
                        >
                            {environment}
                        </button>
                    {/each}
                </div>
            {/if}
        </div>

        <div class="relative" use:clickOutside={() => (statusMenuOpen = false)}>
            <button
                class="flex items-center gap-2 px-4 py-2 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-sm"
                on:click={() => (statusMenuOpen = !statusMenuOpen)}
            >
                <div class="flex items-center gap-1">
                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                </div>
                <span>Status {filteredDeployments.length}/{allDeployments.length}</span>
                <i class="fas fa-chevron-down text-xs"></i>
            </button>
            {#if statusMenuOpen}
                <div class="absolute left-0 top-full mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-10">
                    <button
                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors"
                        on:click={() => {
                            selectedStatus = null;
                            statusMenuOpen = false;
                        }}
                    >
                        All Status
                    </button>
                    {#each ['Ready', 'Building', 'Error'] as status}
                        <button
                            class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors flex items-center gap-2"
                            on:click={() => {
                                selectedStatus = status;
                                statusMenuOpen = false;
                            }}
                        >
                            <div
                                class={`w-2 h-2 rounded-full ${
                                    status === 'Ready' ? 'bg-green-500' : status === 'Building' ? 'bg-yellow-500' : 'bg-red-500'
                                }`}
                            ></div>
                            {status}
                        </button>
                    {/each}
                </div>
            {/if}
        </div>
    </div>

    <div class="space-y-0 border border-gray-800 rounded-lg overflow-hidden">
        {#if filteredDeployments.length === 0}
            <div class="px-6 py-12 text-center">
                <div class="text-gray-500 mb-4">
                    <i class="fas fa-filter text-4xl"></i>
                </div>
                <p class="text-gray-400">No deployments found</p>
                <p class="text-sm text-gray-600 mt-1">Try adjusting your filters</p>
            </div>
        {:else}
            {#each filteredDeployments as deployment (deployment.id)}
                <a href={`/project/${deployment.project.slug}`}>
                    <div class="border-b border-gray-800 last:border-b-0 hover:bg-gray-900/50 transition-colors">
                        <div class="px-6 py-4 flex items-center gap-6">
                            <div class="flex-shrink-0 w-32">
                                <div class="flex items-center gap-2">
                                    <div
                                        class={`w-2 h-2 rounded-full ${
                                            deployment.status === 'Ready'
                                                ? 'bg-green-500'
                                                : deployment.status === 'Building'
                                                  ? 'bg-yellow-500'
                                                  : 'bg-red-500'
                                        }`}
                                    ></div>
                                    <span class="text-sm text-gray-400">{deployment.status}</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{deployment.deploymentId}</div>
                                <div class="text-xs text-gray-600 mt-0.5">
                                    {deployment.environment}
                                    <i class="fas fa-circle text-[4px] align-middle mx-1"></i>
                                    {#if deployment.isCurrent}
                                        <span class="text-blue-400">Current</span>
                                    {/if}
                                </div>
                            </div>

                            <div class="flex-shrink-0 w-24 text-xs text-gray-500">{deployment.timeFormatted}</div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 bg-white rounded flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-triangle text-black text-[8px]"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium text-white truncate">{deployment.project.name}</div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-code-branch text-[10px]"></i>
                                        <span>{deployment.branch}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-dot-circle text-[8px]"></i>
                                        <span>{deployment.commitHash}</span>
                                        <span class="text-gray-600">{deployment.commitMessage}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-shrink-0 text-right">
                                <div class="text-sm text-gray-400">{deployment.deployedAtHuman}</div>
                                <div class="text-xs text-gray-600 mt-1">
                                    by <span>{deployment.author}</span>
                                </div>
                            </div>

                            <div class="flex-shrink-0">
                                <button
                                    class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-800 transition-colors text-gray-400"
                                    aria-label="Open deployment menu"
                                >
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            {/each}
        {/if}
    </div>
</div>

