<script lang="ts">
    const invoices = [
        { id: 'inv_8203', period: 'Oct 2025', amount: '$128.00', status: 'Paid', url: '#' },
        { id: 'inv_8162', period: 'Sep 2025', amount: '$115.00', status: 'Paid', url: '#' },
        { id: 'inv_8110', period: 'Aug 2025', amount: '$122.00', status: 'Paid', url: '#' }
    ];

    const usage = [
        { label: 'Edge requests', value: '2.4M', limit: '10M', percent: 24 },
        { label: 'Serverless invocations', value: '880K', limit: '2M', percent: 44 },
        { label: 'Databases', value: '3 / 10', limit: 'Plan limit', percent: 30 }
    ];
</script>

<div class="px-6 py-8 space-y-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm text-gray-400 mb-1">Workspace</p>
            <h1 class="text-3xl font-bold text-white">Billing</h1>
        </div>
        <button class="rounded-xl bg-white px-4 py-2 text-sm font-medium text-black">Upgrade plan</button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="lg:col-span-2 space-y-6">
            <div class="rounded-2xl border border-gray-800 bg-gray-900 p-6 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">Current plan</p>
                        <p class="text-white text-xl font-semibold">Scale · $99 / month</p>
                    </div>
                    <span class="rounded-full border border-emerald-500/40 px-3 py-1 text-xs text-emerald-400">Active</span>
                </div>
                <ul class="grid gap-3 text-sm text-gray-300 md:grid-cols-2">
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-emerald-400 text-xs"></i> 30 environments
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-emerald-400 text-xs"></i> 1 TB storage
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-emerald-400 text-xs"></i> Enterprise firewall
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-emerald-400 text-xs"></i> Priority support
                    </li>
                </ul>
            </div>

            <div class="rounded-2xl border border-gray-800 bg-gray-900 p-6 space-y-6">
                <header class="flex items-center justify-between">
                    <div>
                        <h2 class="text-white text-lg font-semibold">Invoices</h2>
                        <p class="text-sm text-gray-400">Download and view payment history.</p>
                    </div>
                    <button class="text-sm text-blue-400">Export CSV</button>
                </header>
                <div class="space-y-3">
                    {#each invoices as invoice}
                        <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-gray-800 bg-black/40 px-4 py-3">
                            <div>
                                <p class="text-sm font-medium text-white">{invoice.period}</p>
                                <p class="text-xs text-gray-500">{invoice.id}</p>
                            </div>
                            <div class="text-sm text-gray-300">{invoice.amount}</div>
                            <div>
                                <span class="rounded-full border border-emerald-500/30 px-3 py-1 text-xs text-emerald-400">
                                    {invoice.status}
                                </span>
                            </div>
                            <button class="text-sm text-blue-400">Download</button>
                        </div>
                    {/each}
                </div>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-2xl border border-gray-800 bg-gray-900 p-6 space-y-6">
                <header>
                    <h2 class="text-white text-lg font-semibold">Usage breakdown</h2>
                    <p class="text-sm text-gray-400">Resets on 1 Nov 2025.</p>
                </header>
                <div class="space-y-4">
                    {#each usage as item}
                        <div>
                            <div class="flex items-center justify-between text-sm text-gray-300">
                                <span>{item.label}</span>
                                <span>{item.value}</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-gray-800">
                                <div class="h-full rounded-full bg-white" style={`width:${item.percent}%`}></div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">{item.limit}</p>
                        </div>
                    {/each}
                </div>
            </div>

            <div class="rounded-2xl border border-gray-800 bg-gray-900 p-6 space-y-4">
                <h3 class="text-white text-base font-semibold">Payment method</h3>
                <div class="flex items-center justify-between rounded-xl border border-gray-800 bg-black/40 px-4 py-3">
                    <div>
                        <p class="text-sm font-medium text-white">Visa ending 4242</p>
                        <p class="text-xs text-gray-500">Exp 08 / 28</p>
                    </div>
                    <button class="text-sm text-blue-400">Update</button>
                </div>
                <button class="w-full rounded-xl border border-dashed border-gray-700 px-3 py-2 text-sm text-gray-300 hover:border-gray-500">
                    Add backup card
                </button>
            </div>
        </aside>
    </div>
</div>

