<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orders/Edit
            </h2>
            <a href="{{ route('orders.index') }}"
                class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px" viewBox="0 0 640 640" fill="white">
                    <path
                        d="M73.4 297.4C60.9 309.9 60.9 330.2 73.4 342.7L233.4 502.7C245.9 515.2 266.2 515.2 278.7 502.7C291.2 490.2 291.2 469.9 278.7 457.4L173.3 352L544 352C561.7 352 576 337.7 576 320C576 302.3 561.7 288 544 288L173.3 288L278.7 182.6C291.2 170.1 291.2 149.8 278.7 137.3C266.2 124.8 245.9 124.8 233.4 137.3L73.4 297.3z" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('orders.update', $order->id) }}">
                        @csrf
                        <!-- Customer -->
                        <div class="mb-6">
                            <label for="customer_id" class="text-lg font-medium">Customer</label>
                            <div class="my-3">
                                <select id="customer_id" name="customer_id"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select a customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ $customer->id == $order->customer_id ? 'selected' : '' }}>
                                            {{ $customer->name }}</option>
                                    @endforeach
                                </select>

                                @error('customer_id')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Order Date -->
                        <div class="mb-6">
                            <label for="order_date" class="text-lg font-medium">Order Date</label>
                            <div class="my-3">
                                <input type="date" id="order_date" name="order_date" value="{{ $order->order_date }}"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" />

                                @error('order_date')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Delivery Date -->
                        <div class="mb-6">
                            <label for="delivery_date" class="text-lg font-medium">Delivery Date</label>
                            <div class="my-3">
                                <input type="date" id="delivery_date" name="delivery_date"
                                    value="{{ $order->delivery_date }}"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" />

                                @error('delivery_date')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <label for="status" class="text-lg font-medium">Status</label>
                            <div class="my-3">
                                <select id="status" name="status"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select a status</option>
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>
                                        Approved</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                    <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Done
                                    </option>
                                </select>

                                @error('status')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-6">
                            <label for="payment_method" class="text-lg font-medium">Payment Method</label>
                            <div class="my-3">
                                <select id="payment_method" name="payment_method"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select a payment method</option>
                                    @php $paymentMethod = old('payment_method', optional($order->invoice)->payment_method) @endphp
                                    <option value="card" {{ $paymentMethod == 'card' ? 'selected' : '' }}>Card
                                    </option>
                                    <option value="bkash" {{ $paymentMethod == 'bkash' ? 'selected' : '' }}>bKash
                                    </option>
                                    <option value="nagad" {{ $paymentMethod == 'nagad' ? 'selected' : '' }}>Nagad
                                    </option>
                                    <option value="rocket" {{ $paymentMethod == 'rocket' ? 'selected' : '' }}>Rocket
                                    </option>
                                    <option value="upay" {{ $paymentMethod == 'upay' ? 'selected' : '' }}>Upay
                                    </option>
                                    <option value="cash_on_delivery"
                                        {{ $paymentMethod == 'cash_on_delivery' ? 'selected' : '' }}>Cash on Delivery
                                    </option>
                                </select>

                                @error('payment_method')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- payment status -->
                        <div class="mb-6">
                            <label for="payment_status" class="text-lg font-medium">Payment Status</label>
                            <div class="my-3">
                                <select id="payment_status" name="payment_status"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select a status</option>
                                    @php $paymentStatus = old('payment_status', optional($order->invoice)->status) @endphp
                                    <option value="pending" {{ $paymentStatus == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="partial_paid"
                                        {{ $paymentStatus == 'partial_paid' ? 'selected' : '' }}>Partial Paid</option>
                                    <option value="paid" {{ $paymentStatus == 'paid' ? 'selected' : '' }}>Paid
                                    </option>
                                    <option value="due" {{ $paymentStatus == 'due' ? 'selected' : '' }}>Due</option>
                                    <option value="failed" {{ $paymentStatus == 'failed' ? 'selected' : '' }}>Failed
                                    </option>
                                    <option value="cancelled" {{ $paymentStatus == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                    <option value="refunded" {{ $paymentStatus == 'refunded' ? 'selected' : '' }}>
                                        Refunded</option>
                                </select>

                                @error('payment_status')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Service Selection -->
                        <div class="mb-6">
                            <label for="service_select" class="text-lg font-medium">Add Services</label>
                            <div class="my-3 flex gap-3">
                                <select id="service_select" class="block w-1/3 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select a service to add</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}" data-name="{{ $service->name }}"
                                            data-unit_price="{{ $service->unit_price }}">
                                            {{ $service->name }} - ${{ number_format($service->unit_price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" id="add_service"
                                    class="bg-blue-600 hover:bg-blue-700 text-sm rounded-md px-4 py-2 text-white">
                                    Add Service
                                </button>
                            </div>
                        </div>

                        <!-- Selected Services Table -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-3">Selected Services</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200" id="services_table">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Service
                                                Name</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Unit
                                                Price
                                            </th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Quantity
                                            </th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Total
                                            </th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="services_tbody">
                                        <!-- Services will be added here dynamically -->
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="3" class="px-4 py-2 text-right text-lg font-bold">Total
                                                Amount:</td>
                                            <td class="px-4 py-2 text-lg font-bold" id="grand_total">$0.00</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="no_services" class="text-gray-500 text-center py-4">
                                No services selected yet.
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="text-lg font-medium">Notes</label>
                            <div class="my-3">
                                <textarea id="notes" name="notes" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                    rows="3">{{ old('notes', $order->notes) }}</textarea>

                                @error('notes')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden inputs for services -->
                        <div id="hidden_services"></div>

                        <button type="submit"
                            class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white">
                            Update Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @php
        $existingServicesData = $order->orderItems->map(function($item) {
            return [
                'id' => $item->service_id,
                'name' => optional($item->service)->name ?? '',
                'unit_price' => $item->unit_price,
                'quantity' => $item->quantity,
                'subtotal' => $item->subtotal,
            ];
        });
    @endphp

<script>
    let selectedServices = [];
    let serviceCounter = 0;

    document.addEventListener('DOMContentLoaded', function() {
        const addServiceBtn = document.getElementById('add_service');
        const serviceSelect = document.getElementById('service_select');
        const servicesTable = document.getElementById('services_table');
        const servicesTbody = document.getElementById('services_tbody');
        const noServicesDiv = document.getElementById('no_services');
        const hiddenServicesDiv = document.getElementById('hidden_services');

        // --- Preload existing services ---
        let existingServices = @json($existingServicesData);

        existingServices.forEach(item => {
            const service = {
                id: item.id,
                name: item.name,
                unit_price: parseFloat(item.unit_price),
                quantity: parseInt(item.quantity),
                counter: serviceCounter++
            };
            selectedServices.push(service);
            addServiceToTable(service);
        });

        if(selectedServices.length > 0) {
            servicesTable.style.display = 'table';
            noServicesDiv.style.display = 'none';
            updateTotal();
            updateHiddenInputs();
        }

        // --- Add new service ---
        addServiceBtn.addEventListener('click', function() {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            if (selectedOption.value === '') {
                alert('Please select a service');
                return;
            }

            const serviceId = selectedOption.value;
            const serviceName = selectedOption.dataset.name;
            const servicePrice = parseFloat(selectedOption.dataset.unit_price);

            if (selectedServices.find(s => s.id == serviceId)) {
                alert('This service is already added');
                return;
            }

            const service = {
                id: serviceId,
                name: serviceName,
                unit_price: servicePrice,
                quantity: 1,
                counter: serviceCounter++
            };
            selectedServices.push(service);
            addServiceToTable(service);
            updateTotal();
            updateHiddenInputs();
            servicesTable.style.display = 'table';
            noServicesDiv.style.display = 'none';
            serviceSelect.selectedIndex = 0;
        });

        // --- Add service to table function ---
        function addServiceToTable(service) {
            const row = document.createElement('tr');
            row.id = `service_row_${service.counter}`;
            row.innerHTML = `
                <td class="px-4 py-2 border-b">${service.name}</td>
                <td class="px-4 py-2 border-b">
                    <input type="number" step="0.01" min="0" 
                           class="w-24 border-gray-300 rounded-md shadow-sm px-2 py-1 unit-price-input" 
                           data-service-counter="${service.counter}" 
                           value="${service.unit_price}" />
                </td>
                <td class="px-4 py-2 border-b">
                    <input type="number" min="1" value="${service.quantity}" 
                           class="w-20 border-gray-300 rounded-md text-center quantity-input" 
                           data-service-counter="${service.counter}">
                </td>
                <td class="px-4 py-2 border-b service-total">$${(service.unit_price * service.quantity).toFixed(2)}</td>
                <td class="px-4 py-2 border-b">
                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded remove-service" 
                            data-service-counter="${service.counter}">
                        Remove
                    </button>
                </td>
            `;
            servicesTbody.appendChild(row);

            // Quantity change
            row.querySelector('.quantity-input').addEventListener('input', function() {
                const counter = parseInt(this.dataset.serviceCounter);
                const quantity = parseInt(this.value) || 1;
                const serviceIndex = selectedServices.findIndex(s => s.counter === counter);
                if (serviceIndex !== -1) {
                    selectedServices[serviceIndex].quantity = quantity;
                    row.querySelector('.service-total').textContent = 
                        `$${(selectedServices[serviceIndex].unit_price * quantity).toFixed(2)}`;
                    updateTotal();
                    updateHiddenInputs();
                }
            });

            // Unit price change
            row.querySelector('.unit-price-input').addEventListener('input', function() {
                const counter = parseInt(this.dataset.serviceCounter);
                const unitPrice = parseFloat(this.value) || 0;
                const serviceIndex = selectedServices.findIndex(s => s.counter === counter);
                if (serviceIndex !== -1) {
                    selectedServices[serviceIndex].unit_price = unitPrice;
                    row.querySelector('.service-total').textContent = 
                        `$${(unitPrice * selectedServices[serviceIndex].quantity).toFixed(2)}`;
                    updateTotal();
                    updateHiddenInputs();
                }
            });

            // Remove service
            row.querySelector('.remove-service').addEventListener('click', function() {
                removeService(parseInt(this.dataset.serviceCounter));
            });
        }

        function removeService(counter) {
            selectedServices = selectedServices.filter(s => s.counter !== counter);
            const row = document.getElementById(`service_row_${counter}`);
            if (row) row.remove();
            updateTotal();
            updateHiddenInputs();
            if (selectedServices.length === 0) {
                servicesTable.style.display = 'none';
                noServicesDiv.style.display = 'block';
            }
        }

        function updateTotal() {
            const total = selectedServices.reduce((sum, s) => sum + (s.unit_price * s.quantity), 0);
            document.getElementById('grand_total').textContent = `$${total.toFixed(2)}`;
        }

        function updateHiddenInputs() {
            hiddenServicesDiv.innerHTML = '';
            const totalAmount = selectedServices.reduce((sum, s) => sum + (s.unit_price * s.quantity), 0);
            const totalAmountInput = document.createElement('input');
            totalAmountInput.type = 'hidden';
            totalAmountInput.name = 'total_amount';
            totalAmountInput.value = totalAmount.toFixed(2);
            hiddenServicesDiv.appendChild(totalAmountInput);

            selectedServices.forEach((service, index) => {
                const subtotal = service.unit_price * service.quantity;

                ['id','quantity','unit_price','subtotal'].forEach(field => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `services[${index}][${field}]`;
                    input.value = field === 'id' ? service.id :
                                  field === 'quantity' ? service.quantity :
                                  field === 'unit_price' ? service.unit_price.toFixed(2) :
                                  subtotal.toFixed(2);
                    hiddenServicesDiv.appendChild(input);
                });
            });
        }

        if(selectedServices.length === 0) servicesTable.style.display = 'none';
    });
</script>

</x-app-layout>