<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title & Filters -->
        <div class="mb-8">
            <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-6">Order Reports & Analytics</h2>

            <!-- Order Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

                <!-- Total Orders -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $summary['total_orders'] }}</p>
                            <p class="text-sm text-yellow-600 mt-1">Amount:
                                {{ number_format($summary['total_amount'], 2) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $summary['pending_orders'] }}</p>
                            <p class="text-sm text-yellow-600 mt-1">Amount:
                                {{ number_format($summary['pending_amount'], 2) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Completed Orders -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Completed Orders</p>
                            <p class="text-2xl font-bold text-green-600">{{ $summary['completed_order'] }}</p>
                            <p class="text-sm text-green-600 mt-1">Total Revenue:
                                {{ number_format($summary['completed_amount'], 2) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Cancelled Orders -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Cancelled Orders</p>
                            <p class="text-2xl font-bold text-red-600">{{ $summary['cancelled_orders'] }}</p>
                            <p class="text-sm text-red-600 mt-1">Amount:
                                {{ number_format($summary['cancelled_amount'], 2) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('reports.order') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Order</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Order ID, Customer, Status..."
                            class="w-full px-3 text-sm py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                        <input type="text" id="from_date" name="from_date" value="{{ request('from_date') }}"
                            autocomplete="off" placeholder="dd-mm-yyyy"
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                        <input type="text" id="to_date" name="to_date" value="{{ request('to_date') }}"
                            autocomplete="off" placeholder="dd-mm-yyyy"
                            class="w-full px-3 text-sm py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="flex-1 text-sm bg-orange-600 hover:bg-orange-500 text-white px-4 py-2 rounded-md transition-colors">
                            Search
                        </button>
                        <a href="{{ route('reports.order') }}"
                            class="px-4 py-2 text-sm bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Order Report</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of
                        {{ $orders->total() }} orders
                    </p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="printTable()"
                        class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                        <i class="fas fa-print mr-1"></i>Print
                    </button>
                    <button onclick="exportToCSV()"
                        class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                        <i class="fas fa-download mr-1"></i> CSV
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                @if ($orders->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    SI
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        ID <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Delivery Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Status <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'subtotal', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Subtotal <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'discount_amount', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Discount <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'total_amount', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Total <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $si = $orders->count();
                            @endphp
                            @foreach ($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $si-- }}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#
                                        {{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->customer->name ?? '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->order_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $order->delivery_date ?? '-' }}</td>
                                    <td
                                        class="px-6 py-4 capitalize whitespace-nowrap text-sm font-semibold
                                        @if ($order->status == 'complete') text-green-600
                                        @elseif($order->status == 'pending') text-yellow-500
                                        @elseif($order->status == 'done') text-blue-500
                                        @elseif($order->status == 'canceled') text-red-500
                                        @elseif($order->status == 'approved') text-indigo-600
                                        @else text-gray-900 @endif">
                                        {{ $order->status ?? '---' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($settings->currency_position == 'left')
                                            {{ $settings->currency ?? 'TK' }}
                                            {{ number_format($order->subtotal, 2) }}
                                        @else
                                            {{ number_format($order->subtotal, 2) }}
                                            {{ $settings->currency ?? 'TK' }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($settings->currency_position == 'left')
                                            {{ $settings->currency ?? 'TK' }}
                                            {{ number_format($order->discount_amount, 2) }}
                                        @else
                                            {{ number_format($order->discount_amount, 2) }}
                                            {{ $settings->currency ?? 'TK' }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($settings->currency_position == 'left')
                                            {{ $settings->currency ?? 'TK' }}
                                            {{ number_format($order->total_amount, 2) }}
                                        @else
                                            {{ number_format($order->total_amount, 2) }}
                                            {{ $settings->currency ?? 'TK' }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-100 text-sm font-semibold">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="px-6 py-3 text-right">Total:</td>
                                <td class="px-6 py-3">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? 'TK' }}
                                        {{ number_format($orders->sum('subtotal'), 2) }}
                                    @else
                                        {{ number_format($orders->sum('subtotal'), 2) }}
                                        {{ $settings->currency ?? 'TK' }}
                                    @endif

                                </td>
                                <td class="px-6 py-3">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? 'TK' }}
                                        {{ number_format($orders->sum('discount_amount'), 2) }}
                                    @else
                                        {{ number_format($orders->sum('discount_amount'), 2) }}
                                        {{ $settings->currency ?? 'TK' }}
                                    @endif

                                </td>
                                <td class="px-6 py-3">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? 'TK' }}
                                        {{ number_format($orders->sum('total_amount'), 2) }}
                                    @else
                                        {{ number_format($orders->sum('total_amount'), 2) }}
                                        {{ $settings->currency ?? 'TK' }}
                                    @endif

                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="text-center py-12">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
                        <p class="text-gray-500">Try adjusting your search criteria or clear filters.</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        {{-- Showing <span class="font-medium">{{ $orders->firstItem() }}</span>
                        to <span class="font-medium">{{ $orders->lastItem() }}</span>
                        of <span class="font-medium">{{ $orders->total() }}</span> results --}}
                    </div>
                    <div class="flex space-x-2">
                        @if ($orders->onFirstPage())
                            <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                disabled>Previous</button>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}"
                                class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">Previous</a>
                        @endif

                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if ($page == $orders->currentPage())
                                <span
                                    class="px-3 py-1 bg-gray-800 text-white rounded-md text-sm">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}"
                                class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">Next</a>
                        @else
                            <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                disabled>Next</button>
                        @endif
                    </div>
                </div>
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
            const table = document.querySelector('table');
            if (!table) return;

            let csvData = [];

            // Headers
            const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
            csvData.push(headers);

            // Body rows
            table.querySelectorAll('tbody tr').forEach(row => {
                const rowData = Array.from(row.querySelectorAll('td')).map(td => {
                    let text = td.textContent.trim();
                    text = text.replace(/[^\d.,-]/g, '');
                    return text;
                });
                csvData.push(rowData);
            });

            // Footer rows (optional)
            table.querySelectorAll('tfoot tr').forEach(row => {
                const rowData = Array.from(row.querySelectorAll('td')).map(td => td.textContent.trim());
                csvData.push(rowData);
            });

            // Convert to CSV string with quotes
            const csvString = csvData.map(row => row.map(cell => `"${cell.replace(/"/g, '""')}"`).join(',')).join('\n');

            // Create blob and download
            const blob = new Blob([csvString], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `order-report-${new Date().toISOString().split('T')[0]}.csv`;
            link.click();
        }

        function printTable() {
            const printContent = document.createElement('div');
            printContent.className = 'print-content';

            const header = document.createElement('div');
            header.className = 'print-header';
            header.innerHTML = `
                <h1>Orders Report</h1>
                <p>Generated on: ${new Date().toLocaleDateString()}</p>
                <p>Total Orders: {{ $orders->total() }}</p>
            `;

            const tableClone = document.querySelector('table').cloneNode(true);
            tableClone.className = 'print-table';

            printContent.appendChild(header);
            printContent.appendChild(tableClone);
            document.body.appendChild(printContent);

            window.print();
            setTimeout(() => document.body.removeChild(printContent), 1000);
        }

        //date picker
        document.addEventListener('DOMContentLoaded', function() {
            const dateInputFrom = document.getElementById('from_date');
            const dateInputTo = document.getElementById('to_date');
            flatpickr(dateInputFrom, {
                dateFormat: "d-m-Y",
                allowInput: true
            });
            flatpickr(dateInputTo, {
                dateFormat: "d-m-Y",
                allowInput: true
            });
        });
    </script>
</x-app-layout>
