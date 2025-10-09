<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title & Filters -->
        <div class="mb-8">
            <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-6">Profit & Loss Report</h2>

            <!-- Quick Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
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
                            <p class="text-2xl font-bold text-red-600"> <i
                                    class="fa-solid fa-bangladeshi-taka-sign"></i>
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
                            <p class="text-2xl font-bold text-blue-600"> <i
                                    class="fa-solid fa-bangladeshi-taka-sign"></i>
                                {{ number_format($netProfit, 2) }}</p>
                            <p class="text-sm text-blue-600 mt-1"> {{ $profitGrowth >= 0 ? '↗' : '↘' }}
                                {{ number_format($profitGrowth, 1) }}% from last month</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('reports.profit-loss') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="flex-1 text-sm bg-sky-600 hover:bg-sky-500 text-white px-4 py-2 rounded-md transition-colors">
                            Search
                        </button>
                        <a href="{{ route('reports.profit-loss') }}"
                            class="px-4 py-2 text-sm bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Report Results -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Profit & Loss Summary</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Date Range:
                            {{ $startDate ?? 'All' }} to {{ $endDate ?? 'All' }}
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="printTable()"
                            class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                            <i class="fas fa-print mr-1"></i> Print
                        </button>
                        <button onclick="exportToCSV()"
                            class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                            <i class="fas fa-download mr-1"></i> CSV
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Orders
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Expenses
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Profit / Loss
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @if ($settings->currency_position == 'left')
                                    {{ $settings->currency ?? '৳' }}
                                    {{ number_format($orders, 2) }}
                                @else
                                     {{ number_format($orders, 2) }}
                                    {{ $settings->currency ?? '৳' }}
                                @endif
                               
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @if ($settings->currency_position == 'left')
                                    {{ $settings->currency ?? '৳' }}
                                     {{ number_format($expenses, 2) }}
                                @else
                                     {{ number_format($expenses, 2) }}
                                    {{ $settings->currency ?? '৳' }}
                                @endif
                               
                            </td>
                            <td
                                class="px-6 py-4 font-bold text-sm {{ $profitLoss >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                @if ($settings->currency_position == 'left')
                                    {{ $settings->currency ?? '৳' }}
                                    {{ number_format($profitLoss, 2) }}
                                @else
                                    {{ number_format($profitLoss, 2) }}
                                    {{ $settings->currency ?? '৳' }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {

            /* Hide everything except the table */
            body * {
                visibility: hidden;
            }

            /* Show only the print content */
            .print-content,
            .print-content * {
                visibility: visible;
            }

            /* Position the print content */
            .print-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* Hide pagination and other elements during print */
            .no-print {
                display: none !important;
            }

            /* Table styling for print */
            .print-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
            }

            .print-table th,
            .print-table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            .print-table th {
                background-color: #f5f5f5;
                font-weight: bold;
            }

            /* Print header */
            .print-header {
                margin-bottom: 20px;
                text-align: center;
            }

            .print-header h1 {
                font-size: 24px;
                margin-bottom: 10px;
            }

            .print-header p {
                font-size: 14px;
                color: #666;
            }
        }
    </style>
    <script>
        function exportToCSV() {
            const rows = [];
            const headers = ["Total Orders", "Total Expenses", "Profit / Loss"];
            rows.push(headers);

            const row = [
                "{{ $orders ?? 0 }}",
                "{{ $expenses ?? 0 }}",
                "{{ $profitLoss ?? 0 }}"
            ];
            rows.push(row);

            // Convert to CSV string
            let csvContent = rows.map(e => e.join(",")).join("\n");

            // Create blob and download
            const blob = new Blob([csvContent], {
                type: "text/csv;charset=utf-8;"
            });
            const link = document.createElement("a");
            const url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", `profit-loss-report-${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = "hidden";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function printTable() {
            const printContent = document.createElement("div");
            printContent.className = "print-content";
            const header = document.createElement("div");
            header.className = "print-header";
            header.innerHTML = `
                <h1>Profit & Loss Report</h1>
                <p>Generated on: ${new Date().toLocaleDateString()}</p>
                <p>Date Range: {{ $startDate ?? 'All' }} to {{ $endDate ?? 'All' }}</p>
            `;
            const tableClone = document.querySelector("table").cloneNode(true);
            tableClone.className = "print-table";
            printContent.appendChild(header);
            printContent.appendChild(tableClone);
            document.body.appendChild(printContent);
            window.print();
            setTimeout(() => document.body.removeChild(printContent), 1000);
        }
    </script>
</x-app-layout>
