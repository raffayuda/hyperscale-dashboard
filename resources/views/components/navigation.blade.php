<!-- Top Navigation Bar -->
    <div class="border-b border-gray-800 bg-black">
        <div class="px-6">
            <nav class="flex items-center justify-between h-14">
                <!-- Left Navigation -->
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-white rounded flex items-center justify-center">
                            <i class="fas fa-triangle text-black text-xs"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard') }}" 
                       class=" px-1 text-sm font-medium transition-colors -mb-px {{ Request::routeIs('dashboard') ? 'text-white border-b-2 border-white' : 'text-gray-400 hover:text-gray-300' }}">
                        Projects
                    </a>
                    <a href="{{ route('deployments') }}" 
                       class=" px-1 text-sm font-medium transition-colors -mb-px {{ Request::routeIs('deployments') ? 'text-white border-b-2 border-white' : 'text-gray-400 hover:text-gray-300' }}">
                        Deployments
                    </a>
                    <button @click="activeTab = 'domains'" 
                            :class="activeTab === 'domains' ? 'text-white border-b-2 border-white' : 'text-gray-400 hover:text-gray-300'"
                            class="h-14 px-1 text-sm font-medium transition-colors -mb-px">
                        Domains
                    </button>
                    <a href="{{ route('storage.index') }}" 
                       class=" px-1 text-sm font-medium transition-colors -mb-px {{ Request::routeIs('storage.index') ? 'text-white border-b-2 border-white' : 'text-gray-400 hover:text-gray-300' }}">
                        Storage
                    </a>
                </div>

                <!-- Right Navigation - User Menu -->
                <div class="flex items-center gap-4" x-data="{ userMenuOpen: false }">
                    <!-- Notifications -->
                    <button class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-bell text-sm"></i>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" 
                                class="flex items-center gap-2 text-sm text-gray-300 hover:text-white transition-colors">
                            <div class="w-7 h-7 bg-gray-800 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-xs"></i>
                            </div>
                            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="userMenuOpen" 
                             @click.away="userMenuOpen = false"
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-gray-900 border border-gray-800 rounded-lg shadow-2xl py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-800">
                                <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                <i class="fas fa-user w-4"></i> Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                <i class="fas fa-cog w-4"></i> Settings
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                                <i class="fas fa-credit-card w-4"></i> Billing
                            </a>
                            <div class="border-t border-gray-800 my-1"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-800 hover:text-red-300 transition-colors">
                                    <i class="fas fa-sign-out-alt w-4"></i> Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>