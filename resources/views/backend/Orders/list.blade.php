<x-app-layout>

    <div class="lg:py-12 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <x-message />

            <!-- Page Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Orders Management</h2>
                <form id="filterForm" method="GET" action="{{ route('orders.index') }}">
                    <!-- Order Statistics -->
                    {{-- <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                                    <p class="text-2xl font-bold text-gray-900" id="totalOrders">
                                        {{ $summary['total_orders'] }}</p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                                    <p class="text-3xl font-bold text-yellow-600" id="pendingOrders">
                                        {{ $summary['pending_orders'] }}</p>
                                </div>
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Completed Orders</p>
                                    <p class="text-3xl font-bold text-green-600" id="completedOrders">
                                        {{ $summary['completed_orders'] }}</p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                                    <p class="text-3xl font-bold text-blue-600" id="totalRevenue">
                                        {{ $summary['total_revenue'] }}</p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-bangladeshi-taka-sign text-blue-600 text-xl"></i>

                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Filters & Search -->
                    <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none text-sm focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        Approved</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                    <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                                <input type="text" id="from_date" name="from_date" value="{{ request('from_date') }}"
                                    autocomplete="off" placeholder="dd-mm-yyyy"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                                <input type="text" id="to_date" name="to_date" value="{{ request('to_date') }}"
                                    autocomplete="off" placeholder="dd-mm-yyyy"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none text-sm focus:ring-1 focus:border-gray-900 focus:ring-gray-900">
                            </div>
                            <div class="flex items-end gap-4 text-center">
                                <button type="submit"
                                    class="w-full bg-orange-600 text-sm hover:bg-orange-500 text-white px-4 py-2 rounded-md  transition-colors"
                                    style="padding-top: 9px; padding-bottom: 9px;">
                                    Search
                                </button>
                                <a href="{{ route('orders.index') }}" style=" padding: 10px;"
                                    class="text-sm px-4  py-2 rounded-md bg-gray-500 hover:bg-gray-600 text-white w-full">
                                    Clear
                                </a>
                            </div>
                        </div>

                    </div>
                </form>

            </div>

            {{-- order table --}}
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Orders List</h3>
                        <div class="flex space-x-2">
                            @can('create orders')
                                <a href="{{ route('orders.create') }}"
                                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                                    <i class="fa-solid fa-plus"></i>
                                    Add Order</a>
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
                                    SI</th>
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
                                @php
                                    $si = $orders->count();
                                @endphp
                                @foreach ($orders as $order)
                                    <tr id="order-row-{{ $order->id }}" class="border-b">
                                        <td
                                            class="px-6 py-4 text-left text-sm font-medium {{ $order->status === 'done' ? 'text-gray-500' : 'text-gray-900' }}">
                                            {{ $si-- }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-left text-sm font-medium {{ $order->status === 'done' ? 'text-gray-500' : 'text-gray-900' }}">
                                            #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-left text-sm font-medium {{ $order->status === 'done' ? 'text-gray-500' : 'text-gray-900' }}">
                                            {{ $order->customer->name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-left whitespace-nowrap text-sm {{ $order->status === 'done' ? 'text-gray-500' : 'text-gray-900' }}">
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-left whitespace-nowrap text-sm {{ $order->status === 'done' ? 'text-gray-500' : 'text-gray-900' }}">
                                            {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-left">
                                            <select
                                                onchange="updateOrderStatus({{ $order->id }}, this.value); changeSelectColor(this);"
                                                data-original-value="{{ $order->status }}" style="padding-right: 35px"
                                                class="px-2 py-1 border rounded text-sm focus:border-gray-900 focus:ring-gray-900 {{ $order->status == 'pending'
                                                    ? 'text-yellow-700'
                                                    : ($order->status == 'approved'
                                                        ? 'text-blue-700'
                                                        : ($order->status == 'done'
                                                            ? 'text-green-700'
                                                            : 'text-red-700')) }}">
                                                <option value="pending"
                                                    @if ($order->status == 'pending') selected @endif>Pending</option>
                                                <option value="approved"
                                                    @if ($order->status == 'approved') selected @endif>Approved</option>
                                                <option value="done"
                                                    @if ($order->status == 'done') selected @endif>Done</option>
                                                <option value="canceled"
                                                    @if ($order->status == 'canceled') selected @endif>Canceled</option>
                                            </select>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-left whitespace-nowrap text-sm font-medium {{ $order->status === 'done' ? 'text-gray-500' : 'text-gray-900' }}">
                                            @if ($settings->currency_position == 'left')
                                                {{ $settings->currency ?? '৳' }}
                                                {{ number_format($order->total_amount, 2) }}
                                            @else
                                                {{ number_format($order->total_amount, 2) }}
                                                {{ $settings->currency ?? '৳' }}
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 text-left whitespace-nowrap text-sm {{ $order->status === 'done' ? 'text-gray-500' : 'text-gray-900' }}">
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 text-center whitespace-nowrap text-base font-medium flex gap-5">
                                            <button onclick="showOrderItems({{ $order->id }})"
                                                class="text-blue-600 hover:text-blue-900" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            @can('edit orders')
                                                <a href="{{ route('orders.edit', $order->id) }}"
                                                    class="text-yellow-500 hover:text-yellow-600" title="Edit Order">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete orders')
                                                <a href="javascript:void(0)" onclick="deleteOrder({{ $order->id }})"
                                                    class="text-red-700 hover:text-red-600" title="Delete Order">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">No orders found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot class="bg-gray-100">
                            <tr>
                                <td colspan="6" class="px-6 text-sm py-3 text-right font-bold text-gray-900">Total
                                    Order
                                    Amount:</td>
                                <td class="px-6 py-3 text-sm text-left font-bold text-gray-900">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? '৳' }} {{ number_format($totalOrderAmount, 2) }}
                                    @else
                                        {{ number_format($totalOrderAmount, 2) }} {{ $settings->currency ?? '৳' }}
                                    @endif
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div
                        class="flex flex-wrap gap-4 justify-center sm:justify-between lg:justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $orders->firstItem() }}</span>
                            to <span class="font-medium">{{ $orders->lastItem() }}</span>
                            of <span class="font-medium">{{ $orders->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex flex-wrap gap-1 space-x-2">
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
                                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase">Service
                                    </th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-500 uppercase">Unit
                                        Price</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium text-gray-500 uppercase">
                                        Quantity</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-500 uppercase">
                                        Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="orderItemsTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Items will be loaded here -->
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 text-sm text-right font-semibold"
                                        style="padding-top: 15px">Subtotal :</td>
                                    <td class="px-4 text-sm text-right font-bold" id="modalSubtotal">0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-4 text-sm text-right font-semibold"
                                        style="padding-top: 2px">Discount :</td>
                                    <td class="px-4 text-sm text-right font-bold" id="modalDiscount">- 0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-4 text-sm text-right font-semibold"
                                        style="padding-top:5px; padding-bottom: 15px">Total Amount:</td>
                                    <td class="px-4  text-right  font-bold text-sm" id="modalTotalAmount">0.00
                                        {{ $settings->currency ?? '৳' }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Custom Fields Section (Event Details Table) -->
                    <div id="customFieldsSection" class="mb-4">
                        <h4 class="font-medium text-gray-900 mb-2 mt-5">Event Details:</h4>
                        <div id="customFieldsContent" class=" rounded-lg">
                            <table id="customFieldsTable"
                                class="min-w-full hidden border border-gray-200 rounded-lg overflow-hidden">
                                <thead class="bg-gradient-to-r bg-gray-50 to-indigo-100">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                            </i>#
                                        </th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                            </i>Event Name
                                        </th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                            Date
                                        </th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                            </i>Time
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="customFieldsTableBody" class="bg-white divide-y divide-gray-100">
                                    <!-- Custom fields will be populated here by JavaScript -->
                                </tbody>
                            </table>
                            <div id="noCustomFields" class="text-center py-6 hidden">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-3">
                                    <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-sm text-gray-500 italic">No event details available</p>
                            </div>
                        </div>
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
                        class="bg-gray-500 hover:bg-gray-600 text-sm text-white px-4 py-2 rounded-md">
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
                "name": {!! json_encode($order->customer->name) !!},
                "phone": {!! json_encode($order->customer->phone) !!},
                "address": {!! json_encode($order->customer->address) !!}
            },
            "order_date": {!! json_encode($order->order_date) !!},
            "delivery_date": {!! json_encode($order->delivery_date) !!},
            "status": {!! json_encode($order->status) !!},
            "total_amount": {!! json_encode($order->total_amount) !!},
            "subtotal": {!! json_encode($order->subtotal) !!},
            "discount_amount": {!! json_encode($order->discount_amount) !!},
            "notes": {!! json_encode($order->notes ?? '') !!},
            "order_items": [
                @foreach ($order->orderItems as $item)
                {
                    "service": {
                        "name": {!! json_encode($item->service->name) !!}
                    },
                    "unit_price": {!! json_encode($item->unit_price) !!},
                    "quantity": {{ $item->quantity }},
                    "subtotal": {!! json_encode($item->subtotal) !!}
                }@if (!$loop->last),@endif
                @endforeach
            ],
            "custom_fields": {!! json_encode($order->custom_fields) !!}
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
                document.getElementById('modalTitle').textContent = `Order #${String(order.id).padStart(4, '0')}`;;
                document.getElementById('modalCustomer').textContent = order.customer.name;
                document.getElementById('modalCustomerPhone').textContent = order.customer.phone;
                document.getElementById('modalCustomerAddress').textContent = order.customer.address;
                document.getElementById('modalOrderDate').textContent = formatDate(order.order_date);
                document.getElementById('modalDeliveryDate').textContent = formatDate(order.delivery_date);
                document.getElementById('modalStatus').textContent = order.status.charAt(0).toUpperCase() + order.status.slice(
                    1);
                //currency
                const currency = "{{ $settings->currency ?? '৳' }}";
                const currencyPosition = "{{ $settings->currency_position ?? 'right' }}"; // left or right
                const totalAmount = parseFloat(order.total_amount).toFixed(2);

                document.getElementById('modalTotalAmount').textContent =
                    currencyPosition === 'left' ?
                    `${currency} ${totalAmount}` :
                    `${totalAmount} ${currency}`;

                //document.getElementById('modalTotalAmount').textContent = `${parseFloat(order.total_amount).toFixed(2)} ৳`;

                document.getElementById('modalSubtotal').textContent = `${parseFloat(order.subtotal).toFixed(2)}`;
                document.getElementById('modalDiscount').textContent = `- ${parseFloat(order.discount_amount).toFixed(2)}`;

                // Populate order items
                const tbody = document.getElementById('orderItemsTableBody');
                tbody.innerHTML = '';

                order.order_items.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-4 text-sm text-gray-900">${item.service.name}</td>
                        <td class="px-4 py-4 text-sm text-gray-900 text-center">${parseFloat(item.unit_price).toFixed(2)}</td>
                        <td class="px-4 py-4 text-sm text-gray-900 text-center">${item.quantity}</td>
                        <td class="px-4 py-4 text-sm text-gray-900 text-right">${parseFloat(item.subtotal).toFixed(2)}</td>
                    `;
                    tbody.appendChild(row);
                });

                // Populate custom fields - TABLE VERSION
                const customFieldsTable = document.getElementById('customFieldsTable');
                const customFieldsTableBody = document.getElementById('customFieldsTableBody');
                const noCustomFields = document.getElementById('noCustomFields');

                // Clear existing content
                customFieldsTableBody.innerHTML = '';

                // Check if custom fields exist and are valid
                if (order.custom_fields && Array.isArray(order.custom_fields) && order.custom_fields.length > 0) {
                    // Show table, hide "no data" message
                    customFieldsTable.classList.remove('hidden');
                    noCustomFields.classList.add('hidden');

                    order.custom_fields.forEach((field, index) => {
                        const row = document.createElement('tr');
                        row.className = 'border';

                        row.innerHTML = `
                    <td class="px-4 py-3 text-sm font-medium  text-gray-900">${index + 1}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">${field.event_name || '-'}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">${field.event_date || '-'}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">${field.event_time || '-'}</td>
                `;

                        customFieldsTableBody.appendChild(row);
                    });
                } else {
                    // Show "no data" message, hide table
                    customFieldsTable.classList.add('hidden');
                    noCustomFields.classList.remove('hidden');
                }
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
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
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

            function changeSelectColor(select) {
                select.classList.remove('text-yellow-700', 'text-blue-700', 'text-green-700', 'text-red-700');
                switch (select.value) {
                    case 'pending':
                        select.classList.add('text-yellow-700');
                        break;
                    case 'approved':
                        select.classList.add('text-blue-700');
                        break;
                    case 'done':
                        select.classList.add('text-green-700');
                        break;
                    case 'canceled':
                        select.classList.add('text-red-700');
                        break;
                }
            }
            //filter==============================================
            document.addEventListener('DOMContentLoaded', function() {
                const filterForm = document.getElementById('filterForm');
                const clearBtn = document.getElementById('clearFilter');

                if (clearBtn) {
                    clearBtn.addEventListener('click', function() {
                        filterForm.reset();
                        filterForm.submit();
                    });
                }
            });

            //datepicker==============================================
            document.addEventListener('DOMContentLoaded', function() {
                const fromDateInput = document.getElementById('from_date');
                const toDateInput = document.getElementById('to_date');
                flatpickr(fromDateInput, {
                    dateFormat: 'd-m-Y',
                    allowInput: true,
                });
                flatpickr(toDateInput, {
                    dateFormat: 'd-m-Y',
                    allowInput: true,
                });
            });
        </script>
    </x-slot>
</x-app-layout>
