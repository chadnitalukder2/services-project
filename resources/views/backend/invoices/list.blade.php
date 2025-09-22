<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Invoices Management</h2>
            {{-- Invoice table --}}
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Invoice List</h3>
                        <div class="flex space-x-2">

                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    # ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order Id</th>
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
                                    Method</th>
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
                                @foreach ($invoices as $invoice)
                                    <tr class="border-b" id="invoice-row-{{ $invoice->id }}">
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            #{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            #{{ str_pad($invoice->order_id, 4, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $invoice->customer->name ?? '---' }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            @if ($settings->currency_position == 'left')
                                                {{ $settings->currency ?? 'Tk' }}
                                                {{ number_format($invoice->amount, 2) }}
                                            @else
                                                {{ number_format($invoice->amount, 2) }}
                                                {{ $settings->currency ?? 'Tk' }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-green-700">
                                            @if ($settings->currency_position == 'left')
                                                {{ $settings->currency ?? 'Tk' }}
                                                {{ number_format($invoice->paid_amount, 2) }}
                                            @else
                                                {{ number_format($invoice->paid_amount, 2) }}
                                                {{ $settings->currency ?? 'Tk' }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            @if ($settings->currency_position == 'left')
                                                <span
                                                    class="{{ $invoice->due_amount > 0 ? 'text-red-600 font-medium' : 'text-green-600' }}">
                                                    {{ $settings->currency ?? 'Tk' }}
                                                    {{ number_format($invoice->due_amount, 2) }}

                                                </span>
                                            @else
                                                <span
                                                    class="{{ $invoice->due_amount > 0 ? 'text-red-600 font-medium' : 'text-green-600' }}">
                                                    {{ number_format($invoice->due_amount, 2) }}
                                                    {{ $settings->currency ?? 'Tk' }}
                                                </span>
                                            @endif

                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900 capitalize">
                                            {{ $invoice->payment_method ?? '---' }}
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
                                            @if($invoice->expiry_date)
                                                {{ \Carbon\Carbon::parse($invoice->expiry_date)->format('d M, Y') }}
                                            @else
                                                ---
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($invoice->created_at)->format('d M, Y') }}</td>


                                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium flex gap-5 "
                                            style="align-items: center">

                                            <a href="{{ route('invoices.generate', $invoice->id) }}" target="_blank"
                                                class="text-yellow-500 hover:text-yellow-600" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>

                                            @can('payment invoices')
                                                @if ($invoice->due_amount > 0)
                                                    <button
                                                        onclick="openPaymentModal({
                                                            id: {{ $invoice->id }},
                                                            order_id: '{{ $invoice->order_id }}',
                                                            expiry_date: '{{ $invoice->expiry_date }}',
                                                            customer_name: '{{ $invoice->customer->name }}',
                                                            customer_id: '{{ $invoice->customer->id }}',
                                                            amount: {{ $invoice->amount }},
                                                            paid_amount: {{ $invoice->paid_amount }},
                                                            due_amount: {{ $invoice->due_amount }},
                                                            payment_method: '{{ $invoice->payment_method }}',
                                                            status: '{{ $invoice->status }}'
                                                        })"
                                                        class="bg-gray-800 hover:bg-gray-700 py-1.5 px-2.5 text-sm rounded-md text-white ">
                                                        Pay
                                                    </button>
                                                @else
                                                    <button
                                                        class="bg-gray-400 text-sm rounded-md py-1.5 px-2.5 text-white cursor-not-allowed"
                                                        disabled>
                                                        Pay
                                                    </button>
                                                @endif
                                            @endcan



                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">No invoices found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot class="bg-gray-100">
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-base  text-right font-bold text-gray-900">
                                    Totals:</td>

                                <!-- Total Amount -->
                                <td class="px-6 text-sm py-3 text-left font-bold text-gray-900">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? 'Tk' }} {{ number_format($totalAmount, 2) }}
                                    @else
                                        {{ number_format($totalAmount, 2) }} {{ $settings->currency ?? 'Tk' }}
                                    @endif
                                </td>

                                <!-- Total Paid -->
                                <td class="px-6 py-3 text-sm text-left font-bold text-green-700">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? 'Tk' }} {{ number_format($totalPaid, 2) }}
                                    @else
                                        {{ number_format($totalPaid, 2) }} {{ $settings->currency ?? 'Tk' }}
                                    @endif
                                </td>

                                <!-- Total Due -->
                                <td
                                    class="px-6 py-3 text-sm text-left font-bold {{ $totalDue > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? 'Tk' }} {{ number_format($totalDue, 2) }}
                                    @else
                                        {{ number_format($totalDue, 2) }} {{ $settings->currency ?? 'Tk' }}
                                    @endif
                                </td>

                                <td colspan="5"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $invoices->firstItem() }}</span>
                            to <span class="font-medium">{{ $invoices->lastItem() }}</span>
                            of <span class="font-medium">{{ $invoices->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex space-x-2">
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

            <!-- Confirm Delete Modal ------------------------>
            <x-modal name="confirm-delete" class="sm:max-w-sm mt-20" maxWidth="sm" marginTop="20">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Confirm Delete</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to delete this invoice?
                        This action cannot be undone.
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
        </script>
    </x-slot>
</x-app-layout>
