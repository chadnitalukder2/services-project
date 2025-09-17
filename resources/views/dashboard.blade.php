<x-app-layout>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title & Filters -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Dashboard</h2>
        </div>

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-3xl font-bold text-green-600"><i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ number_format($totalRevenue, 2) }}</p>
                        <p class="text-sm text-green-500 mt-1">  {{ $revenueGrowth >= 0 ? '↗' : '↘' }} {{ number_format($revenueGrowth, 1) }}% from last month</p>
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
                        <p class="text-3xl font-bold text-red-600"> <i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ number_format($totalExpenses, 2) }}</p>
                        <p class="text-sm text-red-500 mt-1">  {{ $expenseGrowth >= 0 ? '↗' : '↘' }} {{ number_format($expenseGrowth, 1) }}% from last month</p>
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
                        <p class="text-3xl font-bold text-blue-600">  <i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ number_format($netProfit, 2) }}</p>
                          <p class="text-sm text-blue-600 mt-1">  {{ $expenseGrowth >= 0 ? '↗' : '↘' }} {{ number_format($expenseGrowth, 1) }}% from last month</p>
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
                        <p class="text-3xl font-bold text-orange-600"> {{ $pendingInvoices }}</p>
                        <p class="text-sm text-orange-500 mt-1"> <i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ number_format($outstanding, 2) }} outstanding</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-invoice text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue vs Expenses Chart -->
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Revenue vs Expenses</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>

            <!-- Order Status Distribution -->
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Order Status Distribution</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
                <canvas id="orderChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Report Tables -->
        <div class="space-y-8">
            <!-- Customer Report -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Customer Report</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                <i class="fas fa-filter mr-1"></i>Filter
                            </button>
                            <button class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                <i class="fas fa-download mr-1"></i>Export
                            </button>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Orders</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Invoiced</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Outstanding</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-medium">AC</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Acme Corp</div>
                                            <div class="text-sm text-gray-500">acme@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$12,450</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$10,200</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$2,250</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Partial Paid</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <span class="text-green-600 font-medium">TI</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Tech Innovations</div>
                                            <div class="text-sm text-gray-500">info@techinnov.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">8</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$8,900</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$8,900</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$0</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Paid</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <x-slot name="script">
      <script>
    // Convert backend data to JS
    const revenueData = @json(array_values($monthlyRevenue->toArray()));
    const expenseData = @json(array_values($monthlyExpenses->toArray()));
    const orderLabels = @json($orderStatus->keys());
    const orderData   = @json($orderStatus->values());

    // Revenue vs Expenses Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [
                { label: 'Revenue', data: revenueData, borderColor: 'rgb(59, 130, 246)' },
                { label: 'Expenses', data: expenseData, borderColor: 'rgb(239, 68, 68)' }
            ]
        },
        options: { responsive: true }
    });

    // Order Status Chart
    const orderCtx = document.getElementById('orderChart').getContext('2d');
    new Chart(orderCtx, {
        type: 'doughnut',
        data: {
            labels: orderLabels,
            datasets: [{
                data: orderData,
                backgroundColor: ['#fbbf24','#3b82f6','#22c55e','#ef4444']
            }]
        },
        options: { responsive: true }
    });
</script>

    </x-slot>
</x-app-layout>
