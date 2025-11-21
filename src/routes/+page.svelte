<script lang="ts">
    import { clickOutside } from '$lib/actions/clickOutside';
    import { projects as projectSeed, repositories, templates } from '$lib/data/sample-data';
    import type {
        NewDatabaseForm,
        NewProjectForm,
        Project,
        Repository,
        TemplateProject
    } from '$lib/types';

    const cloneProjects = () => projectSeed.map((project) => ({ ...project }));

    type ViewMode = 'grid' | 'list';

    let projects: Project[] = cloneProjects();
    let searchQuery = '';
    let viewMode: ViewMode = 'grid';
    let addMenuOpen = false;
    let showNewProjectModal = false;
    let showNewDatabaseModal = false;
    let showDeployModal = false;
    let selectedRepo: Repository | null = null;
    let editingRootDir = false;

    const defaultProjectForm = (): NewProjectForm => ({
        name: '',
        gitUrl: '',
        framework: 'Other',
        rootDir: './',
        buildCommand: '',
        outputDir: '',
        envVars: []
    });

    const defaultDatabaseForm = (): NewDatabaseForm => ({
        name: '',
        type: 'PostgreSQL',
        region: 'US East (N. Virginia)',
        connectionLimit: 100,
        storageSize: 10,
        autoBackup: true,
        envVars: []
    });

    let newProject: NewProjectForm = defaultProjectForm();
    let newDatabase: NewDatabaseForm = defaultDatabaseForm();

    $: filteredProjects = projects.filter((project) => {
        if (!searchQuery) return true;
        const query = searchQuery.toLowerCase();
        return (
            project.name.toLowerCase().includes(query) ||
            project.url.toLowerCase().includes(query) ||
            project.githubRepo?.toLowerCase().includes(query)
        );
    });

    const viewClasses: Record<ViewMode, string> = {
        grid: 'grid grid-cols-1 lg:grid-cols-4 gap-4',
        list: 'space-y-2'
    };

    function selectRepository(repo: Repository) {
        selectedRepo = repo;
        newProject.name = repo.name;
        newProject.gitUrl = repo.url;
        showNewProjectModal = false;
        showDeployModal = true;
    }

    function selectTemplate(template: TemplateProject) {
        newProject = {
            ...defaultProjectForm(),
            name: template.name.toLowerCase().replace(/\s+/g, '-')
        };
        selectedRepo = null;
        showNewProjectModal = false;
        showDeployModal = true;
    }

    function importRepository() {
        if (!newProject.gitUrl) return;
        selectedRepo = null;
        showNewProjectModal = false;
        showDeployModal = true;
    }

    function handleDeploySubmit(event: SubmitEvent) {
        event.preventDefault();
        const slug = newProject.name.toLowerCase().replace(/\s+/g, '-');
        projects = [
            ...projects,
            {
                id: crypto.randomUUID(),
                slug,
                name: newProject.name,
                url: `${slug}.hyperscale.dev`,
                status: 'Ready',
                githubRepo: selectedRepo?.fullName,
                branch: 'main',
                updatedAt: new Date().toISOString(),
                updatedAtHuman: 'just now',
                lastCommit: 'Initial deploy',
                previewImage: ''
            }
        ];

        newProject = defaultProjectForm();
        selectedRepo = null;
        showDeployModal = false;
    }

    function handleDatabaseSubmit(event: SubmitEvent) {
        event.preventDefault();
        newDatabase = defaultDatabaseForm();
        showNewDatabaseModal = false;
    }

    function toggleProjectModal(action: 'project' | 'database') {
        if (action === 'project') {
            showNewProjectModal = true;
            showNewDatabaseModal = false;
        } else {
            showNewDatabaseModal = true;
            showNewProjectModal = false;
        }
        addMenuOpen = false;
    }
</script>

