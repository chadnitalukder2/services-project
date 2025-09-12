<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />
            {{-- order table --}}
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Orders List</h3>
                        <div class="flex space-x-2">
                            @can('create orders')
                                <a href="{{ route('orders.create') }}"
                                    class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px"
                                        viewBox="0 0 640 640" fill="white">
                                        <path
                                            d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                                    </svg>
                                    Create Order</a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Delivery Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Amount</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ordersTableBody" class="bg-white divide-y divide-gray-200">
                            @if ($orders->isNotEmpty())
                                @foreach ($orders as $order)
                                    <tr class="border-b" id="order-row-{{ $order->id }}">
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $order->customer->name }}</td>
                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</td>
                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M, Y') }}</td>

                                        </td>
                                        <td class="px-6 py-4 text-left">
                                            <select onchange="updateOrderStatus({{ $order->id }}, this.value)"
                                                data-original-value="{{ $order->status }}"
                                                class="px-10-2 py-1 border rounded text-sm">
                                                <option value="pending"
                                                    @if ($order->status == 'pending') selected @endif>
                                                    Pending</option>
                                                <option value="approved"
                                                    @if ($order->status == 'approved') selected @endif>
                                                    Approved</option>
                                                <option value="done"
                                                    @if ($order->status == 'done') selected @endif>
                                                    Done</option>
                                                <option value="canceled"
                                                    @if ($order->status == 'canceled') selected @endif>
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
                                        <td
                                            class="px-6 py-4 text-left  whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ number_format($order->total_amount, 2) }}
                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>

                                        @canany(['edit orders', 'delete orders'])
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium flex gap-2">
                                                {{--  --}}
                                                @can('view order item')
                                                    <button onclick="showOrderItems({{ $order->id }})"
                                                        class=" text-blue-600 hover:text-blue-900" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                @endcan
                                                @can('edit orders')
                                                    <a href="{{ route('orders.edit', $order->id) }}"
                                                        class="text-yellow-600 hover:text-yellow-900" title="Edit Order">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete orders')
                                                    <a href="javascript:void(0)" onclick="deleteOrder({{ $order->id }})"
                                                        class=" text-red-700 hover:text-red-900" title="Delate Order">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
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
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $orders->firstItem() }}</span>
                            to <span class="font-medium">{{ $orders->lastItem() }}</span>
                            of <span class="font-medium">{{ $orders->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex space-x-2">
                            <!-- Previous -->
                            @if ($orders->onFirstPage())
                                <button
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                    disabled>
                                    Previous
                                </button>
                            @else
                                <a href="{{ $orders->previousPageUrl() }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                    Previous
                                </a>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                @if ($page == $orders->currentPage())
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
                            @if ($orders->hasMorePages())
                                <a href="{{ $orders->nextPageUrl() }}"
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
                        Are you sure you want to delete this order?
                        This will also delete all associated order items and invoices.
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
            //show notification
            // function showNotification(message, type = "success") {
            //     const notification = document.createElement('div');
            //     notification.style.marginTop = "0.5rem";
            //     notification.className = `fixed top-5 right-5 px-4 py-2 rounded shadow text-white z-50 transition-opacity duration-500 ${type === "success" ? "bg-green-500" : "bg-red-500"
    //     }`;
            //     notification.textContent = message;

            //     document.body.appendChild(notification);

            //     setTimeout(() => {
            //         notification.style.opacity = "0";
            //     }, 2000);

            //     setTimeout(() => {
            //         notification.remove();
            //     }, 2500);
            // }

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

            //delete order=========================
            let deleteId = null;

            function deleteOrder(id) {
                deleteId = id;
                // Open your modal via Alpine dispatch
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'confirm-delete'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const confirmBtn = document.getElementById('confirmDeleteBtn');

                confirmBtn.addEventListener('click', function() {
                    if (!deleteId) return;

                    const row = document.getElementById(`order-row-${deleteId}`);
                    if (row) row.style.opacity = '0.5';

                    $.ajax({
                        url: '{{ route('orders.destroy') }}',
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
                                    'Order deleted successfully!', 'success');
                                if (row) {
                                    row.style.transition = 'opacity 0.5s';
                                    row.style.opacity = '0';
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    setTimeout(() => location.reload(), 1000);
                                }
                            } else {
                                showNotification(response.message || 'Order not found!', 'error');
                                if (row) row.style.opacity = '1';
                            }
                        },
                        error: function() {
                            showNotification('An error occurred while deleting the order!',
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

            // function deleteOrder(id) {
            //     if (confirm('Are you sure you want to delete this order?')) {
            //         $.ajax({
            //             url: '{{ route('orders.destroy') }}',
            //             type: 'DELETE',
            //             data: {
            //                 id: id,
            //             },
            //             dataType: 'json',
            //             headers: {
            //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //             },
            //             success: function(response) {
            //                 if (response.status) {
            //                     location.reload();
            //                 } else {
            //                     alert('Order not found');
            //                 }
            //             }
            //         });
            //     }
            // }

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
            });

            //===============updated status=================
            function updateOrderStatus(orderId, status) {
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

                        selectElement.disabled = false;

                        if (response.status || response.success) {
                            showNotification('Status updated successfully', 'success');
                            selectElement.setAttribute('data-original-value', status);
                        } else {
                            showNotification('Error updating status: ' + (response.message || 'Unknown error'),
                                'error');
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

                        showNotification(errorMessage, 'error');

                        selectElement.value = originalValue;
                    }
                });
            }
        </script>
    </x-slot>
</x-app-layout>
