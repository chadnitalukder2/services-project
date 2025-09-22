<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Page Title & Filters -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Invoice Reports & Analytics</h2>

            <!-- Invoice Report -->
            <div class="bg-white rounded-lg shadow-sm border mb-8">

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
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
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('reports.invoice') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Customer</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Name, email, phone..."
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
                            class="flex-1 bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition-colors">Filter</button>
                        <a href="{{ url('/invoice/reports') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">Clear</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Invoice Table -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Invoices</h3>
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
                @if ($invoices->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Paid</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Due</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Payment Method</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($invoices as $invoice)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $invoice->id }}</td>
                                    <td class="px-6 py-4">{{ $invoice->customer->name }}</td>
                                    <td class="px-6 py-4">#{{ $invoice->order_id }}</td>
                                    <td class="px-6 py-4">
                                        {{ $settings->currency_position == 'left' ? $settings->currency . ' ' . $invoice->amount : $invoice->amount . ' ' . $settings->currency }}
                                    </td>
                                    <td class="px-6 py-4 text-green-500">
                                        {{ $settings->currency_position == 'left' ? $settings->currency . ' ' . $invoice->paid_amount : $invoice->paid_amount . ' ' . $settings->currency }}
                                    </td>
                                    <td class="px-6 py-4 text-red-500">
                                        {{ $settings->currency_position == 'left' ? $settings->currency . ' ' . $invoice->due_amount : $invoice->due_amount . ' ' . $settings->currency }}
                                    </td>
                                    <td class="px-6 py-4">{{ $invoice->status }}</td>
                                    <td class="px-6 py-4">{{ $invoice->payment_method }}</td>
                                    <td class="px-6 py-4">{{ $invoice->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">No invoices found</div>
                @endif
            </div>
  <!-- Pagination buttons -->
            <div class="flex space-x-2">
                <!-- Previous -->
                @if ($invoices->onFirstPage())
                    <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed" disabled>
                        Previous
                    </button>
                @else
                    <a href="{{ $invoices->previousPageUrl() }}"
                        class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                        Previous
                    </a>
                @endif

                <!-- Page numbers -->
                @foreach ($invoices->getUrlRange(1, $invoices->lastPage()) as $page => $url)
                    @if ($page == $invoices->currentPage())
                        <span
                            class="px-3 py-1 bg-gray-800 hover:bg-gray-700 text-white rounded-md text-sm">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                <!-- Next -->
                @if ($invoices->hasMorePages())
                    <a href="{{ $invoices->nextPageUrl() }}"
                        class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                        Next
                    </a>
                @else
                    <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed" disabled>
                        Next
                    </button>
                @endif
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
            const headers = Array.from(table.querySelectorAll('thead th')).map(h => `"${h.textContent.trim()}"`);
            csvData.push(headers);

            table.querySelectorAll('tbody tr').forEach(row => {
                const rowData = Array.from(row.querySelectorAll('td')).map(td =>
                    `"${td.textContent.trim().replace(/"/g,'""')}"`);
                csvData.push(rowData);
            });

            const blob = new Blob([csvData.map(r => r.join(',')).join('\n')], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `invoice-report-${new Date().toISOString().split('T')[0]}.csv`;
            link.click();
        }

        function printTable() {
            const printContent = document.createElement('div');
            printContent.className = 'print-content';

            const header = document.createElement('div');
            header.className = 'print-header';
            header.innerHTML = `
                <h1>Invoice Report</h1>
                <p>Generated on: ${new Date().toLocaleDateString()}</p>
                <p>Total Invoices: {{ $invoices->total() }}</p>
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
