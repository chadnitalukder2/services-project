<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title & Filters -->
        <div class="mb-8">
            <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-6">Customer Reports & Analytics</h2>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('reports.customer') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Customer</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder=" Search by name address..."
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                        <input type="text" name="from_date" id="from_date" value="{{ request('from_date') }}"
                            placeholder="dd-mm-yyyy"
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                        <input type="text" id="to_date" name="to_date" value="{{ request('to_date') }}"   placeholder="dd-mm-yyyy"
                            class="w-full px-3 text-sm py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="flex-1 text-sm bg-orange-600 hover:bg-orange-500 text-white px-4 py-2 rounded-md transition-colors">
                            Search
                        </button>
                        <a href="{{ url('/customer/reports') }}"
                            class="px-4 py-2 text-sm bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Customer Report Results -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Customer Report</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of
                            {{ $customers->total() }} customers
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
            </div>

            <div class="overflow-x-auto">
                @if ($customers->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        ID <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Customer
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <!-- sort orders count -->
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'orders_count', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Orders
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Invoices</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <!-- sort total amount from invoices -->
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'invoices_sum_amount', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Amount
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <!-- sort total paid amount from invoices -->
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'invoices_sum_paid_amount', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Paid
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <!-- sort total due amount from invoices -->
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'invoices_sum_due_amount', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Due
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($customers as $customer)
                                <tr class="hover:bg-gray-50">
                                    <td>
                                        <div class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            #{{ $customer->id }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="">
                                                <div class="text-sm font-medium text-gray-900">{{ $customer->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $customer->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $customer->orders_count ?? 0 }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $customer->invoices_count ?? 0 }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if ($settings->currency_position == 'left')
                                                {{ $settings->currency ?? '৳' }}
                                                {{ number_format($customer->invoices_sum_amount ?? 0, 2) }}
                                            @else
                                                {{ number_format($customer->invoices_sum_amount ?? 0, 2) }}
                                                {{ $settings->currency ?? '৳' }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-green-500">
                                            @if ($settings->currency_position == 'left')
                                                {{ $settings->currency ?? '৳' }}
                                                {{ number_format($customer->invoices_sum_paid_amount ?? 0, 2) }}
                                            @else
                                                {{ number_format($customer->invoices_sum_paid_amount ?? 0, 2) }}
                                                {{ $settings->currency ?? '৳' }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-red-500">
                                            @if ($settings->currency_position == 'left')
                                                {{ $settings->currency ?? '৳' }}
                                                {{ number_format($customer->invoices_sum_due_amount ?? 0, 2) }}
                                            @else
                                                {{ number_format($customer->invoices_sum_due_amount ?? 0, 2) }}
                                                {{ $settings->currency ?? '৳' }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($customer->created_at)->format('d M, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-100 font-semibold text-sm">
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="px-6 py-4 text-right">Totals:</td>
                                <td class="px-6 py-4 text-left">{{ $totalOrders }}</td>
                                <td class="px-6 py-4 text-left">{{ $totalInvoices }}</td>
                                <td class="px-6 py-4">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? '৳' }}
                                        {{ number_format($totalAmount, 2) }}
                                    @else
                                        {{ number_format($totalAmount, 2) }}
                                        {{ $settings->currency ?? '৳' }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-green-600">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? '৳' }}
                                        {{ number_format($totalPaid, 2) }}
                                    @else
                                        {{ number_format($totalPaid, 2) }}
                                        {{ $settings->currency ?? '৳' }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-red-600">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? '৳' }}
                                        {{ number_format($totalDue, 2) }}
                                    @else
                                        {{ number_format($totalDue, 2) }}
                                        {{ $settings->currency ?? '৳' }}
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-users text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No customers found</h3>
                        <p class="text-gray-500">
                            @if (request()->hasAny(['search', 'from_date', 'to_date']))
                                Try adjusting your search criteria or
                                <a href="{{ url('/customer/reports') }}"
                                    class="text-blue-600 hover:text-blue-700">clear filters</a>.
                            @else
                                There are no customers registered yet.
                            @endif
                        </p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        {{-- Showing <span class="font-medium">{{ $customers->firstItem() }}</span>
                        to <span class="font-medium">{{ $customers->lastItem() }}</span>
                        of <span class="font-medium">{{ $customers->total() }}</span> results --}}
                    </div>

                    <!-- Pagination buttons -->
                    <div class="flex space-x-2">
                        <!-- Previous -->
                        @if ($customers->onFirstPage())
                            <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                disabled>
                                Previous
                            </button>
                        @else
                            <a href="{{ $customers->previousPageUrl() }}"
                                class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                Previous
                            </a>
                        @endif

                        <!-- Page numbers -->
                        @foreach ($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                            @if ($page == $customers->currentPage())
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
                        @if ($customers->hasMorePages())
                            <a href="{{ $customers->nextPageUrl() }}"
                                class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                Next
                            </a>
                        @else
                            <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                disabled>
                                Next
                            </button>
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

    <!-- JavaScript for additional functionality -->
    <script>
        function exportToCSV() {
            const table = document.querySelector('table');
            if (!table) return;

            let csvData = [];

            // Get table headers
            const headerRow = table.querySelector('thead tr');
            if (headerRow) {
                const headers = [];
                const headerCells = headerRow.querySelectorAll('th');

                headerCells.forEach(cell => {
                    // Extract clean text from header, removing sort icons and extra whitespace
                    let headerText = cell.textContent.replace(/\s+/g, ' ').trim();
                    // Remove sort icon if present
                    headerText = headerText.replace(/\uf0dc|\uf15d|\uf15e/, '').trim();
                    headers.push(headerText);
                });

                csvData.push(headers);
            }

            // Get table body rows
            const bodyRows = table.querySelectorAll('tbody tr');
            bodyRows.forEach(row => {
                const rowData = [];
                const cells = row.querySelectorAll('td');

                cells.forEach((cell, index) => {
                    let cellText = '';

                    // Handle different column types
                    switch (index) {
                        case 0: // ID column
                            cellText = cell.textContent.trim();
                            break;

                        case 1: // Customer name column
                            const nameDiv = cell.querySelector('.text-sm.font-medium');
                            cellText = nameDiv ? nameDiv.textContent.trim() : cell.textContent.trim();
                            break;

                        case 2: // Contact column (email and phone)
                            const emailDiv = cell.querySelector('.text-sm.text-gray-900');
                            const phoneDiv = cell.querySelector('.text-sm.text-gray-500');
                            const email = emailDiv ? emailDiv.textContent.trim() : '';
                            const phone = phoneDiv ? phoneDiv.textContent.trim() : '';
                            cellText = email + (phone ? ' | ' + phone : '');
                            break;

                        default: // Other columns (orders, invoices, amounts)
                            const dataDiv = cell.querySelector('.text-sm');
                            cellText = dataDiv ? dataDiv.textContent.trim() : cell.textContent.trim();
                            break;
                    }

                    // Clean up the text and handle CSV formatting
                    cellText = cellText.replace(/\s+/g, ' ').trim();

                    // Escape quotes and wrap in quotes if contains comma, quote, or newline
                    if (cellText.includes(',') || cellText.includes('"') || cellText.includes('\n')) {
                        cellText = '"' + cellText.replace(/"/g, '""') + '"';
                    }

                    rowData.push(cellText);
                });

                csvData.push(rowData);
            });

            // Convert to CSV string
            const csvString = csvData.map(row => row.join(',')).join('\n');

            const blob = new Blob([csvString], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement('a');

            if (link.download !== undefined) {
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', `customer-report-${new Date().toISOString().split('T')[0]}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        function exportToStructuredCSV() {
            const customers = [];

            const headers = [
                'ID',
                'Customer Name',
                'Email',
                'Phone',
                'Total Orders',
                'Total Invoices',
                'Total Paid',
                'Total Due',
                'Total Amount'
            ];

            let csvContent = headers.join(',') + '\n';

            // Parse data from table rows
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowData = [];

                // ID
                rowData.push(cells[0].textContent.trim());

                // Customer Name
                const nameCell = cells[1].querySelector('.text-sm.font-medium');
                rowData.push(nameCell ? nameCell.textContent.trim() : '');

                // Email
                const emailCell = cells[2].querySelector('.text-sm.text-gray-900');
                rowData.push(emailCell ? emailCell.textContent.trim() : '');

                // Phone  
                const phoneCell = cells[2].querySelector('.text-sm.text-gray-500');
                rowData.push(phoneCell ? phoneCell.textContent.trim() : '');

                // Total Orders
                rowData.push(cells[3].textContent.trim());

                // Total Invoices
                rowData.push(cells[4].textContent.trim());

                // Total Paid
                rowData.push(cells[5].textContent.trim());

                // Total Due
                rowData.push(cells[6].textContent.trim());

                // Total Amount
                rowData.push(cells[7].textContent.trim());

                // Escape and format each field
                const formattedRow = rowData.map(field => {
                    if (field.includes(',') || field.includes('"') || field.includes('\n')) {
                        return '"' + field.replace(/"/g, '""') + '"';
                    }
                    return field;
                });

                csvContent += formattedRow.join(',') + '\n';
            });

            // Download the CSV
            const blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `customer-report-${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }


        function printTable() {
            const printContent = document.createElement('div');
            printContent.className = 'print-content';

            const header = document.createElement('div');
            header.className = 'print-header';
            header.innerHTML = `
                <h1>Customer Report</h1>
                <p>Generated on: ${new Date().toLocaleDateString()}</p>
                <p>Total Customers: {{ $customers->total() }}</p>
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
