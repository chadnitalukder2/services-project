<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title & Filters -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h2>
        </div>

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-2xl font-bold text-green-600"><i class="fa-solid fa-bangladeshi-taka-sign"></i>
                            {{ number_format($totalRevenue, 2) }}</p>
                        <p class="text-sm text-green-500 mt-1"> {{ $revenueGrowth >= 0 ? '↗' : '↘' }}
                            {{ number_format($revenueGrowth, 1) }}% from last month</p>
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
                        <p class="text-2xl font-bold text-red-600"> <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                            {{ number_format($totalExpenses, 2) }}</p>
                        <p class="text-sm text-red-500 mt-1"> {{ $expenseGrowth >= 0 ? '↗' : '↘' }}
                            {{ number_format($expenseGrowth, 1) }}% from last month</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-credit-card text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Net Profit</p>
                        <p class="text-2xl font-bold text-blue-600"> <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                            {{ number_format($netProfit, 2) }}</p>
                        <p class="text-sm text-blue-600 mt-1"> {{ $profitGrowth >= 0 ? '↗' : '↘' }}
                            {{ number_format($profitGrowth, 1) }}% from last month</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending Invoices</p>
                        <p class="text-2xl font-bold text-orange-600"> {{ $pendingInvoices }}</p>
                        <p class="text-sm text-orange-500 mt-1"> <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                            {{ number_format($outstanding, 2) }} outstanding</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-invoice text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Revenue vs Expenses Chart -->
            <div class="bg-white p-6 lg:col-span-2 rounded-lg shadow-sm border">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Revenue vs Expenses</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        {{-- <i class="fas fa-download"></i> --}}
                    </button>
                </div>
                <canvas style="height: 400px; width: 100%;" id="revenueChart"></canvas>
            </div>

            <!-- Order Status Distribution -->
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Order Status Distribution</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        {{-- <i class="fas fa-download"></i> --}}
                    </button>
                </div>
                <canvas id="orderChart" style="height: 400px; width: 100%;"></canvas>
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
                    responsive: false,
                    maintainAspectRatio: false, // respect canvas size
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
                        backgroundColor: ['#fbbf24', '#3b82f6', '#22c55e',
                            '#ef4444'
                        ] // pending, approved, done, cancel
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    cutout: "70%",
                }
            });
        </script>

    </x-slot>
</x-app-layout>
