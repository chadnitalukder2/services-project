<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Orders') }}
            </h2>
            @can('create orders')
                <a href="{{ route('orders.create') }}"
                    class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px" viewBox="0 0 640 640" fill="white">
                        <path
                            d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                    </svg>
                    Create Order</a>
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
                        <th class="px-6 py-3 text-left">Customer name</th>
                        <th class="px-6 py-3 text-left">Order Date</th>
                        <th class="px-6 py-3 text-left">Delivery Date</th>
                        <th class="px-6 py-3 text-left">Total Amount</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        @canany(['edit orders', 'delete orders'])
                            <th class="px-6 py-3 text-center" width="250">Actions</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @if ($orders->isNotEmpty())
                        @foreach ($orders as $order)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left">
                                    {{ $orders->total() - ($orders->currentPage() - 1) * $orders->perPage() - $loop->index }}
                                </td>
                                <td class="px-6 py-3 text-left">{{ $order->customer->name }}</td>
                                <td class="px-6 py-3 text-left">
                                    {{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</td>
                                <td class="px-6 py-3 text-left">
                                    {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M, Y') }}</td>
                                <td class="px-6 py-3 text-left">{{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-3 text-left">
                                    <select onchange="updateOrderStatus({{ $order->id }}, this.value)"
                                        data-original-value="{{ $order->status }}"
                                        class="px-10-2 py-1 border rounded text-sm">
                                        <option value="pending" @if ($order->status == 'pending') selected @endif>
                                            Pending</option>
                                        <option value="approved" @if ($order->status == 'approved') selected @endif>
                                            Approved</option>
                                        <option value="done" @if ($order->status == 'done') selected @endif>
                                            Done</option>
                                        <option value="canceled" @if ($order->status == 'canceled') selected @endif>
                                            Canceled</option>
                                    </select>
                                    {{-- <span
                                        class="px-2 py-1 text-xs rounded-full 
                                        @if ($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'approved') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'done') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span> --}}
                                </td>
                                <td class="px-6 py-3 text-left">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>

                                @canany(['edit orders', 'delete orders'])
                                    <td class="px-6 py-3 text-center">
                                        {{--  --}}
                                        @can('view order item')
                                            <button onclick="showOrderItems({{ $order->id }})"
                                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-2 rounded">
                                                View
                                            </button>
                                        @endcan
                                        @can('edit orders')
                                            <a href="{{ route('orders.edit', $order->id) }}"
                                                class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md text-white px-3 py-2">Edit</a>
                                        @endcan
                                        @can('delete orders')
                                            <a href="javascript:void(0)" onclick="deleteOrder({{ $order->id }})"
                                                class="bg-red-700 text-sm rounded-md text-white px-3 py-2 hover:bg-red-600">Delete</a>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-gray-500">No orders found</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <!-- Order Items Modal -->
    <div id="orderItemsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-6xl w-full max-h-100 overflow-hidden">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Order Items</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4 max-h-80 overflow-y-auto">
                    <!-- Order Info -->
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                        <div class="grid grid-cols-2 md:grid-cols-6 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-600">Name:</span>
                                <p id="modalCustomer" class="text-gray-900"></p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Phone:</span>
                                <p id="modalCustomerPhone" class="text-gray-900"></p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Address:</span>
                                <p id="modalCustomerAddress" class="text-gray-900"></p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Order Date:</span>
                                <p id="modalOrderDate" class="text-gray-900"></p>
                            </div>

                            <div>
                                <span class="font-medium text-gray-600">Delivery Date:</span>
                                <p id="modalDeliveryDate" class="text-gray-900"></p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Status:</span>
                                <p id="modalStatus" class="text-gray-900"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Table -->
                    <div id="orderItemsContent">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Service
                                    </th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Unit
                                        Price</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">
                                        Quantity</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">
                                        Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="orderItemsTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Items will be loaded here -->
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right font-semibold">Discount :</td>
                                    <td class="px-4 py-3 text-right font-bold text-lg" id="modalDiscount">- 0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right font-semibold">Total Amount:</td>
                                    <td class="px-4 py-3 text-right font-bold text-lg" id="modalTotalAmount">0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Notes Section -->
                    <div id="notesSection" class="mt-4 hidden">
                        <h4 class="font-medium text-gray-900 mb-2">Notes:</h4>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p id="modalNotes" class="text-gray-700 text-sm"></p>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <button onclick="closeModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden order data for JavaScript -->
    @foreach ($orders as $order)
        <script type="application/json" id="order-data-{{ $order->id }}">
        {
            "id": {{ $order->id }},
         "customer": {
                "name": "{{ $order->customer->name }}",
                "phone": "{{ $order->customer->phone }}",
                "address": "{{ $order->customer->address }}"
            },
            "order_date": "{{ $order->order_date }}",
            "delivery_date": "{{ $order->delivery_date }}",
            "status": "{{ $order->status }}",
            "total_amount": "{{ $order->total_amount }}",
            "discount_amount": "{{ $order->discount_amount }}",
            "notes": "{{ $order->notes ?? '' }}",
            "order_items": [
                @foreach ($order->orderItems as $item)
                {
                    "service": {
                        "name": "{{ $item->service->name }}"
                    },
                    "unit_price": "{{ $item->unit_price }}",
                    "quantity": {{ $item->quantity }},
                    "subtotal": "{{ $item->subtotal }}"
                }@if (!$loop->last),@endif
                @endforeach
            ]
        }
    </script>
    @endforeach

    <x-slot name="script">
        <script type="text/javascript">
            function showOrderItems(orderId) {
                // Show modal
                document.getElementById('orderItemsModal').classList.remove('hidden');

                // Get order data from the hidden JSON script
                const orderDataScript = document.getElementById(`order-data-${orderId}`);
                if (!orderDataScript) {
                    alert('Order data not found');
                    closeModal();
                    return;
                }

                try {
                    const orderData = JSON.parse(orderDataScript.textContent);
                    populateModal(orderData);
                } catch (error) {
                    console.error('Error parsing order data:', error);
                    alert('Failed to load order items');
                    closeModal();
                }
            }

            function populateModal(order) {
                // Update modal title and order info
                document.getElementById('modalTitle').textContent = `Order #${order.id} Items`;
                document.getElementById('modalCustomer').textContent = order.customer.name;
                document.getElementById('modalCustomerPhone').textContent = order.customer.phone;
                document.getElementById('modalCustomerAddress').textContent = order.customer.address;
                document.getElementById('modalOrderDate').textContent = formatDate(order.order_date);
                document.getElementById('modalDeliveryDate').textContent = formatDate(order.delivery_date);
                document.getElementById('modalStatus').textContent = order.status.charAt(0).toUpperCase() + order.status.slice(
                    1);
                document.getElementById('modalTotalAmount').textContent = `${parseFloat(order.total_amount).toFixed(2)}`;
                document.getElementById('modalDiscount').textContent = `- ${parseFloat(order.discount_amount).toFixed(2)}`;

                // Populate order items
                const tbody = document.getElementById('orderItemsTableBody');
                tbody.innerHTML = '';

                order.order_items.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-3 text-sm text-gray-900">${item.service.name}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 text-right">${parseFloat(item.unit_price).toFixed(2)}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 text-center">${item.quantity}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 text-right">${parseFloat(item.subtotal).toFixed(2)}</td>
                    `;
                    tbody.appendChild(row);
                });

                // Show/hide notes section
                if (order.notes && order.notes.trim() !== '') {
                    document.getElementById('modalNotes').textContent = order.notes;
                    document.getElementById('notesSection').classList.remove('hidden');
                } else {
                    document.getElementById('notesSection').classList.add('hidden');
                }
            }

            function closeModal() {
                document.getElementById('orderItemsModal').classList.add('hidden');
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            }

            function deleteOrder(id) {
                if (confirm('Are you sure you want to delete this order?')) {
                    $.ajax({
                        url: '{{ url('orders.destroy') }}/' + id,
                        type: 'DELETE',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                location.reload();
                            } else {
                                alert('Order not found');
                            }
                        }
                    });
                }
            }

            // Close modal when clicking outside
            document.getElementById('orderItemsModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }

                function updateOrderStatus(orderId, status) {
                    console.log('Updating order status:', orderId, status);

                    // Show loading state (optional)
                    const selectElement = event.target;
                    const originalValue = selectElement.getAttribute('data-original-value') || selectElement.value;
                    selectElement.disabled = true;

                    $.ajax({
                        url: `/orders/${orderId}/update-status`,
                        type: 'PATCH',
                        data: {
                            status: status,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            // Re-enable the select
                            selectElement.disabled = false;

                            if (response.status || response.success) {
                                alert('Status updated successfully');
                                selectElement.setAttribute('data-original-value', status);
                            } else {
                                alert('Error updating status: ' + (response.message || 'Unknown error'));
                                selectElement.value = originalValue;
                            }
                        },
                        error: function(xhr, status, error) {
                            selectElement.disabled = false;

                            console.error('Error updating status:', xhr.responseText);

                            let errorMessage = 'Error updating status';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            alert(errorMessage);

                            selectElement.value = originalValue;
                        }
                    });
                }
            });
        </script>
    </x-slot>
</x-app-layout>
