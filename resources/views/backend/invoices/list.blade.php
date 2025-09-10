<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoices') }}
            </h2>
            @can('create invoices')
                <a href="{{ route('invoices.create') }}" class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px" viewBox="0 0 640 640" fill="white">
                        <path d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z"/>
                    </svg>
                    Create Invoice
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left " width="60">#</th>
                        <th class="px-6 py-3 text-left">Order Id</th>
                        <th class="px-6 py-3 text-left">Customer Name</th>
                        <th class="px-6 py-3 text-left">Amount</th>
                        <th class="px-6 py-3 text-left">Paid Amount</th>
                        <th class="px-6 py-3 text-left">Due Amount</th>
                        <th class="px-6 py-3 text-left">Payment Status</th>
                        <th class="px-6 py-3 text-left">Payment Method</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        <th class="px-6 py-3 text-center" width="250">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @if ($invoices->isNotEmpty())
                        @foreach ($invoices as $invoice)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left">{{ ($invoices->total() - (($invoices->currentPage() - 1) * $invoices->perPage()) - $loop->index) }}</td>
                                <td class="px-6 py-3 text-left">{{ $invoice->order_id }}</td>
                                <td class="px-6 py-3 text-left">{{ $invoice->customer->name }}</td>
                                <td class="px-6 py-3 text-left">${{ number_format($invoice->amount, 2) }}</td>
                                <td class="px-6 py-3 text-left">${{ number_format($invoice->paid_amount, 2) }}</td>
                                <td class="px-6 py-3 text-left">
                                    <span class="{{ $invoice->due_amount > 0 ? 'text-red-600 font-medium' : 'text-green-600' }}">
                                        ${{ number_format($invoice->due_amount, 2) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-left">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $invoice->status == 'paid' ? 'bg-green-100 text-green-800' : 
                                           ($invoice->status == 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-left capitalize">{{ $invoice->payment_method ?? 'N/A' }}</td>
                                <td class="px-6 py-3 text-left">
                                    {{ \Carbon\Carbon::parse($invoice->created_at)->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex justify-center gap-1">
                                        
                                        @if($invoice->due_amount > 0)
                                            <button onclick="openPaymentModal({
                                                id: {{ $invoice->id }},
                                                order_id: '{{ $invoice->order_id }}',
                                                customer_name: '{{ $invoice->customer->name }}',
                                                customer_id: '{{ $invoice->customer->id }}',
                                                amount: {{ $invoice->amount }},
                                                paid_amount: {{ $invoice->paid_amount }},
                                                due_amount: {{ $invoice->due_amount }},
                                                payment_method: '{{ $invoice->payment_method }}',
                                                status: '{{ $invoice->status }}'
                                            })" 
                                            class="bg-green-600 text-sm rounded-md text-white px-3 py-2 hover:bg-green-700">
                                                Pay
                                            </button>
                                        @endif

                                        @can('delete users')
                                            <a href="javascript:void()" onclick="deleteInvoice({{ $invoice->id }})"
                                                class="bg-red-700 text-sm rounded-md text-white px-3 py-2 hover:bg-red-600">Delete</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10" class="px-6 py-8 text-center text-gray-500">
                                No invoices found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>

    <!-- Include Payment Modal Component -->
    <x-payment-modal />

    <x-slot name="script">
         <script type="text/javascript">
            function deleteInvoice(id) {
                if (confirm('Are you sure you want to delete this invoice?')) {
                    $.ajax({
                        url: '{{ route('invoices.destroy') }}',
                        type: 'DELETE',
                        data: {
                            id: id,
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                location.reload();
                            } else {
                                alert('Invoice not found');
                            }
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>