<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title & Filters -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Reports & Analytics</h2>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('reports.order') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Order</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Order ID, Customer, Status..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="flex-1 bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition-colors">
                            Filter
                        </button>
                        <a href="{{ route('reports.order') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->customer->name ?? '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->order_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->delivery_date ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->status ?? 'Pending' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($order->subtotal ?? 0,2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($order->discount_amount ?? 0,2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($order->total_amount ?? 0,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
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
                        Showing <span class="font-medium">{{ $orders->firstItem() }}</span>
                        to <span class="font-medium">{{ $orders->lastItem() }}</span>
                        of <span class="font-medium">{{ $orders->total() }}</span> results
                    </div>
                    <div class="flex space-x-2">
                        @if ($orders->onFirstPage())
                            <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed" disabled>Previous</button>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">Previous</a>
                        @endif

                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if ($page == $orders->currentPage())
                                <span class="px-3 py-1 bg-gray-800 text-white rounded-md text-sm">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">Next</a>
                        @else
                            <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed" disabled>Next</button>
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
            const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
            csvData.push(headers);

            table.querySelectorAll('tbody tr').forEach(row => {
                const rowData = Array.from(row.querySelectorAll('td')).map(td => td.textContent.trim());
                csvData.push(rowData);
            });

            const csvString = csvData.map(r => r.join(',')).join('\n');
            const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `order-report-${new Date().toISOString().split('T')[0]}.csv`;
            link.click();
        }

        // function printTable() {
        //     const printContent = document.createElement('div');
        //     printContent.className = 'print-content';
        //     const header = document.createElement('div');
        //     header.innerHTML = `<h1>Order Report</h1><p>Generated on: ${new Date().toLocaleDateString()}</p>`;
        //     const tableClone = document.querySelector('table').cloneNode(true);
        //     tableClone.style.width = '100%';
        //     printContent.appendChild(header);
        //     printContent.appendChild(tableClone);
        //     document.body.appendChild(printContent);
        //     window.print();
        //     setTimeout(() => document.body.removeChild(printContent), 1000);
        // }
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
    </script>
</x-app-layout>
