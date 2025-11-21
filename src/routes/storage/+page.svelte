<script lang="ts">
    import { databases as seedDatabases } from '$lib/data/sample-data';
    import type { Database, NewDatabaseForm } from '$lib/types';

    const cloneDatabases = () => seedDatabases.map((database) => ({ ...database }));

    let databases: Database[] = cloneDatabases();
    let showNewDatabaseModal = false;
    let selectedDb: Database | null = null;
    let showPassword = false;

    const defaultDatabaseForm = (): NewDatabaseForm => ({
        name: '',
        type: 'PostgreSQL',
        region: 'US East (N. Virginia)',
        connectionLimit: 100,
        storageSize: 10,
        autoBackup: true,
        envVars: []
    });

    let newDatabase = defaultDatabaseForm();

    $: activeDatabases = databases.filter((database) => database.status === 'active').length;
    $: totalStorage = databases.reduce((sum, database) => sum + database.storageSize, 0);
    $: backupsEnabled = databases.filter((database) => database.autoBackup).length;

    function showConnectionString(database: Database) {
        selectedDb = selectedDb?.id === database.id ? null : database;
    }

    async function copyToClipboard(value: string) {
        await navigator.clipboard.writeText(value);
        window.alert('Copied to clipboard!');
    }

    function deleteDatabase(id: string) {
        if (!window.confirm('Delete this database? This action cannot be undone.')) {
            return;
        }
        databases = databases.filter((database) => database.id !== id);
    }

    function handleDatabaseSubmit(event: SubmitEvent) {
        event.preventDefault();
        databases = [
            ...databases,
            {
                id: crypto.randomUUID(),
                name: newDatabase.name,
                type: newDatabase.type,
                region: newDatabase.region,
                status: 'provisioning',
                storageSize: newDatabase.storageSize,
                autoBackup: newDatabase.autoBackup,
                host: `${newDatabase.name}.hyperscale.dev`,
                port: newDatabase.type === 'PostgreSQL' ? 5432 : 3306,
                username: `${newDatabase.name.replace(/-/g, '_')}_admin`,
                password: 'generated-secret',
                connectionString: `${newDatabase.type.toLowerCase()}://${newDatabase.name}`
            }
        ];
        newDatabase = defaultDatabaseForm();
        showNewDatabaseModal = false;
        selectedDb = null;
    }
</script>

