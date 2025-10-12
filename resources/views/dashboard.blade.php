<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 pt-8 md:py-8">
        <!-- Page Title & Filters -->
        <div class="md:mb-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-0 md:mb-6">Dashboard</h2>
        </div>

        <!-- Quick Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6 mb-0 md:mb-6">

            <div class="grid grid-cols-3 md:grid-cols-3 gap-2">
                <!-- Add Expense -->
                <a href="{{ route('expenses.index') }}"
                    class="block bg-gray-800 hover:bg-gray-700 px-2 md:px-4 py-2 rounded-lg shadow-sm border text-center">
                    <span class="text-sm   font-semibold text-white">All Expense</span>
                </a>

                <!-- Add Service -->
                <a href="{{ route('services.index') }}"
                    class="block bg-gray-800 hover:bg-gray-700 px-2 md:px-4 py-2 rounded-lg shadow-sm border text-center">
                    <span class="text-sm  font-semibold text-white">All Service</span>
                </a>

                <!-- Add Order -->
                <a href="{{ route('orders.create') }}"
                    class="block bg-gray-800 hover:bg-gray-700 px-2 md:px-4 py-2 rounded-lg shadow-sm border text-center">
                    <span class="text-sm -semibold text-white">Add Order</span>
                </a>
            </div>
            <div></div>
            <div></div>

        </div>


        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-4 md:mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-2xl font-bold text-green-600">
                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                            {{ number_format($totalRevenue, 2) }}
                        </p>
                        <p class="text-sm text-green-500 mt-1">
                            {{ $revenueGrowth >= 0 ? '↗' : '↘' }}
                            {{ number_format($revenueGrowth, 1) }}% from last month
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-bangladeshi-taka-sign text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Expenses</p>
                        <p class="text-2xl font-bold text-red-600">
                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                            {{ number_format($totalExpenses, 2) }}
                        </p>
                        <p class="text-sm text-red-500 mt-1">
                            {{ $expenseGrowth >= 0 ? '↗' : '↘' }}
                            {{ number_format($expenseGrowth, 1) }}% from last month
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-credit-card text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                        <p class="text-2xl font-bold text-orange-600"> {{ $pendingOrder }}</p>
                        <p class="text-sm text-orange-500 mt-1">
                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                            {{ number_format($outstanding, 2) }} outstanding
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-invoice text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
            <!-- Revenue vs Expenses Chart -->
            <div class="bg-white p-6 lg:col-span-2 rounded-lg shadow-sm border">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Revenue vs Expenses</h3>
                    <button class="text-gray-400 hover:text-gray-600"></button>
                </div>
                <div class="h-80"> <!-- Fixed height, responsive width -->
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Order Status Distribution -->
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Order Status Distribution</h3>
                    <button class="text-gray-400 hover:text-gray-600"></button>
                </div>
                <div class="h-80">
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            const revenueData = @json(array_values($monthlyRevenue->toArray()));
            const expenseData = @json(array_values($monthlyExpenses->toArray()));
            const orderLabels = @json($orderStatus->keys());
            const orderData = @json($orderStatus->values());

            // Revenue vs Expenses Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                            label: 'Revenue',
                            data: revenueData,
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1
                        },
                        {
                            label: 'Expenses',
                            data: expenseData,
                            borderColor: 'rgb(239, 68, 68)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Order Status Chart
            const orderCtx = document.getElementById('orderChart').getContext('2d');
            new Chart(orderCtx, {
                type: 'doughnut',
                data: {
                    labels: orderLabels,
                    datasets: [{
                        data: orderData,
                        backgroundColor: ['#fbbf24', '#3b82f6', '#22c55e', '#ef4444']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: "70%",
                }
            });
        </script>
    </x-slot>
</x-app-layout>
