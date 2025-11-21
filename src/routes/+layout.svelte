<script lang="ts">
    import { page } from '$app/stores';
    import '../app.postcss';
    import { clickOutside } from '$lib/actions/clickOutside';

    const navLinks = [
        { href: '/', label: 'Projects', match: /^\/$/ },
        { href: '/deployments', label: 'Deployments', match: /^\/deployments/ },
        { href: '/domains', label: 'Domains', match: /^\/domains/ },
        { href: '/storage', label: 'Storage', match: /^\/storage/ }
    ];

    let userMenuOpen = false;
</script>

<svelte:head>
    <title>Hyperscale Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    />
</svelte:head>

<div class="min-h-screen bg-black text-white">
    <div class="border-b border-gray-800 bg-black">
        <div class="px-6">
            <nav class="flex items-center justify-between h-14">
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-white rounded flex items-center justify-center">
                            <i class="fas fa-triangle text-black text-xs"></i>
                        </div>
                    </div>

                    {#each navLinks as link (link.href)}
                        {#if link.label === 'Domains'}
                            <span class="h-14 px-1 text-sm font-medium text-gray-600 flex items-center">Domains</span>
                        {:else}
                            <a
                                href={link.href}
                                class={`px-1 text-sm font-medium transition-colors -mb-px ${
                                    link.match.test($page.url.pathname)
                                        ? 'text-white border-b-2 border-white'
                                        : 'text-gray-400 hover:text-gray-300'
                                }`}
                            >
                                {link.label}
                            </a>
                        {/if}
                    {/each}
                </div>

                <div class="flex items-center gap-4" use:clickOutside={() => (userMenuOpen = false)}>
                    <button class="text-gray-400 hover:text-white transition-colors" aria-label="Notifications">
                        <i class="fas fa-bell text-sm"></i>
                    </button>

                    <div class="relative">
                        <button
                            class="flex items-center gap-2 text-sm text-gray-300 hover:text-white transition-colors"
                            on:click={() => (userMenuOpen = !userMenuOpen)}
                        >
                            <div class="w-7 h-7 bg-gray-800 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-xs"></i>
                            </div>
                            <span class="hidden md:inline">raffayuda</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        {#if userMenuOpen}
                            <div
                                class="absolute right-0 mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-50"
                            >
                                <div class="px-4 py-2 border-b border-gray-800">
                                    <p class="text-sm font-medium text-white">raffayuda</p>
                                    <p class="text-xs text-gray-400 truncate">team@hyperscale.dev</p>
                                </div>
                                <a
                                    href="/profile"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors"
                                    >Profile</a
                                >
                                <a
                                    href="/settings"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors"
                                    >Settings</a
                                >
                                <a
                                    href="/billing"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors"
                                    >Billing</a
                                >
                                <div class="border-t border-gray-800 my-1"></div>
                                <button
                                    class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-800 hover:text-red-300 transition-colors"
                                >
                                    Sign out
                                </button>
                            </div>
                        {/if}
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <slot />
</div>