<div class="flex w-full bg-black">
    <div class="p-6 w-full">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Storage & Databases</h2>
                <p class="text-gray-400 text-sm">Manage your databases and storage solutions</p>
            </div>
            <button
                class="bg-white text-black px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors"
                on:click={() => (showNewDatabaseModal = true)}
            >
                <i class="fas fa-plus mr-2"></i>Create Database
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-400 text-sm">Total Databases</span>
                    <i class="fas fa-database text-blue-500"></i>
                </div>
                <div class="text-2xl font-bold text-white">{databases.length}</div>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-400 text-sm">Active</span>
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="text-2xl font-bold text-white">{activeDatabases}</div>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-400 text-sm">Total Storage</span>
                    <i class="fas fa-hdd text-purple-500"></i>
                </div>
                <div class="text-2xl font-bold text-white">{totalStorage} GB</div>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-400 text-sm">Backups Enabled</span>
                    <i class="fas fa-cloud-upload-alt text-yellow-500"></i>
                </div>
                <div class="text-2xl font-bold text-white">{backupsEnabled}</div>
            </div>
        </div>

        {#if !databases.length}
            <div class="flex flex-col items-center justify-center py-20">
                <div class="w-16 h-16 bg-gray-900 border border-gray-800 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-database text-gray-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-white mb-2">No databases yet</h3>
                <p class="text-gray-400 text-sm mb-6">Create your first database to get started</p>
                <button
                    class="bg-white text-black px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors"
                    on:click={() => (showNewDatabaseModal = true)}
                >
                    <i class="fas fa-plus mr-2"></i>Create Database
                </button>
            </div>
        {:else}
            <div class="space-y-3">
                {#each databases as database (database.id)}
                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-all">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 flex-1">
                                <div class="w-12 h-12 bg-black border border-gray-800 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-database text-blue-400 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-1">
                                        <h3 class="text-white font-medium">{database.name}</h3>
                                        <span
                                            class={`px-2 py-1 text-xs rounded-full ${
                                                database.status === 'active'
                                                    ? 'bg-green-500/10 text-green-400'
                                                    : 'bg-yellow-500/10 text-yellow-400'
                                            }`}
                                        >
                                            {database.status}
                                        </span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                                        <span class="flex items-center gap-2">
                                            <i class="fas fa-server text-xs"></i>
                                            {database.type}
                                        </span>
                                        <span class="flex items-center gap-2">
                                            <i class="fas fa-globe text-xs"></i>
                                            {database.region}
                                        </span>
                                        <span class="flex items-center gap-2">
                                            <i class="fas fa-hdd text-xs"></i>
                                            {database.storageSize} GB
                                        </span>
                                        {#if database.autoBackup}
                                            <span class="flex items-center gap-2 text-green-400">
                                                <i class="fas fa-cloud-upload-alt text-xs"></i>
                                                Auto Backup
                                            </span>
                                        {/if}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <button
                                    class="px-3 py-2 bg-black border border-gray-800 rounded-lg text-sm text-gray-300 hover:text-white hover:border-gray-700 transition-colors"
                                    on:click={() => showConnectionString(database)}
                                >
                                    <i class="fas fa-link mr-2"></i>Connection
                                </button>
                                <button
                                    class="px-3 py-2 bg-black border border-gray-800 rounded-lg text-gray-400 hover:text-white hover:border-gray-700 transition-colors"
                                    on:click={() => deleteDatabase(database.id)}
                                    aria-label="Delete database"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        {#if selectedDb?.id === database.id}
                            <div class="mt-4 pt-4 border-t border-gray-800 space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                    <label class="block text-xs text-gray-400 mb-1">
                                        <span>Host</span>
                                        <div class="mt-2 flex items-center gap-2">
                                            <input
                                                type="text"
                                                class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                                readonly
                                                value={database.host}
                                            />
                                            <button
                                                class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white"
                                                on:click={() => copyToClipboard(database.host)}
                                                aria-label="Copy host"
                                            >
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </label>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">
                                            <span>Port</span>
                                            <input
                                                type="text"
                                                class="mt-2 w-full px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                                readonly
                                                value={database.port}
                                            />
                                        </label>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">
                                            <span>Username</span>
                                            <div class="mt-2 flex items-center gap-2">
                                                <input
                                                    type="text"
                                                    class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                                    readonly
                                                    value={database.username}
                                                />
                                                <button
                                                    class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white"
                                                    on:click={() => copyToClipboard(database.username)}
                                                    aria-label="Copy username"
                                                >
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">
                                            <span>Password</span>
                                            <div class="mt-2 flex items-center gap-2">
                                                <input
                                                    class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"
                                                    type={showPassword ? 'text' : 'password'}
                                                    readonly
                                                    value={database.password}
                                                />
                                                <button
                                                    class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white"
                                                    on:click={() => (showPassword = !showPassword)}
                                                    aria-label={showPassword ? 'Hide password' : 'Show password'}
                                                >
                                                    <i class={showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'}></i>
                                                </button>
                                                <button
                                                    class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white"
                                                    on:click={() => copyToClipboard(database.password)}
                                                    aria-label="Copy password"
                                                >
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">
                                        <span>Connection String</span>
                                        <div class="mt-2 flex items-center gap-2">
                                            <input
                                                type="text"
                                                class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm font-mono"
                                                readonly
                                                value={database.connectionString}
                                            />
                                            <button
                                                class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white"
                                                on:click={() => copyToClipboard(database.connectionString)}
                                                aria-label="Copy connection string"
                                            >
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        {/if}
                    </div>
                {/each}
            </div>
        {/if}
    </div>
</div>

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

