<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title & Filters -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Customer Reports & Analytics</h2>
            
            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ url('/customer/reports') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Customer</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Name, email, phone, address, company..."
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
                        <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition-colors">
                            Filter
                        </button>
                        <a href="{{ url('/customer/reports') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
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
                            Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} customers
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="printTable()" class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                            <i class="fas fa-print mr-1"></i>Print
                        </button>
                        <button onclick="exportToCSV()" class="px-3 py-1 bg-gray-800 hover:bg-gray-700 text-white rounded-md text-sm">
                            <i class="fas fa-download mr-1"></i>Export CSV
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                @if($customers->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" 
                                       class="flex items-center hover:text-gray-700">
                                        Customer
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <!-- sort orders count -->
                                     <a href="{{ request()->fullUrlWithQuery(['sort' => 'orders_count', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" 
                                       class="flex items-center hover:text-gray-700">
                                        Total Orders
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Invoices</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <!-- sort total paid amount from invoices -->
                                     <a href="{{ request()->fullUrlWithQuery(['sort' => 'invoices_sum_paid_amount', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" 
                                       class="flex items-center hover:text-gray-700">
                                        Total Paid
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <!-- sort total due amount from invoices -->
                                     <a href="{{ request()->fullUrlWithQuery(['sort' => 'invoices_sum_due_amount', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" 
                                       class="flex items-center hover:text-gray-700">
                                        Total Due
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <!-- sort total amount from invoices -->
                                     <a href="{{ request()->fullUrlWithQuery(['sort' => 'invoices_sum_amount', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" 
                                       class="flex items-center hover:text-gray-700">
                                        Total Amount
                                        <i class="fas fa-sort ml-1 text-xs"></i>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($customers as $customer)
                            <tr class="hover:bg-gray-50">
                                <td>
                                    <div class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                       #{{ $customer->id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="">
                                            <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
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
                                    <div class="text-sm text-green-500">
                                        @if ($settings->currency_position == 'left')
                                            {{ $settings->currency ?? 'Tk' }} {{ number_format($customer->invoices_sum_paid_amount ?? 0, 2) }}
                                        @else
                                            {{ number_format($customer->invoices_sum_paid_amount ?? 0, 2) }} {{ $settings->currency ?? 'Tk' }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-red-500">
                                        @if ($settings->currency_position == 'left')
                                            {{ $settings->currency ?? 'Tk' }} {{ number_format($customer->invoices_sum_due_amount ?? 0, 2) }}
                                        @else
                                            {{ number_format($customer->invoices_sum_due_amount ?? 0, 2) }} {{ $settings->currency ?? 'Tk' }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if ($settings->currency_position == 'left')
                                            {{ $settings->currency ?? 'Tk' }} {{ number_format($customer->invoices_sum_amount ?? 0, 2) }}
                                        @else
                                            {{ number_format($customer->invoices_sum_amount ?? 0, 2) }} {{ $settings->currency ?? 'Tk' }}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-users text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No customers found</h3>
                        <p class="text-gray-500">
                            @if(request()->hasAny(['search', 'from_date', 'to_date']))
                                Try adjusting your search criteria or 
                                <a href="{{ url('/customer/reports') }}" class="text-blue-600 hover:text-blue-700">clear filters</a>.
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
                            Showing <span class="font-medium">{{ $customers->firstItem() }}</span>
                            to <span class="font-medium">{{ $customers->lastItem() }}</span>
                            of <span class="font-medium">{{ $customers->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex space-x-2">
                            <!-- Previous -->
                            @if ($customers->onFirstPage())
                                <button
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
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

    <!-- Print Styles -->
    <style>
        @media print {
            /* Hide everything except the table */
            body * {
                visibility: hidden;
            }
            
            /* Show only the print content */
            .print-content, .print-content * {
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
        
        let csv = [];
        const rows = table.querySelectorAll('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const row = [];
            const cols = rows[i].querySelectorAll('td, th');
            
            for (let j = 0; j < cols.length; j++) {
                let cellText = cols[j].innerText.replace(/"/g, '""');
                if (cellText.includes(',')) {
                    cellText = `"${cellText}"`;
                }
                row.push(cellText);
            }
            csv.push(row.join(','));
        }
        
        const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
        const downloadLink = document.createElement('a');
        downloadLink.download = `customer-report-${new Date().toISOString().split('T')[0]}.csv`;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = 'none';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
    
    function printTable() {
        // Create print content
        const printContent = document.createElement('div');
        printContent.className = 'print-content';
        
        // Add header
        const header = document.createElement('div');
        header.className = 'print-header';
        header.innerHTML = `
            <h1>Customer Report</h1>
            <p>Generated on: ${new Date().toLocaleDateString()}</p>
            <p>Total Customers: {{ $customers->total() }}</p>
        `;
        
        // Clone the table
        const originalTable = document.querySelector('table');
        if (!originalTable) return;
        
        const table = originalTable.cloneNode(true);
        table.className = 'print-table';
        
        // Append to print content
        printContent.appendChild(header);
        printContent.appendChild(table);
        
        // Add to body
        document.body.appendChild(printContent);
        
        // Print
        window.print();
        
        // Remove print content after printing
        setTimeout(() => {
            document.body.removeChild(printContent);
        }, 1000);
    }
    
    function deleteCustomer(customerId) {
        if (confirm('Are you sure you want to delete this customer?')) {
            // Add your delete logic here
            console.log('Delete customer:', customerId);
            // You can make an AJAX request to delete the customer
            // fetch(`/customers/${customerId}`, { method: 'DELETE' })...
        }
    }
    
    // Auto-submit form when date inputs change
    document.addEventListener('DOMContentLoaded', function() {
        const fromDate = document.querySelector('input[name="from_date"]');
        const toDate = document.querySelector('input[name="to_date"]');
        
        if (fromDate && toDate) {
            fromDate.addEventListener('change', function() {
                if (this.value && toDate.value) {
                    this.closest('form').submit();
                }
            });
            
            toDate.addEventListener('change', function() {
                if (this.value && fromDate.value) {
                    this.closest('form').submit();
                }
            });
        }
    });
    </script>
</x-app-layout>