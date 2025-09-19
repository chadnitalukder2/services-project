<x-app-layout>

     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title & Filters -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Reports & Analytics</h2>
            
            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="all">All Reports</option>
                            <option value="customer">Customer Report</option>
                            <option value="service">Service Report</option>
                            <option value="order">Order Report</option>
                            <option value="invoice">Invoice Report</option>
                            <option value="expense">Expense Report</option>
                            <option value="profit">Profit & Loss</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                        <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                        <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-end">
                        <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            <i class="fas fa-search mr-2"></i>Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Tables -->
        <div class="space-y-8">


            <!-- Invoice Report -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Invoice Status Report</h3>
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
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">156</div>
                            <div class="text-sm text-green-700">Paid Invoices</div>
                            <div class="text-xs text-green-600 mt-1">$42,350 total</div>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <div class="text-2xl font-bold text-yellow-600">24</div>
                            <div class="text-sm text-yellow-700">Partial Paid</div>
                            <div class="text-xs text-yellow-600 mt-1">$6,890 remaining</div>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <div class="text-2xl font-bold text-red-600">18</div>
                            <div class="text-sm text-red-700">Unpaid Invoices</div>
                            <div class="text-xs text-red-600 mt-1">$8,940 outstanding</div>
                        </div>
                    </div>
                </div>
            </div>

         
        </div>
    </div>
   
    <x-slot name="script">
   <script>
        // Revenue vs Expenses Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 15000, 18000, 22000, 19000, 23000],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Expenses',
                    data: [8000, 9500, 11000, 12500, 10800, 12000],
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
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
                labels: ['Pending', 'Approved', 'Done', 'Cancelled'],
                datasets: [{
                    data: [25, 45, 85, 8],
                    backgroundColor: [
                        'rgb(251, 191, 36)',
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)',
                        'rgb(239, 68, 68)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    </script>
    </x-slot>
</x-app-layout>
