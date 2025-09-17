<x-app-layout>

     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title & Filters -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Reports & Analytics</h2>
            
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

            <!-- Service Report -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Service Revenue Report</h3>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity Sold</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Revenue</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% of Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Web Development</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$500</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">45</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$22,500</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">49.7%</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Mobile App Development</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$800</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">18</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$14,400</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">31.8%</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">SEO Consulting</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$200</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">42</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$8,400</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">18.5%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

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

            <!-- Expense Report -->
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Expense Report by Category</h3>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% of Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg per Item</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-home text-blue-600 text-sm"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">Office Rent</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$6,000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">48.2%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$500</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-car text-green-600 text-sm"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">Travel</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">28</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$3,200</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">25.7%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$114</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-bullhorn text-purple-600 text-sm"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">Marketing</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$2,150</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">17.3%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$143</td>
                            </tr>
                        </tbody>
                    </table>
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
