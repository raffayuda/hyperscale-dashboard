<script lang="ts">
    const teamMembers = [
        { id: 1, name: 'raffayuda', role: 'Founder', email: 'raffayuda@hyperscale.dev', status: 'Owner' },
        { id: 2, name: 'Adeline Park', role: 'Product Lead', email: 'adeline@hyperscale.dev', status: 'Admin' },
        { id: 3, name: 'Mia Wong', role: 'Infra', email: 'mia@hyperscale.dev', status: 'Member' }
    ];
</script>

<div class="px-6 py-8 space-y-8">
    <div>
        <p class="text-sm text-gray-400 mb-1">Account</p>
        <h1 class="text-3xl font-bold text-white">Profile</h1>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 space-y-6">
            <section class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-6">
                <header>
                    <h2 class="text-white text-lg font-semibold">Public info</h2>
                    <p class="text-sm text-gray-400">Edit the details that other teammates see.</p>
                </header>

                <div class="space-y-4">
                    <label class="block text-sm text-gray-300">
                        <span>Display name</span>
                        <input
                            type="text"
                            class="mt-2 w-full rounded-xl border border-gray-800 bg-black/80 px-4 py-2 text-sm text-white focus:border-gray-600 focus:outline-none"
                            value="raffayuda"
                        />
                    </label>
                    <label class="block text-sm text-gray-300">
                        <span>Role / Title</span>
                        <input
                            type="text"
                            class="mt-2 w-full rounded-xl border border-gray-800 bg-black/80 px-4 py-2 text-sm text-white focus:border-gray-600 focus:outline-none"
                            value="Founder & Platform Engineer"
                        />
                    </label>
                    <label class="block text-sm text-gray-300">
                        <span>Bio</span>
                        <textarea
                            class="mt-2 w-full rounded-xl border border-gray-800 bg-black/80 px-4 py-3 text-sm text-white focus:border-gray-600 focus:outline-none"
                            rows="4"
                        >
Scale infrastructure and ship delightful developer tooling.</textarea
                        >
                    </label>
                </div>

                <div class="flex justify-end gap-3">
                    <button class="rounded-xl border border-gray-800 px-4 py-2 text-sm text-gray-300 hover:border-gray-600">
                        Cancel
                    </button>
                    <button class="rounded-xl bg-white px-4 py-2 text-sm font-medium text-black hover:bg-gray-200">
                        Save changes
                    </button>
                </div>
            </section>

            <section class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-6">
                <header>
                    <h2 class="text-white text-lg font-semibold">Security</h2>
                    <p class="text-sm text-gray-400">Keep your account secure with MFA and active sessions.</p>
                </header>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-xl border border-gray-800 bg-black/50 p-4">
                        <p class="text-sm text-gray-400">Current session</p>
                        <p class="mt-2 text-white text-base">Chrome · Windows 11</p>
                        <p class="text-xs text-gray-500">Last active 5 minutes ago · Jakarta</p>
                        <button class="mt-4 text-sm text-blue-400 hover:text-blue-300">Sign out other devices</button>
                    </div>
                    <div class="rounded-xl border border-gray-800 bg-black/50 p-4">
                        <p class="text-sm text-gray-400">Multi-factor auth</p>
                        <p class="mt-2 text-white text-base">Authenticator app</p>
                        <p class="text-xs text-gray-500">Device ending in 9F2C</p>
                        <button class="mt-4 text-sm text-blue-400 hover:text-blue-300">Rotate recovery codes</button>
                    </div>
                </div>
            </section>
        </div>

        <aside class="space-y-6">
            <section class="bg-gray-900 border border-gray-800 rounded-2xl p-6 space-y-6">
                <header>
                    <h2 class="text-white text-lg font-semibold">Members</h2>
                    <p class="text-sm text-gray-400">Manage who has access to this workspace.</p>
                </header>
                <div class="space-y-4">
                    {#each teamMembers as member}
                        <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-800 bg-black/40 px-4 py-3">
                            <div>
                                <p class="text-sm font-medium text-white">{member.name}</p>
                                <p class="text-xs text-gray-500">{member.email}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-400">{member.role}</p>
                                <span
                                    class="inline-flex items-center rounded-full border border-gray-700 px-3 py-1 text-xs text-gray-300"
                                    >{member.status}</span
                                >
                            </div>
                        </div>
                    {/each}
                </div>
                <button class="w-full rounded-xl border border-dashed border-gray-700 px-3 py-2 text-sm text-gray-300 hover:border-gray-500">
                    Invite teammate
                </button>
            </section>
        </aside>
    </div>
</div>

