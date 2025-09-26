<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 py-2.5 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('welcomePage') }}">
                    @if (isset($settings->logo) && $settings->logo != '')
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="Site Logo"
                            class="h-11 w-auto object-contain" />
                    @else
                        <h2 class="text-2xl font-extrabold ">{{ $settings->title ?? 'Purobi' }}</h2>
                    @endif
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                <!-- Dashboard -->
                @can('view dashboard')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                @endcan


                <!-- Reports -->
                @canany(['view customer report', 'view service report', 'view order report', 'view expense report',
                    'view invoice report', 'view profit loss report'])
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                                {{ __('Reports') }}
                                <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20" stroke="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @can('view customer report')
                                <x-dropdown-link :href="route('reports.customer')">{{ __('Customer Report') }}</x-dropdown-link>
                            @endcan
                            @can('view service report')
                                <x-dropdown-link :href="route('reports.service')">{{ __('Service Report') }}</x-dropdown-link>
                            @endcan
                            @can('view order report')
                                <x-dropdown-link :href="route('reports.order')">{{ __('Order Report') }}</x-dropdown-link>
                            @endcan
                            @can('view invoice report')
                                <x-dropdown-link :href="route('reports.invoice')">{{ __('Invoice Report') }}</x-dropdown-link>
                            @endcan
                            @can('view expense report')
                                <x-dropdown-link :href="route('reports.expense')">{{ __('Expense Report') }}</x-dropdown-link>
                            @endcan
                            @can('view profit loss report')
                                <x-dropdown-link :href="route('reports.profit-loss')">{{ __('Profit & Loss') }}</x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>
                @endcanany

                <!-- Users -->
                @canany(['view permissions', 'view roles', 'view users'])
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                                {{ __('Users') }}
                                <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20" stroke="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @can('view users')
                                <x-dropdown-link :href="route('users.index')">{{ __('Users') }}</x-dropdown-link>
                            @endcan
                            @can('view roles')
                                <x-dropdown-link :href="route('roles.index')">{{ __('Roles') }}</x-dropdown-link>
                            @endcan
                            @can('view permissions')
                                <x-dropdown-link :href="route('permissions.index')">{{ __('Permissions') }}</x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>
                @endcanany

                <!-- Customers -->
                @can('view customers')
                    <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                        {{ __('Customers') }}
                    </x-nav-link>
                @endcan

                <!-- Services -->
                @canany(['view services', 'view service category'])
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                                {{ __('Services') }}
                                <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20" stroke="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @can('view services')
                                <x-dropdown-link :href="route('services.index')">{{ __('All Services') }}</x-dropdown-link>
                            @endcan
                            @can('view service category')
                                <x-dropdown-link :href="route('service_category.index')">{{ __('Service Categories') }}</x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>
                @endcanany

                <!-- Expenses -->
                @canany(['view expense categories', 'view expenses'])
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                                {{ __('Expenses') }}
                                <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20" stroke="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @can('view expenses')
                                <x-dropdown-link :href="route('expenses.index')">{{ __('All Expenses') }}</x-dropdown-link>
                            @endcan
                            @can('view expense categories')
                                <x-dropdown-link :href="route('expense_categories.index')">{{ __('Expense Categories') }}</x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>
                @endcanany

                <!-- Orders & Invoices -->
                @canany(['view orders', 'view invoices'])
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                                {{ __('Orders & Invoices') }}
                                <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20" stroke="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @can('view orders')
                                <x-dropdown-link :href="route('orders.index')">{{ __('Orders') }}</x-dropdown-link>
                            @endcan
                            @can('view invoices')
                                <x-dropdown-link :href="route('invoices.index')">{{ __('Invoices') }}</x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>
                @endcanany
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                            {{ Auth::user()->name }} ({{ Auth::user()->roles->pluck('name')->implode(', ') }})
                            <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20" stroke="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        @can('view settings')
                            <x-dropdown-link :href="route('settings.index')">{{ __('Settings') }}</x-dropdown-link>
                        @endcan
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Dashboard -->
            @can('view dashboard')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endcan


            <!-- Reports -->
            @can('view customer report')
                <x-responsive-nav-link :href="route('reports.customer')">{{ __('Customer Report') }}</x-responsive-nav-link>
            @endcan
            @can('view service report')
                <x-responsive-nav-link :href="route('reports.service')">{{ __('Service Report') }}</x-responsive-nav-link>
            @endcan
            @can('view order report')
                <x-responsive-nav-link :href="route('reports.order')">{{ __('Order Report') }}</x-responsive-nav-link>
            @endcan
            @can('view invoice report')
                <x-responsive-nav-link :href="route('reports.invoice')">{{ __('Invoice Report') }}</x-responsive-nav-link>
            @endcan
            @can('view expense report')
                <x-responsive-nav-link :href="route('reports.expense')">{{ __('Expense Report') }}</x-responsive-nav-link>
            @endcan
            @can('view profit loss report')
                <x-responsive-nav-link :href="route('reports.profit-loss')">{{ __('Profit & Loss') }}</x-responsive-nav-link>
            @endcan

            <!-- Users -->
            @can('view users')
                <x-responsive-nav-link :href="route('users.index')">{{ __('Users') }}</x-responsive-nav-link>
            @endcan
            @can('view roles')
                <x-responsive-nav-link :href="route('roles.index')">{{ __('Roles') }}</x-responsive-nav-link>
            @endcan
            @can('view permissions')
                <x-responsive-nav-link :href="route('permissions.index')">{{ __('Permissions') }}</x-responsive-nav-link>
            @endcan

            <!-- Customers -->
            @can('view customers')
                <x-responsive-nav-link :href="route('customers.index')">{{ __('Customers') }}</x-responsive-nav-link>
            @endcan

            <!-- Services -->
            @can('view services')
                <x-responsive-nav-link :href="route('services.index')">{{ __('All Services') }}</x-responsive-nav-link>
            @endcan
            @can('view service category')
                <x-responsive-nav-link :href="route('service_category.index')">{{ __('Service Categories') }}</x-responsive-nav-link>
            @endcan

            <!-- Expenses -->
            @can('view expenses')
                <x-responsive-nav-link :href="route('expenses.index')">{{ __('Expenses') }}</x-responsive-nav-link>
            @endcan
            @can('view expense categories')
                <x-responsive-nav-link :href="route('expense_categories.index')">{{ __('Expense Categories') }}</x-responsive-nav-link>
            @endcan

            <!-- Orders & Invoices -->
            @can('view orders')
                <x-responsive-nav-link :href="route('orders.index')">{{ __('Orders') }}</x-responsive-nav-link>
            @endcan
            @can('view invoices')
                <x-responsive-nav-link :href="route('invoices.index')">{{ __('Invoices') }}</x-responsive-nav-link>
            @endcan
        </div>

        <!-- Mobile User Info -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                @can('view settings')
                    <x-responsive-nav-link :href="route('settings.index')">{{ __('Settings') }}</x-responsive-nav-link>
                @endcan
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
