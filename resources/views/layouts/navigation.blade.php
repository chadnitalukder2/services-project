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

                <!-- Orders -->
                @can('view orders')
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                        {{ __('Orders') }}
                    </x-nav-link>
                @endcan

                <!-- Invoices -->
                @can('view invoices')
                    <x-nav-link :href="route('invoices.index')" :active="request()->routeIs('invoices.*')">
                        {{ __('Invoices') }}
                    </x-nav-link>
                @endcan

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
                        @can('view users')
                            <x-dropdown-link :href="route('users.index')">{{ __('Users') }}</x-dropdown-link>
                        @endcan

                        @can('view roles')
                            <x-dropdown-link :href="route('roles.index')">{{ __('Roles') }}</x-dropdown-link>
                        @endcan

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
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden space-y-1 px-2 pt-2 pb-3 border-t border-gray-200">

        <!-- Dashboard -->
        @can('view dashboard')
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="border-b border-gray-200 hover:bg-gray-100" style="border-bottom: 1px solid #e5e7eb;"> 
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        @endcan

        <!-- Reports Group -->
        @canany([
            'view customer report',
            'view service report',
            'view order report',
            'view invoice report',
            'view
            expense report',
            'view profit loss report',
            ])
            <div x-data="{ openReports: false }" class="space-y-1 border-b border-gray-200">
                <button @click="openReports = !openReports" :class="openReports ? 'bg-gray-100' : ''"
                    class="w-full flex items-center justify-between px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <span>{{ __('Reports') }}</span>
                    <svg :class="{ 'rotate-180': openReports }" class="h-4 w-4 transform transition-transform"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openReports" x-collapse class="space-y-1 pl-4">
                    @can('view customer report')
                        <x-responsive-nav-link :href="route('reports.customer')" :active="request()->routeIs('reports.customer')"
                            class="border-b border-gray-100 hover:bg-gray-50" style="border-bottom: 1px solid #e5e7eb;">{{ __('Customer Report') }}</x-responsive-nav-link>
                    @endcan
                    @can('view service report')
                        <x-responsive-nav-link :href="route('reports.service')" :active="request()->routeIs('reports.service')"
                            class="border-b border-gray-100 hover:bg-gray-50" style="border-bottom: 1px solid #e5e7eb;">{{ __('Service Report') }}</x-responsive-nav-link>
                    @endcan
                    @can('view order report')
                        <x-responsive-nav-link :href="route('reports.order')" :active="request()->routeIs('reports.order')"
                            class="border-b border-gray-100 hover:bg-gray-50" style="border-bottom: 1px solid #e5e7eb;">{{ __('Order Report') }}</x-responsive-nav-link>
                    @endcan
                    @can('view invoice report')
                        <x-responsive-nav-link :href="route('reports.invoice')" :active="request()->routeIs('reports.invoice')"
                            class="border-b border-gray-100 hover:bg-gray-50" style="border-bottom: 1px solid #e5e7eb;">{{ __('Invoice Report') }}</x-responsive-nav-link>
                    @endcan
                    @can('view expense report')
                        <x-responsive-nav-link :href="route('reports.expense')" :active="request()->routeIs('reports.expense')"
                            class="border-b border-gray-100 hover:bg-gray-50" style="border-bottom: 1px solid #e5e7eb;">{{ __('Expense Report') }}</x-responsive-nav-link>
                    @endcan
                    @can('view profit loss report')
                        <x-responsive-nav-link :href="route('reports.profit-loss')" :active="request()->routeIs('reports.profit-loss')"
                            class="border-b border-gray-100 hover:bg-gray-50" >{{ __('Profit & Loss') }}</x-responsive-nav-link>
                    @endcan
                </div>
            </div>
        @endcanany

        <!-- Users Group -->
        @canany(['view users', 'view roles'])
            <div x-data="{ openUsers: false }" class="space-y-1 border-b border-gray-200">
                <button @click="openUsers = !openUsers" :class="openUsers ? 'bg-gray-100' : ''"
                    class="w-full flex items-center justify-between px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <span>{{ __('Users') }}</span>
                    <svg :class="{ 'rotate-180': openUsers }" class="h-4 w-4 transform transition-transform"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openUsers" x-collapse class="space-y-1 pl-4">
                    @can('view users')
                        <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')"
                            class="border-b border-gray-100 hover:bg-gray-50" style="border-bottom: 1px solid #e5e7eb;">{{ __('Users') }}</x-responsive-nav-link>
                    @endcan
                    @can('view roles')
                        <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')"
                            class="border-b border-gray-100 hover:bg-gray-50">{{ __('Roles') }}</x-responsive-nav-link>
                    @endcan
                </div>
            </div>
        @endcanany

        <!-- Customers -->
        @can('view customers')
            <x-responsive-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')"
                class="border-b border-gray-200 hover:bg-gray-100" style="border-bottom: 1px solid #e5e7eb;">{{ __('Customers') }}</x-responsive-nav-link>
        @endcan

        <!-- Services Group -->
        @canany(['view services', 'view service category'])
            <div x-data="{ openServices: false }" class="space-y-1 border-b border-gray-200">
                <button @click="openServices = !openServices" :class="openServices ? 'bg-gray-100' : ''"
                    class="w-full flex items-center justify-between px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <span>{{ __('Services') }}</span>
                    <svg :class="{ 'rotate-180': openServices }" class="h-4 w-4 transform transition-transform"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openServices" x-collapse class="space-y-1 pl-4">
                    @can('view services')
                        <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')"
                            class="border-b border-gray-100 hover:bg-gray-50" style="border-bottom: 1px solid #e5e7eb;">{{ __('All Services') }}</x-responsive-nav-link>
                    @endcan
                    @can('view service category')
                        <x-responsive-nav-link :href="route('service_category.index')" :active="request()->routeIs('service_category.*')"
                            class="border-b border-gray-100 hover:bg-gray-50">{{ __('Service Categories') }}</x-responsive-nav-link>
                    @endcan
                </div>
            </div>
        @endcanany

        <!-- Expenses Group -->
        @canany(['view expenses', 'view expense categories'])
            <div x-data="{ openExpenses: false }" class="space-y-1 border-b border-gray-200">
                <button @click="openExpenses = !openExpenses" :class="openExpenses ? 'bg-gray-100' : ''"
                    class="w-full flex items-center justify-between px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <span>{{ __('Expenses') }}</span>
                    <svg :class="{ 'rotate-180': openExpenses }" class="h-4 w-4 transform transition-transform"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openExpenses" x-collapse class="space-y-1 pl-4">
                    @can('view expenses')
                        <x-responsive-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')"
                            class="border-b border-gray-100 hover:bg-gray-50" style="border-bottom: 1px solid #e5e7eb;">{{ __('All Expenses') }}</x-responsive-nav-link>
                    @endcan
                    @can('view expense categories')
                        <x-responsive-nav-link :href="route('expense_categories.index')" :active="request()->routeIs('expense_categories.*')"
                            class="border-b border-gray-100 hover:bg-gray-50">{{ __('Expense Categories') }}</x-responsive-nav-link>
                    @endcan
                </div>
            </div>
        @endcanany

        <!-- Orders & Invoices Group -->
        @canany(['view orders', 'view invoices'])
            <div x-data="{ openOrders: false }" class="space-y-1 border-b border-gray-200">
                <button @click="openOrders = !openOrders" :class="openOrders ? 'bg-gray-100' : ''"
                    class="w-full flex items-center justify-between px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    <span>{{ __('Orders & Invoices') }}</span>
                    <svg :class="{ 'rotate-180': openOrders }" class="h-4 w-4 transform transition-transform"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openOrders" x-collapse class="space-y-1 pl-4">
                    @can('view orders')
                        <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')"
                            class="border-b border-gray-100 hover:bg-gray-50" style="border-bottom: 1px solid #e5e7eb;">{{ __('Orders') }}</x-responsive-nav-link>
                    @endcan
                    @can('view invoices')
                        <x-responsive-nav-link :href="route('invoices.index')" :active="request()->routeIs('invoices.*')"
                            class="border-b border-gray-100 hover:bg-gray-50">{{ __('Invoices') }}</x-responsive-nav-link>
                    @endcan
                </div>
            </div>
        @endcanany

        <!-- Mobile User Info -->
        <div class=" pb-1 ">
            {{-- <div class="px-4" style="border-bottom: 1px solid #e5e7eb;">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div> --}}
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" style="border-bottom: 1px solid #e5e7eb;">{{ __('Profile') }}</x-responsive-nav-link>
                @can('view settings')
                    <x-responsive-nav-link :href="route('settings.index')" style="border-bottom: 1px solid #e5e7eb;">{{ __('Settings') }}</x-responsive-nav-link>
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
