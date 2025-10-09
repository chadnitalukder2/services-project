<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title & Filters -->
        <div class="mb-8">
            <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-6">Service Reports & Analytics</h2>
            <!-- Services Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <!-- Total Services -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Service</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $summary['total_service'] }}</p>
                            {{-- <p class="text-sm text-yellow-600 mt-1">Amount:
                                {{ number_format($summary['total_amount'], 2) }}</p> --}}
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Services -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Active Service</p>
                            <p class="text-2xl font-bold text-green-600">{{ $summary['active_service'] }}</p>
                            {{-- <p class="text-sm text-green-600 mt-1">Total:
                                {{ number_format($summary['active_amount'], 2) }}</p> --}}
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Inactive Services -->
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Inactive Service</p>
                            <p class="text-2xl font-bold text-red-600">{{ $summary['inactive_service'] }}</p>
                            {{-- <p class="text-sm text-red-600 mt-1">Amount:
                                {{ number_format($summary['inactive_amount'], 2) }}</p> --}}
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('reports.service') }}"
                    class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Service</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Name or Description"
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status"
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                            <option value="">All</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}"
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                        <input type="date"  name="to_date" value="{{ request('to_date') }}"
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="flex-1 text-sm bg-sky-600 hover:bg-sky-500 text-white px-4 py-2 rounded-md transition-colors">Search</button>
                        <a href="{{ route('reports.service') }}"
                            class="px-4 py-2 text-sm bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">Clear</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Services Table -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Service Report</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Showing {{ $services->firstItem() ?? 0 }} to {{ $services->lastItem() ?? 0 }} of
                        {{ $services->total() }} services
                    </p>
                </div>
                <div class="flex space-x-2">
                    <button onclick="printTable()"
                        class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                        <i class="fas fa-print mr-1"></i>Print
                    </button>
                    <button onclick="exportToCSV()"
                        class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                        <i class="fas fa-download mr-1"></i>CSV
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                @if ($services->count())
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                       ID  <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                 
                                     <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                        Name
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category

                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'unit_price', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center hover:text-gray-700">
                                         Unit Price <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($services as $service)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $service->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $service->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $service->category->name ?? '---' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($settings->currency_position == 'left')
                                            {{ $settings->currency ?? '৳' }}
                                            {{ number_format($service->unit_price, 2) }}
                                        @else
                                            {{ number_format($service->unit_price, 2) }}
                                            {{ $settings->currency ?? '৳' }}
                                        @endif
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm {{ $service->status == 'active' ? 'text-green-500' : 'text-red-500' }}">
                                        {{ ucfirst($service->status) }}</td>
                                    <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($service->created_at)->format('d M, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-100 font-bold">
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="px-6 py-4 text-right text-sm text-gray-700">Total</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? '৳' }} {{ number_format($totalPrice, 2) }}
                                    @else
                                        {{ number_format($totalPrice, 2) }} {{ $settings->currency ?? '৳' }}
                                    @endif
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500">No services found.</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        {{-- Showing <span class="font-medium">{{ $services->firstItem() }}</span>
                        to <span class="font-medium">{{ $services->lastItem() }}</span>
                        of <span class="font-medium">{{ $services->total() }}</span> results --}}
                    </div>

                    <!-- Pagination buttons -->
                    <div class="flex space-x-2">
                        <!-- Previous -->
                        @if ($services->onFirstPage())
                            <button class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                disabled>
                                Previous
                            </button>
                        @else
                            <a href="{{ $services->previousPageUrl() }}"
                                class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                Previous
                            </a>
                        @endif

                        <!-- Page numbers -->
                        @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                            @if ($page == $services->currentPage())
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
                        @if ($services->hasMorePages())
                            <a href="{{ $services->nextPageUrl() }}"
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
            link.download = `service-report-${new Date().toISOString().split('T')[0]}.csv`;
            link.click();
        }

        // function printTable() {
        //     const printContent = document.createElement('div');
        //     printContent.className = 'print-content';
        //     const tableClone = document.querySelector('table').cloneNode(true);
        //     tableClone.style.width = '100%';
        //     printContent.appendChild(tableClone);
        //     document.body.appendChild(printContent);
        //     window.print();
        //     document.body.removeChild(printContent);
        // }

        function printTable() {
            const printContent = document.createElement('div');
            printContent.className = 'print-content';

            const header = document.createElement('div');
            header.className = 'print-header';
            header.innerHTML = `
                <h1>Servicea Report</h1>
                <p>Generated on: ${new Date().toLocaleDateString()}</p>
                <p>Total Service: {{ $services->total() }}</p>
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
