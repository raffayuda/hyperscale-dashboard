<script lang="ts">
    const envVars = [
        { key: 'NEXT_PUBLIC_SUPABASE_URL', value: 'https://hyperscale.supabase.co' },
        { key: 'STRIPE_WEBHOOK_SECRET', value: 'whsec_*********' },
        { key: 'EDGE_CACHE', value: 'true' }
    ];
</script>

<div class="px-6 py-8 space-y-8">
    <div>
        <p class="text-sm text-gray-400 mb-1">Workspace</p>
        <h1 class="text-3xl font-bold text-white">Settings</h1>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="space-y-6 xl:col-span-2">
            <section class="rounded-2xl border border-gray-800 bg-gray-900 p-6 space-y-6">
                <header>
                    <h2 class="text-white text-lg font-semibold">Workspace identity</h2>
                    <p class="text-sm text-gray-400">Control how your projects appear across Hyperscale.</p>
                </header>
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="block text-sm text-gray-300">
                        <span>Workspace name</span>
                        <input
                            type="text"
                            class="mt-2 w-full rounded-xl border border-gray-800 bg-black/70 px-4 py-2 text-sm text-white focus:border-gray-600 focus:outline-none"
                            value="Hyperscale Labs"
                        />
                    </label>
                    <label class="block text-sm text-gray-300">
                        <span>Subdomain</span>
                        <div class="mt-2 flex rounded-xl border border-gray-800 bg-black/70">
                            <span class="flex items-center px-3 text-xs text-gray-500">hyperscale.app/</span>
                            <input
                                type="text"
                                class="flex-1 border-0 bg-transparent px-3 py-2 text-sm text-white focus:outline-none"
                                value="team"
                            />
                        </div>
                    </label>
                </div>
                <label class="block text-sm text-gray-300">
                    <span>Description</span>
                    <textarea
                        rows="3"
                        class="mt-2 w-full rounded-xl border border-gray-800 bg-black/70 px-4 py-3 text-sm text-white focus:border-gray-600 focus:outline-none"
                    >
Ship infra tooling and developer automation.</textarea
                    >
                </label>
                <div class="flex justify-end gap-3">
                    <button class="rounded-xl border border-gray-800 px-4 py-2 text-sm text-gray-300">Discard</button>
                    <button class="rounded-xl bg-white px-4 py-2 text-sm font-medium text-black">Update Workspace</button>
                </div>
            </section>

            <section class="rounded-2xl border border-gray-800 bg-gray-900 p-6 space-y-6">
                <header>
                    <h2 class="text-white text-lg font-semibold">Environment variables</h2>
                    <p class="text-sm text-gray-400">Global variables inherited by every deployment.</p>
                </header>
                <div class="space-y-3">
                    {#each envVars as env}
                        <div class="rounded-xl border border-gray-800 bg-black/50 p-4">
                            <p class="text-xs uppercase tracking-wide text-gray-500">{env.key}</p>
                            <p class="mt-1 font-mono text-sm text-white">{env.value}</p>
                        </div>
                    {/each}
                </div>
                <button class="rounded-xl border border-dashed border-gray-700 px-4 py-2 text-sm text-gray-300 hover:border-gray-500">
                    Add variable
                </button>
            </section>
        </div>

        <aside class="space-y-6">
            <section class="rounded-2xl border border-gray-800 bg-gray-900 p-6 space-y-4">
                <h3 class="text-white text-base font-semibold">Integrations</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between rounded-xl border border-gray-800 bg-black/40 px-4 py-3">
                        <div>
                            <p class="text-sm font-medium text-white">GitHub</p>
                            <p class="text-xs text-gray-500">Connected as raffayuda</p>
                        </div>
                        <button class="text-sm text-blue-400">Disconnect</button>
                    </div>
                    <div class="flex items-center justify-between rounded-xl border border-gray-800 bg-black/40 px-4 py-3">
                        <div>
                            <p class="text-sm font-medium text-white">Slack</p>
                            <p class="text-xs text-gray-500">#deployments</p>
                        </div>
                        <button class="text-sm text-blue-400">View</button>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-gray-800 bg-gray-900 p-6 space-y-4">
                <h3 class="text-white text-base font-semibold">Danger zone</h3>
                <p class="text-sm text-gray-400">Transfer ownership or delete the workspace.</p>
                <button class="w-full rounded-xl border border-red-500/30 px-4 py-2 text-sm text-red-400 hover:border-red-400">
                    Delete workspace
                </button>
            </section>
        </aside>
    </div>
</div>

