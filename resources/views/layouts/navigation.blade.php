<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                {{-- <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div> --}}

                <!-- Reports -->
                @canany(['view permissions', 'view roles', 'view users'])
                    <div class="hidden sm:flex sm:items-center sm:ms-8">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs(['permissions.*', 'roles.*', 'users.*']) ? 'text-gray-900 border-b-2 border-indigo-400' : '' }}">
                                    <div>{{ __('Reports') }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @can('view permissions')
                                    <x-dropdown-link :href="route('permissions.index')" :class="request()->routeIs('permissions.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Customer Report') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('view roles')
                                    <x-dropdown-link :href="route('roles.index')" :class="request()->routeIs('roles.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Service Report ') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('view users')
                                    <x-dropdown-link :href="route('users.index')" :class="request()->routeIs('users.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Order Report') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('view users')
                                    <x-dropdown-link :href="route('users.index')" :class="request()->routeIs('users.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Invoice Report ') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('view users')
                                    <x-dropdown-link :href="route('users.index')" :class="request()->routeIs('users.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Expense Report') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('view users')
                                    <x-dropdown-link :href="route('users.index')" :class="request()->routeIs('users.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Profit & Loss') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                            </x-slot>
                        </x-dropdown>
                    </div>
                @endcanany

                <!-- User Management Dropdown -->
                @canany(['view permissions', 'view roles', 'view users'])
                    <div class="hidden sm:flex sm:items-center sm:ms-8">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs(['permissions.*', 'roles.*', 'users.*']) ? 'text-gray-900 border-b-2 border-indigo-400' : '' }}">
                                    <div>{{ __('Users') }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @can('view permissions')
                                    <x-dropdown-link :href="route('permissions.index')" :class="request()->routeIs('permissions.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Permissions') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('view roles')
                                    <x-dropdown-link :href="route('roles.index')" :class="request()->routeIs('roles.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Roles') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('view users')
                                    <x-dropdown-link :href="route('users.index')" :class="request()->routeIs('users.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Users') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endcanany

                <!-- Customers -->
                @can('view customers')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                            {{ __('Customers') }}
                        </x-nav-link>
                    </div>
                @endcan

                <!-- Services -->
                @can('view services')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')">
                            {{ __('Services') }}
                        </x-nav-link>
                    </div>
                @endcan

                <!-- Expense Management Dropdown -->
                @canany(['view expense categories', 'view expenses'])
                    <div class="hidden sm:flex sm:items-center sm:ms-8">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs(['expense_categories.*', 'expenses.*']) ? 'text-gray-900 border-b-2 border-indigo-400' : '' }}">
                                    <div>{{ __('Expenses') }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @can('view expense categories')
                                    <x-dropdown-link :href="route('expense_categories.index')" :class="request()->routeIs('expense_categories.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Expense Categories') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('view expenses')
                                    <x-dropdown-link :href="route('expenses.index')" :class="request()->routeIs('expenses.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Expenses') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endcanany

                  <!-- Order and Invoice -->
                @canany(['view expense categories', 'view expenses'])
                    <div class="hidden sm:flex sm:items-center sm:ms-8">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs(['expense_categories.*', 'expenses.*']) ? 'text-gray-900 border-b-2 border-indigo-400' : '' }}">
                                    <div>{{ __('Orders & Invoices') }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @can('view expense categories')
                                    <x-dropdown-link :href="route('expense_categories.index')" :class="request()->routeIs('expense_categories.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Orders') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan

                                @can('view expenses')
                                    <x-dropdown-link :href="route('expenses.index')" :class="request()->routeIs('expenses.*') ? 'bg-gray-100' : ''">
                                        <div class="flex items-center">
                                            {{ __('Invoices') }}
                                        </div>
                                    </x-dropdown-link>
                                @endcan
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endcanany

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }} ({{ Auth::user()->roles->pluck('name')->implode(', ') }})
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('Profile') }}
                            </div>
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    {{ __('Log Out') }}
                                </div>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
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

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- User Management Mobile -->
            @canany(['view permissions', 'view roles', 'view users'])
                <div class="px-4 pt-2 pb-1">
                    <div class="font-medium text-base text-gray-800">{{ __('User Management') }}</div>
                </div>
                @can('view permissions')
                    <x-responsive-nav-link :href="route('permissions.index')" :active="request()->routeIs('permissions.*')" class="pl-8">
                        {{ __('Permissions') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view roles')
                    <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')" class="pl-8">
                        {{ __('Roles') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view users')
                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="pl-8">
                        {{ __('Users') }}
                    </x-responsive-nav-link>
                @endcan
            @endcanany

            <!-- Services Mobile -->
            @can('view services')
                <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')">
                    {{ __('Services') }}
                </x-responsive-nav-link>
            @endcan

            <!-- Customers Mobile -->
            @can('view customers')
                <x-responsive-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                    {{ __('Customers') }}
                </x-responsive-nav-link>
            @endcan

            <!-- Expense Management Mobile -->
            @canany(['view expense categories', 'view expenses'])
                <div class="px-4 pt-2 pb-1">
                    <div class="font-medium text-base text-gray-800">{{ __('Expense Management') }}</div>
                </div>
                @can('view expense categories')
                    <x-responsive-nav-link :href="route('expense_categories.index')" :active="request()->routeIs('expense_categories.*')" class="pl-8">
                        {{ __('Expense Categories') }}
                    </x-responsive-nav-link>
                @endcan
                @can('view expenses')
                    <x-responsive-nav-link :href="route('expenses.index')" :active="request()->routeIs('expenses.*')" class="pl-8">
                        {{ __('Expenses') }}
                    </x-responsive-nav-link>
                @endcan
            @endcanany
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
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
            </div>
        </div>
    </div>
</nav>