<div class="flex w-full">
    <div class="flex bg-black w-full">
        <div class="p-6 w-full">
            <div class="mb-6 w-full">
                <div class="flex items-center gap-5 justify-between w-full">
                    <div class="flex-1 relative">
                        <input
                            type="text"
                            bind:value={searchQuery}
                            placeholder="Search Projects..."
                            class="w-full pl-10 pr-4 py-2 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm placeholder-gray-500"
                        />
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                    </div>

                    <div class="flex gap-0 border border-gray-800 rounded-lg overflow-hidden">
                        <button
                            class={`px-3 py-2 text-gray-400 hover:text-white transition-colors border-l border-gray-800 ${
                                viewMode === 'grid' ? 'bg-gray-800 text-white' : 'bg-black'
                            }`}
                            on:click={() => (viewMode = 'grid')}
                            aria-label="Grid view"
                        >
                            <i class="fas fa-th text-sm"></i>
                        </button>
                        <button
                            class={`px-3 py-2 text-gray-400 hover:text-white transition-colors border-l border-gray-800 ${
                                viewMode === 'list' ? 'bg-gray-800 text-white' : 'bg-black'
                            }`}
                            on:click={() => (viewMode = 'list')}
                            aria-label="List view"
                        >
                            <i class="fas fa-list text-sm"></i>
                        </button>
                    </div>

                    <div class="relative" use:clickOutside={() => (addMenuOpen = false)}>
                        <button
                            class="bg-white text-black px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center gap-2"
                            on:click={() => (addMenuOpen = !addMenuOpen)}
                        >
                            <span>Add New...</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        {#if addMenuOpen}
                            <div
                                class="absolute right-0 mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-10"
                            >
                                <button
                                    class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors"
                                    on:click={() => toggleProjectModal('project')}
                                >
                                    <i class="fas fa-plus w-4"></i> Project
                                </button>
                                <button
                                    class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors"
                                    on:click={() => toggleProjectModal('database')}
                                >
                                    <i class="fas fa-database w-4"></i> Database
                                </button>
                                <button
                                    class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors"
                                >
                                    <i class="fas fa-globe w-4"></i> Domain
                                </button>
                            </div>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-white">Projects</h2>
            </div>

            {#if !projects.length}
                <div class="flex flex-col items-center justify-center py-20">
                    <div class="w-16 h-16 bg-gray-900 border border-gray-800 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-folder-open text-gray-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-white mb-2">No projects yet</h3>
                    <p class="text-gray-400 text-sm mb-6">Get started by deploying your first project</p>
                    <button
                        class="bg-white text-black px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors"
                        on:click={() => (showNewProjectModal = true)}
                    >
                        <i class="fas fa-plus mr-2"></i>New Project
                    </button>
                </div>
            {:else}
                {#if filteredProjects.length === 0 && searchQuery}
                    <div class="flex flex-col items-center justify-center py-20">
                        <div class="w-16 h-16 bg-gray-900 border border-gray-800 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-search text-gray-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">No results found</h3>
                        <p class="text-gray-400 text-sm mb-6">Try searching with different keywords</p>
                    </div>
                {/if}

                {#if filteredProjects.length > 0}
                    <div class={viewClasses[viewMode]}>
                        {#each filteredProjects as project (project.id)}
                            <a
                                href={`/project/${project.slug}`}
                                class={`bg-gray-900 border border-gray-800 rounded-lg hover:border-gray-700 transition-all cursor-pointer ${
                                    viewMode === 'list' ? 'flex items-center' : ''
                                }`}
                            >
                                <div class={viewMode === 'list' ? 'p-4 flex items-center gap-4 w-full' : 'p-5'}>
                                    <div
                                        class={`${
                                            viewMode === 'list'
                                                ? 'flex items-center gap-3 flex-1'
                                                : 'flex items-start justify-between mb-4'
                                        }`}
                                    >
                                        <div class="flex items-center gap-3 flex-1 min-w-0">
                                            <div class="w-10 h-10 bg-white rounded flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-triangle text-black text-xs"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-semibold text-white text-sm mb-1 truncate">{project.name}</h3>
                                                <p class="text-xs text-gray-500 truncate">
                                                    {project.url.replace('https://', '')}
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class={`${
                                                viewMode === 'list' ? 'flex items-center gap-4' : 'flex items-center gap-2'
                                            }`}
                                        >
                                            {#if viewMode !== 'list'}
                                                <button
                                                    class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white transition-colors"
                                                    aria-label="View metrics"
                                                >
                                                    <i class="fas fa-chart-line text-sm"></i>
                                                </button>
                                            {/if}
                                            <button
                                                class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white transition-colors"
                                                on:click|preventDefault|stopPropagation={() => {}}
                                                aria-label="Open project menu"
                                            >
                                                <i class="fas fa-ellipsis-h text-sm"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {#if viewMode !== 'list'}
                                        <div>
                                            <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                                                <i class="fab fa-github"></i>
                                                <span>{project.githubRepo ?? 'No repository'}</span>
                                            </div>
                                            <div class="flex items-center gap-2 mb-2">
                                                <div
                                                    class={`w-2 h-2 rounded-full ${
                                                        project.status === 'Ready' ? 'bg-green-500' : 'bg-yellow-500'
                                                    }`}
                                                ></div>
                                                <p class="text-sm text-gray-300">{project.status}</p>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <span>{project.updatedAtHuman}</span>
                                                <span>on</span>
                                                <i class="fas fa-code-branch text-[10px]"></i>
                                                <span>{project.branch || 'main'}</span>
                                            </div>
                                        </div>
                                    {:else}
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class={`w-2 h-2 rounded-full ${
                                                        project.status === 'Ready' ? 'bg-green-500' : 'bg-yellow-500'
                                                    }`}
                                                ></div>
                                                <p class="text-sm text-gray-300">{project.status}</p>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <i class="fas fa-code-branch text-[10px]"></i>
                                                <span>{project.branch ?? 'main'}</span>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <span>{project.updatedAtHuman}</span>
                                            </div>
                                        </div>
                                    {/if}
                                </div>
                            </a>
                        {/each}
                    </div>
                {/if}
            {/if}
        </div>
    </div>
</div>

{#if showNewProjectModal}
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-[#0a0a0a] border border-gray-800 rounded-xl shadow-2xl max-w-7xl w-full max-h-[90vh] overflow-y-auto p-8">
            <div class="flex justify-end mb-4">
                <button
                    class="text-gray-400 hover:text-white transition-colors"
                    aria-label="Close modal"
                    on:click={() => (showNewProjectModal = false)}
                >
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-6">Import Git Repository</h2>
                    <div class="relative mb-4">
                        <button
                            class="w-full flex items-center justify-between px-4 py-3 bg-black border border-gray-800 rounded-lg hover:border-gray-700 transition-colors text-left"
                        >
                            <div class="flex items-center gap-3">
                                <i class="fab fa-github text-gray-400 text-lg"></i>
                                <span class="text-white text-sm">raffayuda</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </button>
                    </div>
                    <div class="mb-6">
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm"></i>
                            <input
                                type="text"
                                placeholder="Search..."
                                class="w-full pl-11 pr-4 py-3 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm placeholder-gray-500"
                            />
                        </div>
                    </div>
                    <div class="border border-gray-800 rounded-lg overflow-hidden max-h-[400px] overflow-y-auto">
                        {#each repositories as repo (repo.id)}
                            <div class="flex items-center justify-between px-4 py-4 bg-black hover:bg-gray-900 border-b border-gray-800 last:border-b-0 transition-colors">
                                <div class="flex items-center gap-3">
                                    <i class="fab fa-github text-gray-500 text-lg"></i>
                                    <div>
                                        <div class="text-white text-sm font-medium">{repo.name}</div>
                                        <div class="text-gray-500 text-xs">{repo.updated}</div>
                                    </div>
                                </div>
                                <button
                                    class="px-4 py-1.5 bg-white text-black rounded-md text-xs font-medium hover:bg-gray-200 transition-colors"
                                    on:click={() => selectRepository(repo)}
                                >
                                    Import
                                </button>
                            </div>
                        {/each}
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-white mb-6">Starter Templates</h2>
                    <div class="space-y-4">
                        {#each templates as template (template.id)}
                            <button
                                class="w-full text-left bg-black border border-gray-800 rounded-xl p-4 hover:border-gray-700 transition-colors"
                                on:click={() => selectTemplate(template)}
                            >
                                <div class="flex items-center gap-4">
                                    <span class="text-2xl">{template.icon}</span>
                                    <div>
                                        <p class="text-white font-semibold text-sm">{template.name}</p>
                                        <p class="text-gray-500 text-xs">{template.description}</p>
                                    </div>
                                </div>
                            </button>
                        {/each}
                    </div>
                    <div class="mt-8">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <span>Import via Git URL</span>
                            <input
                                type="text"
                                placeholder="https://github.com/user/repo.git"
                                class="mt-2 w-full px-4 py-3 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm placeholder-gray-500"
                                bind:value={newProject.gitUrl}
                            />
                        </label>
                        <button
                            class="mt-3 w-full px-4 py-3 bg-white text-black rounded-lg font-medium hover:bg-gray-200 transition-colors text-sm"
                            on:click={importRepository}
                        >
                            Continue
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}

{#if showNewDatabaseModal}
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-black border border-gray-800 rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="border-b border-gray-800 p-8">
                <h1 class="text-2xl font-bold text-white mb-2">Create New Database</h1>
                <p class="text-sm text-gray-400">Set up a new database for your project</p>
            </div>
            <form class="p-8 space-y-6" on:submit={handleDatabaseSubmit}>
                <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <span>Database Name</span>
                            <input
                                type="text"
                                class="mt-2 w-full px-4 py-2 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm"
                                placeholder="my-database"
                                bind:value={newDatabase.name}
                                required
                            />
                        </label>
                    <p class="text-xs text-gray-500 mt-1">Choose a unique name for your database</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <span>Database Type</span>
                        <select
                            class="mt-2 w-full px-4 py-2 bg-black border border-gray-800 rounded-lg text-white text-sm"
                            bind:value={newDatabase.type}
                        >
                            <option>PostgreSQL</option>
                            <option>MySQL</option>
                            <option>MongoDB</option>
                            <option>Redis</option>
                        </select>
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <span>Region</span>
                        <select
                            class="mt-2 w-full px-4 py-2 bg-black border border-gray-800 rounded-lg text-white text-sm"
                            bind:value={newDatabase.region}
                        >
                            <option>US East (N. Virginia)</option>
                            <option>US West (Oregon)</option>
                            <option>Europe (Frankfurt)</option>
                            <option>Asia Pacific (Singapore)</option>
                            <option>Asia Pacific (Tokyo)</option>
                        </select>
                    </label>
                </div>

                <div class="space-y-3">
                    <div class="border border-gray-800 rounded-lg p-4 space-y-4">
                        <div>
                            <label class="block text-xs text-gray-400 mb-1">
                                <span>Connection Limit</span>
                                <input
                                    type="number"
                                    class="mt-2 w-full px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                    bind:value={newDatabase.connectionLimit}
                                />
                            </label>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 mb-1">
                                <span>Storage Size (GB)</span>
                                <input
                                    type="number"
                                    class="mt-2 w-full px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                    bind:value={newDatabase.storageSize}
                                />
                            </label>
                        </div>
                        <label class="flex items-center gap-2 text-xs text-gray-400">
                            <input
                                type="checkbox"
                                class="w-4 h-4 bg-black border border-gray-800 rounded"
                                bind:checked={newDatabase.autoBackup}
                            />
                            Enable automatic backups
                        </label>
                    </div>
                </div>

                <div class="space-y-2">
                    {#each newDatabase.envVars as envVar, index (index)}
                        <div class="flex gap-2">
                            <input
                                type="text"
                                placeholder="KEY"
                                class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                bind:value={envVar.key}
                            />
                            <input
                                type="text"
                                placeholder="value"
                                class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                bind:value={envVar.value}
                            />
                            <button
                                type="button"
                                class="px-3 py-2 text-gray-400 hover:text-red-400 transition-colors"
                                on:click={() => newDatabase.envVars.splice(index, 1)}
                                aria-label="Remove environment variable"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    {/each}
                    <button
                        type="button"
                        class="text-sm text-blue-400 hover:text-blue-300"
                        on:click={() => newDatabase.envVars.push({ key: '', value: '' })}
                    >
                        <i class="fas fa-plus mr-1"></i> Add Variable
                    </button>
                </div>

                <div class="flex gap-3">
                    <button
                        type="button"
                        class="flex-1 px-4 py-3 bg-black border border-gray-800 text-white rounded-lg font-medium hover:bg-gray-900 transition-colors text-sm"
                        on:click={() => (showNewDatabaseModal = false)}
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="flex-1 px-4 py-3 bg-white text-black rounded-lg font-medium hover:bg-gray-200 transition-colors text-sm"
                    >
                        Create Database
                    </button>
                </div>
            </form>
        </div>
    </div>
{/if}

{#if showDeployModal}
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-black border border-gray-800 rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="border-b border-gray-800 p-8">
                <h1 class="text-2xl font-bold text-white mb-2">New Project</h1>
                <div class="flex items-center gap-2 text-sm text-gray-400 mt-4">
                    <i class="fab fa-github"></i>
                    <span>{selectedRepo ? selectedRepo.fullName : 'Custom Import'}</span>
                </div>
            </div>
            <form class="p-8 space-y-6" on:submit={handleDeploySubmit}>
                <p class="text-sm text-gray-400 mb-6">
                    Choose where you want to create the project and give it a name.
                </p>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <span>Project Name</span>
                        <input
                            type="text"
                            class="mt-2 w-full px-4 py-2 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm"
                            bind:value={newProject.name}
                            required
                        />
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <span>Framework Preset</span>
                        <select
                            class="mt-2 w-full px-4 py-2 bg-black border border-gray-800 rounded-lg text-white text-sm"
                            bind:value={newProject.framework}
                        >
                            <option>Next.js</option>
                            <option>Vite</option>
                            <option>Laravel</option>
                            <option>Express.js</option>
                            <option>Other</option>
                        </select>
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <span>Root Directory</span>
                        <div class="mt-2 flex gap-2">
                            <input
                                type="text"
                                class="flex-1 px-4 py-2 bg-black border border-gray-800 rounded-lg focus:outline-none focus:border-gray-700 text-white text-sm"
                                bind:value={newProject.rootDir}
                                readonly={!editingRootDir}
                            />
                            <button
                                type="button"
                                class="px-4 py-2 border border-gray-800 rounded-lg text-sm text-gray-400 hover:text-white hover:border-gray-700 transition-colors"
                                aria-label="Edit root directory"
                                on:click={() => (editingRootDir = !editingRootDir)}
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </label>
                </div>

                <div class="space-y-3">
                    <div class="border border-gray-800 rounded-lg p-4 space-y-4">
                        <div>
                            <label class="block text-xs text-gray-400 mb-1">
                                <span>Build Command</span>
                                <input
                                    type="text"
                                    placeholder="npm run build"
                                    class="mt-2 w-full px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                    bind:value={newProject.buildCommand}
                                />
                            </label>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 mb-1">
                                <span>Output Directory</span>
                                <input
                                    type="text"
                                    placeholder="dist"
                                    class="mt-2 w-full px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                    bind:value={newProject.outputDir}
                                />
                            </label>
                        </div>
                    </div>

                    <div class="border border-gray-800 rounded-lg p-4">
                        <div class="space-y-2">
                            {#each newProject.envVars as envVar, index (index)}
                                <div class="flex gap-2">
                                    <input
                                        type="text"
                                        placeholder="KEY"
                                        class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                        bind:value={envVar.key}
                                    />
                                    <input
                                        type="text"
                                        placeholder="value"
                                        class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                        bind:value={envVar.value}
                                    />
                                    <button
                                        type="button"
                                        class="px-3 py-2 text-red-400 hover:text-red-300"
                                        aria-label="Remove environment variable"
                                        on:click={() => newProject.envVars.splice(index, 1)}
                                    >
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            {/each}
                            <button
                                type="button"
                                class="text-sm text-blue-400 hover:text-blue-300"
                                on:click={() => newProject.envVars.push({ key: '', value: '' })}
                            >
                                <i class="fas fa-plus mr-1"></i> Add Variable
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button
                        type="button"
                        class="flex-1 px-4 py-3 bg-black border border-gray-800 text-white rounded-lg font-medium hover:bg-gray-900 transition-colors text-sm"
                        on:click={() => (showDeployModal = false)}
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="flex-1 px-4 py-3 bg-white text-black rounded-lg font-medium hover:bg-gray-200 transition-colors text-sm"
                    >
                        Deploy
                    </button>
                </div>
            </form>
        </div>
    </div>
{/if}

