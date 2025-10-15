<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-6">Expense Report & Analytics</h2>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('reports.expense') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Expense</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Title, description..."
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category_id"
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
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
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="flex-1 text-sm bg-orange-600 hover:bg-orange-500 text-white px-4 py-2 rounded-md transition-colors">
                            Search
                        </button>
                        <a href="{{ url('/expense/reports') }}"
                            class="px-4 py-2 text-sm bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Expenses Table -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Expenses Reports</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Showing {{ $expenses->firstItem() ?? 0 }} to {{ $expenses->lastItem() ?? 0 }} of
                        {{ $expenses->total() }} expenses
                    </p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="printTable()"
                        class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                        <i class="fas fa-print mr-1"></i>Print
                    </button>
                    <button onclick="exportToCSV()"
                        class="px-3 py-1  bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                        <i class="fas fa-download mr-1"></i>CSV
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                @if ($expenses->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-xs ">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                                    SI
                                </th>
                                <th class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider">

                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Title
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider">

                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'amount', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Amount
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                             @php
                                $si = $expenses->count();
                            @endphp
                            @foreach ($expenses as $expense)
                                <tr class="hover:bg-gray-50 ">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $si-- }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->category->name ?? '---' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($settings->currency_position == 'left')
                                            {{ $settings->currency ?? 'TK' }}
                                            {{ number_format($expense->amount, 2) }}
                                        @else
                                            {{ number_format($expense->amount, 2) }}
                                            {{ $settings->currency ?? 'TK' }}
                                        @endif

                                    </td>
                                    <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($expense->created_at)->format('d M, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-100 font-semibold text-sm">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="px-6 py-3 text-right">Total Expense:</td>
                                <td class="px-6 py-3">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? 'TK' }}
                                        {{ number_format($expenses->sum('amount'), 2) }}
                                    @else
                                        {{ number_format($expenses->sum('amount'), 2) }}
                                        {{ $settings->currency ?? 'TK' }}
                                    @endif

                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="text-center py-12">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No expenses found</h3>
                        <p class="text-gray-500">Try adjusting your search criteria.</p>
                    </div>
                @endif

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            {{-- Showing <span class="font-medium">{{ $expenses->firstItem() }}</span>
                            to <span class="font-medium">{{ $expenses->lastItem() }}</span>
                            of <span class="font-medium">{{ $expenses->total() }}</span> results --}}
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex space-x-2">
                            <!-- Previous -->
                            @if ($expenses->onFirstPage())
                                <button
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                    disabled>
                                    Previous
                                </button>
                            @else
                                <a href="{{ $expenses->previousPageUrl() }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                    Previous
                                </a>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($expenses->getUrlRange(1, $expenses->lastPage()) as $page => $url)
                                @if ($page == $expenses->currentPage())
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
                            @if ($expenses->hasMorePages())
                                <a href="{{ $expenses->nextPageUrl() }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                    Next
                                </a>
                            @else
                                <button
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                    disabled>
                                    Next
                                </button>
                            @endif
                        </div>
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

            let csv = [];

            // Table headers
            const headers = table.querySelectorAll('thead th');
            csv.push(Array.from(headers).map(h => h.textContent.trim()).join(','));

            // Table body rows
            table.querySelectorAll('tbody tr').forEach(row => {
                const cells = row.querySelectorAll('td');
                csv.push(Array.from(cells).map(c => `"${c.textContent.trim()}"`).join(','));
            });

            // Download CSV
            const blob = new Blob([csv.join('\n')], {
                type: 'text/csv'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `expense-report-${new Date().toISOString().split('T')[0]}.csv`;
            link.click();
        }

        function printTable() {
            const printContent = document.createElement('div');
            printContent.className = 'print-content';

            // Print Header for Expense
            const header = document.createElement('div');
            header.className = 'print-header';
            header.innerHTML = `
                <h1>Expense Report</h1>
                <p>Generated on: ${new Date().toLocaleDateString()}</p>
                <p>Total Expenses: {{ $expenses->total() }}</p>
             `;

            // Clone the table
            const originalTable = document.querySelector('table');
            if (!originalTable) return;

            const table = originalTable.cloneNode(true);
            table.className = 'print-table';

            // Append header + table
            printContent.appendChild(header);
            printContent.appendChild(table);

            document.body.appendChild(printContent);
            window.print();

            // Clean up after printing
            setTimeout(() => {
                document.body.removeChild(printContent);
            }, 1000);
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
