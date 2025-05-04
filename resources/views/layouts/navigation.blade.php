<style>
    /* Navigation styles */
    .nav-container {
        display: flex;
        align-items: center;
        height: 100%;
    }

    /* Make navigation bar more prominent */
    nav.header-gradient {
        border-bottom: 1px solid #e0f2fe;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* Ensure text is visible */
    .nav-text {
        color: #1e40af;
        font-weight: 600;
    }

    /* Additional spacing for navigation links */
    .nav-container > div {
        margin: 0 1rem;
    }

    /* Dropdown styling */
    .admin-dropdown-trigger {
        background-color: rgba(239, 246, 255, 0.8);
        border: 1px solid #bfdbfe;
        color: #1e40af;
        transition: all 0.2s ease;
    }

    .admin-dropdown-trigger:hover {
        background-color: #dbeafe;
        color: #1d4ed8;
    }

    /* Active nav link */
    .active-nav-link {
        border-bottom: 2px solid #3b82f6;
        color: #1e40af;
    }
</style>
<nav x-data="{ open: false }" class="header-gradient border-b border-blue-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="space-x-4 sm:ms-10 flex nav-container">
                    <!-- Admin Panel Dropdown - Always visible for testing -->
                    @if(true)
                        <x-dropdown align="right" width="56" class="flex items-center h-full">
                            <x-slot name="trigger">
                                <button class="admin-dropdown-trigger inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="nav-text">{{ __('Admin Panel') }}</span>
                                    </div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-3 border-b border-blue-200 bg-blue-50">
                                    <h3 class="text-sm font-bold text-blue-800">{{ __('Admin Panel') }}</h3>
                                </div>
                                <x-dropdown-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    {{ __('User Management') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    {{ __('Product Management') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.phones.index')" :active="request()->routeIs('admin.phones.*')" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ __('Phone Management') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    {{ __('Order Management') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.inventory.index')" :active="request()->routeIs('admin.inventory.*')" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    {{ __('Inventory') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.*')" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    {{ __('Transactions') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endif
                    <div>
                        <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')">
                            <span class="flex items-center">
                                <i class="fas fa-mobile-alt mr-2"></i>
                                <span class="nav-text">{{ __('Shop Phones') }}</span>
                            </span>
                        </x-nav-link>
                    </div>
                    <div>
                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                            <span class="flex items-center">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                <span class="nav-text">{{ __('Cart') }}</span>
                            </span>
                        </x-nav-link>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="flex items-center ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="admin-dropdown-trigger inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::check() ? Auth::user()->name : 'Guest' }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(Auth::check())
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('login')">
                                {{ __('Log In') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('register')">
                                {{ __('Register') }}
                            </x-dropdown-link>
                        @endif
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Admin Controls - Always visible for testing -->
            @if(true)
                <div class="px-4 py-3 bg-gray-100 rounded-md mb-2">
                    <h3 class="text-sm font-bold text-black">{{ __('Admin Panel') }}</h3>
                </div>
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    {{ __('User Management') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')" class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    {{ __('Product Management') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.phones.index')" :active="request()->routeIs('admin.phones.*')" class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('Phone Management') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    {{ __('Order Management') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.inventory.index')" :active="request()->routeIs('admin.inventory.*')" class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    {{ __('Inventory') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.*')" class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    {{ __('Transactions') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')">
                <span class="flex items-center">
                    <i class="fas fa-mobile-alt mr-2"></i>
                    <span class="nav-text">{{ __('Shop Phones') }}</span>
                </span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                <span class="flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span class="nav-text">{{ __('Cart') }}</span>
                </span>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                @if(Auth::check())
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                @else
                    <div class="font-medium text-base text-gray-800">Guest</div>
                    <div class="font-medium text-sm text-gray-500">Not logged in</div>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                @if(Auth::check())
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @else
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log In') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>
    </div>
</nav>
