<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Expense Report & Analytics</h2>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('reports.expense') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Expense</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Title, description..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                        <input type="date" name="from_date" value="{{ request('from_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="col-span-4 flex space-x-2 mt-2">
                        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                            Filter
                        </button>
                        <a href="{{ route('reports.expense') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Expenses Table -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Expenses</h3>
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
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($expenses as $expense)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->category->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($expense->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $expense->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
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
                        Showing <span class="font-medium">{{ $expenses->firstItem() }}</span>
                        to <span class="font-medium">{{ $expenses->lastItem() }}</span>
                        of <span class="font-medium">{{ $expenses->total() }}</span> results
                    </div>

                    <!-- Pagination buttons -->
                    <div class="flex space-x-2">
                        <!-- Previous -->
                        @if ($expenses->onFirstPage())
                            <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
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

    </script>
</x-app-layout>
