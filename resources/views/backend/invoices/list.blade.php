<x-app-layout>
    <x-message />
    <div class="py-8 lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 px-4 lg:px-8">

            <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-6">Invoices Management</h2>

            <!-- Filter Form -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('invoices.index') }}"
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 items-end">

                    <!-- Date From -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">From</label>
                        <input type="text" id="from_date" name="from_date" value="{{ request('from_date') }}" placeholder="dd-mm-yyyy"   autocomplete="off"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-900 focus:border-gray-900">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
                        <input type="text" id="to_date" name="to_date" value="{{ request('to_date') }}" placeholder="dd-mm-yyyy" autocomplete="off"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-900 focus:border-gray-900">
                    </div>

                    <!-- Customer -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                        <select name="customer_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-900 focus:border-gray-900">
                            <option value="">All Customers</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-gray-900 focus:border-gray-900">
                            <option value="">All Status</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial
                            </option>
                            <option value="due" {{ request('status') == 'due' ? 'selected' : '' }}>Due</option>
                        </select>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 w-full">
                        <button type="submit"
                            class="px-4 py-2 flex-1 bg-orange-600 text-white rounded-md text-sm hover:bg-orange-500">
                            Search
                        </button>
                        <a href="{{ route('invoices.index') }}"
                            class="px-4 py-2 flex-1 bg-gray-300 text-gray-700 rounded-md text-sm hover:bg-gray-400 text-center">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            {{-- Invoice table --}}
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Invoice List</h3>
                        <div class="flex space-x-2"></div>
                    </div>
                </div>

                <!-- Responsive Table -->
                <div class="overflow-x-auto custom-scrollbar rounded-lg shadow-sm border scroll-smooth">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                 <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    SI</th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order ID</th>
                                
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
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
                                    Expiry Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceTableBody" class="bg-white divide-y divide-gray-200">
                            @if ($invoices->isNotEmpty())
                            @php
                                $si= $invoices->count();
                            @endphp
                                @foreach ($invoices as $invoice)
                                    <tr class="border-b" id="invoice-row-{{ $invoice->id }}">
                                          <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $si-- }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            #{{ str_pad($invoice->order_id, 4, '0', STR_PAD_LEFT) }}
                                        </td>
                                       
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $invoice->customer->name ?? '---' }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            @if ($settings->currency_position == 'left')
                                                {{ $settings->currency ?? '৳' }}
                                                {{ number_format($invoice->amount, 2) }}
                                            @else
                                                {{ number_format($invoice->amount, 2) }}
                                                {{ $settings->currency ?? '৳' }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-green-700">
                                            @if ($settings->currency_position == 'left')
                                                {{ $settings->currency ?? '৳' }}
                                                {{ number_format($invoice->paid_amount, 2) }}
                                            @else
                                                {{ number_format($invoice->paid_amount, 2) }}
                                                {{ $settings->currency ?? '৳' }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            @if ($settings->currency_position == 'left')
                                                <span
                                                    class="{{ $invoice->due_amount > 0 ? 'text-red-600 font-medium' : 'text-green-600' }}">
                                                    {{ $settings->currency ?? '৳' }}
                                                    {{ number_format($invoice->due_amount, 2) }}
                                                </span>
                                            @else
                                                <span
                                                    class="{{ $invoice->due_amount > 0 ? 'text-red-600 font-medium' : 'text-green-600' }}">
                                                    {{ number_format($invoice->due_amount, 2) }}
                                                    {{ $settings->currency ?? '৳' }}
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full
                                            {{ $invoice->status == 'paid'
                                                ? 'bg-green-100 text-green-800'
                                                : ($invoice->status == 'partial'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            @if ($invoice->expiry_date)
                                                {{ \Carbon\Carbon::parse($invoice->expiry_date)->format('d M, Y') }}
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($invoice->created_at)->format('d M, Y') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium flex gap-5 items-center">
                                            <a href="{{ route('invoices.generate', $invoice->id) }}" target="_blank"
                                                class="hover:text-orange-500 text-orange-600" style="  font-size: 20px" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @can('payment invoices')
                                                @if ($invoice->status !== 'paid' && (floatval($invoice->due_amount) > 0 || $invoice->status === 'due'))
                                                    <button
                                                        onclick="openPaymentModal({
                                                        id: {{ $invoice->id }},
                                                        order_id: '{{ $invoice->order_id }}',
                                                        expiry_date: '{{ $invoice->expiry_date ?? '' }}',
                                                        customer_name: '{{ addslashes($invoice->customer->name ?? 'Unknown') }}',
                                                        customer_id: {{ $invoice->customer->id ?? 0 }},
                                                        amount: {{ floatval($invoice->amount) }},
                                                        paid_amount: {{ floatval($invoice->paid_amount) }},
                                                        due_amount: {{ floatval($invoice->due_amount) }},
                                                        payment_method: '{{ addslashes($invoice->payment_method ?? '') }}',
                                                        status: '{{ $invoice->status }}'
                                                    })"
                                                        class="bg-gray-800 hover:bg-gray-700 py-1.5 px-2.5 text-sm rounded-md text-white">
                                                        Pay
                                                    </button>
                                                @else
                                                    <button
                                                        class="bg-gray-400 text-sm rounded-md py-1.5 px-2.5 text-white cursor-not-allowed"
                                                        disabled title="Invoice is already paid or has no due amount">
                                                        Pay
                                                    </button>
                                                @endif
                                          
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11" class="px-6 py-4 text-center text-gray-500">No invoices found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot class="bg-gray-100">
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-base text-right font-bold text-gray-900">
                                    Totals:</td>
                                <!-- Total Amount -->
                                <td class="px-6 text-sm py-3 text-left font-bold text-gray-900">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? '৳' }} {{ number_format($totalAmount, 2) }}
                                    @else
                                        {{ number_format($totalAmount, 2) }} {{ $settings->currency ?? '৳' }}
                                    @endif
                                </td>
                                <!-- Total Paid -->
                                <td class="px-6 py-3 text-sm text-left font-bold text-green-700">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? '৳' }} {{ number_format($totalPaid, 2) }}
                                    @else
                                        {{ number_format($totalPaid, 2) }} {{ $settings->currency ?? '৳' }}
                                    @endif
                                </td>
                                <!-- Total Due -->
                                <td
                                    class="px-6 py-3 text-sm text-left font-bold {{ $totalDue > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? '৳' }} {{ number_format($totalDue, 2) }}
                                    @else
                                        {{ number_format($totalDue, 2) }} {{ $settings->currency ?? '৳' }}
                                    @endif
                                </td>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $invoices->firstItem() }}</span>
                            to <span class="font-medium">{{ $invoices->lastItem() }}</span>
                            of <span class="font-medium">{{ $invoices->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex flex-wrap gap-2">
                            <!-- Previous -->
                            @if ($invoices->onFirstPage())
                                <button
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                    disabled>
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

            <!-- Confirm Delete Modal -->
            <x-modal name="confirm-delete" class="sm:max-w-sm mt-20" maxWidth="sm" marginTop="20">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Confirm Delete</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to delete this invoice? This action cannot be undone.
                    </p>
                    <div class="mt-4 flex justify-end gap-3">
                        <button type="button" class="px-4 py-1 text-sm bg-gray-200 rounded hover:bg-gray-300"
                            x-on:click="$dispatch('close-modal', 'confirm-delete')">
                            Cancel
                        </button>
                        <button type="button" id="confirmDeleteBtn"
                            class="px-4 py-1 text-sm bg-red-700 text-white rounded hover:bg-red-600">
                            Yes, Delete
                        </button>
                    </div>
                </div>
            </x-modal>
        </div>
    </div>


    <!-- Include Payment Modal Component -->
    <x-payment-modal />

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f0f0f0;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #fff;
            border-radius: 9999px;
            border: 2px solid #f0f0f0;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #fff;
        }
    </style>
    <x-slot name="script">
        <script type="text/javascript">
            //delete Role=========================
            let deleteId = null;

            function deleteInvoice(id) {
                deleteId = id;
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'confirm-delete'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const confirmBtn = document.getElementById('confirmDeleteBtn');

                confirmBtn.addEventListener('click', function() {
                    if (!deleteId) return;

                    const row = document.getElementById(`invoice-row-${deleteId}`);
                    if (row) row.style.opacity = '0.5';

                    $.ajax({
                        url: '{{ route('invoices.destroy') }}',
                        type: 'DELETE',
                        data: {
                            id: deleteId
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                showNotification(response.message ||
                                    'Invoice deleted successfully!', 'success');
                                if (row) {
                                    row.style.transition = 'opacity 0.5s';
                                    row.style.opacity = '0';
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    setTimeout(() => location.reload(), 1000);
                                }
                            } else {
                                showNotification(response.message || 'Invoice not found!', 'error');
                                if (row) row.style.opacity = '1';
                            }
                        },
                        error: function() {
                            showNotification('An error occurred while deleting the invoice!',
                                'error');
                            if (row) row.style.opacity = '1';
                        },
                        complete: function() {
                            window.dispatchEvent(new CustomEvent('close-modal', {
                                detail: 'confirm-delete'
                            }));
                            deleteId = null;
                        }
                    });
                });
            });

            // Datepicker Initialization
            document.addEventListener('DOMContentLoaded', function() {
                flatpickr("#from_date", {
                    dateFormat: "d-m-Y",
                    allowInput: true,
                });
                flatpickr("#to_date", {
                    dateFormat: "d-m-Y",
                    allowInput: true,
                });
            });
        </script>
    </x-slot>
</x-app-layout>
