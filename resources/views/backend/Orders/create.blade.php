<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orders/Create
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
                <div class="px-[4rem] py-[3.5rem] text-gray-900">
                    <form id="order-form" method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <!-- Customer -->
                        <div class="mb-6">
                            <label for="customer_id" class="text-base font-medium">Customer</label>
                            <div class="my-3 flex gap-3 items-start">
                                <div class="flex-1">
                                    <select id="customer_id" name="customer_id"
                                        class="block text-sm p-2.5 w-full border-gray-300 rounded-md shadow-sm  focus:border-gray-900 focus:ring-gray-900">
                                        <option value="" class="bg-gray-100">Select a customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    <p id="customer_id" class="text-red-500 text-xs  mt-1 "></p>
                                </div>

                                <button type="button" x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'create-customer')"
                                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-4 py-2.5 text-white whitespace-nowrap flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Customer
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Order Date -->
                            <div class="mb-6">
                                <label for="order_date" class="text-base font-medium">Order Date</label>
                                <div class="my-3">
                                    <input type="date" id="order_date" name="order_date" value="{{ date('Y-m-d') }}"
                                        class="block text-sm  p-2.5 w-full border-gray-300 rounded-md shadow-sm  focus:border-gray-900 focus:ring-gray-900" />
                                </div>
                            </div>

                            <!-- Delivery Date -->
                            <div class="mb-6">
                                <label for="delivery_date" class="text-base font-medium">Delivery Date</label>
                                <div class="my-3">
                                    <input type="date" id="delivery_date" name="delivery_date"
                                        class="block text-sm p-2.5 w-full border-gray-300 rounded-md shadow-sm  focus:border-gray-900 focus:ring-gray-900" />
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Status -->
                            <div class="mb-6">
                                <label for="status" class="text-base font-medium">Status</label>
                                <div class="my-3">
                                    <select id="status" name="status"
                                        class="block text-sm w-full p-2.5 border-gray-300 rounded-md shadow-sm  focus:border-gray-900 focus:ring-gray-900">
                                        <option value="">Select a status</option>
                                        <option value="pending" selected>Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="cancelled">Cancelled</option>
                                        <option value="done">Done</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-6">
                                <label for="payment_method" class="text-base font-medium">Payment Method</label>
                                <div class="my-3">
                                    <select id="payment_method" name="payment_method"
                                        class="block p-2.5 text-sm w-full border-gray-300 rounded-md shadow-sm  focus:border-gray-900 focus:ring-gray-900">
                                        <option value="">Select a payment method</option>
                                        <option value="card">Card</option>
                                        <option value="bkash">bKash</option>
                                        <option value="nagad">Nagad</option>
                                        <option value="rocket">Rocket</option>
                                        <option value="upay">Upay</option>
                                        <option value="cash on delivery" selected>Cash on Delivery</option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-base font-medium mb-4">Event Details</h3>

                            <div id="custom_fields_wrapper" class="space-y-4 ">
                                <!-- Custom fields will be added here dynamically -->
                            </div>

                            <button type="button" id="add_custom_field"
                                class="mt-3 bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-4 py-2 text-white">
                                + Add Event Details
                            </button>
                        </div>

                        <!-- Service Selection -->
                        <div class="mb-6">
                            <label for="service_select" class="text-base font-medium">Add Services</label>
                            <div class="my-3 flex gap-3">
                                <div class="flex-1">
                                    <select id="service_select"
                                        class="block p-2.5 w-full text-sm border-gray-300 rounded-md shadow-sm  focus:border-gray-900 focus:ring-gray-900">
                                        <option value="">Select a service to add</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}" data-name="{{ $service->name }}"
                                                data-unit_price="{{ $service->unit_price }}">
                                                {{ $service->name }} - {{ number_format($service->unit_price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>

                                <button type="button" id="add_service"
                                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-4 py-2 text-white">
                                    Add Service
                                </button>

                            </div>
                            <p id="service-error" class="text-red-500 font-medium text-sm "></p>
                        </div>

                        <!-- Selected Services Table -->
                        <div class="mb-6">
                            {{-- <h3 class="text-base font-medium py-3 text-center border bg-gray-50 border-gray-200">Selected Services</h3> --}}
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200" id="services_table">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3.5 text-left text-base font-medium text-gray-700">
                                                Service
                                                Name</th>
                                            <th class="px-4 py-3.5 text-left text-base font-medium text-gray-700">Unit
                                                Price</th>
                                            <th class="px-4 py-3.5 text-left text-base font-medium text-gray-700">
                                                Quantity
                                            </th>
                                            <th class="px-4 py-3.5 text-left text-base font-medium text-gray-700">Total
                                            </th>
                                            <th class="px-4 py-3.5 text-left text-base font-medium text-gray-700">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="services_tbody">
                                        <!-- Services will be added here dynamically -->
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="3" class="px-4 py-2 text-right text-base font-bold">
                                                Subtotal:</td>
                                            <td class="px-4 py-2 text-base font-bold" id="subtotal">0.00</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="no_services" class="text-gray-500 text-center py-4">
                                No services selected yet.
                            </div>
                        </div>

                        <!-- Discount Section -->
                        <div class="mb-6  pt-6">
                            {{-- <h3 class="text-lg font-medium mb-4">Discount & Total Calculation</h3> --}}

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Discount Type -->
                                <div>
                                    <label for="discount_type" class="text-base font-medium">Discount Type</label>
                                    <div class="my-2">
                                        <select id="discount_type" name="discount_type"
                                            class="block w-full text-sm p-2.5 border-gray-300 rounded-md shadow-sm  focus:border-gray-900 focus:ring-gray-900">
                                            <option value="none">No Discount</option>
                                            <option value="percentage">Percentage (%)</option>
                                            <option value="fixed">Fixed Amount (৳)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Discount Value -->
                                <div>
                                    <label for="discount_value" class="text-base font-medium">Discount Value</label>
                                    <div class="my-2">
                                        <input type="number" step="0.01" min="0" id="discount_value"
                                            name="discount_value"
                                            class="block w-full text-sm p-2.5 border-gray-300 rounded-md shadow-sm  focus:border-gray-900 focus:ring-gray-900"
                                            value="0" disabled />
                                    </div>
                                </div>
                            </div>

                            <!-- Total Calculation Display -->
                            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-right">
                                        <div class="py-1"><strong>Subtotal:</strong></div>
                                        <div class="py-1"><strong>Discount:</strong></div>
                                        <div class="py-1 text-lg border-t border-gray-300"><strong>Total
                                                Amount:</strong></div>
                                    </div>
                                    <div>
                                        <div class="py-1 ml-2.5" id="display_subtotal"> 0.00</div>
                                        <div class="py-1" id="display_discount">0.00</div>
                                        <div class="py-1 ml-2.5 text-lg border-t border-gray-300" id="display_total"> 0.00
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information Section -->
                        <div class="mb-6 pt-6">
                            {{-- <h3 class="text-lg font-medium mb-4">Payment Information</h3> --}}

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Paid Amount -->
                                <div>
                                    <label for="paid_amount" class="text-base font-medium">Paid Amount</label>
                                    <div class="my-2">
                                        <input type="number" step="0.01" min="0" id="paid_amount"
                                            name="paid_amount"
                                            class="block text-sm p-2.5 w-full border-gray-300 rounded-md shadow-sm  focus:border-gray-900 focus:ring-gray-900 "
                                            value="0" />

                                    </div>
                                </div>

                                <!-- Payment Status (Auto-calculated) -->
                                <div style="display: none;">
                                    <label for="payment_status" class="text-base font-medium">Payment Status</label>
                                    <div class="my-2">
                                        <select id="payment_status" name="payment_status"
                                            class="block w-full text-sm p-2.5 border-gray-300 rounded-md shadow-sm bg-gray-50 pointer-events-none  focus:border-gray-900 focus:ring-gray-900">
                                            <option value="due">Due</option>
                                            <option value="partial">Partial</option>
                                            <option value="paid">Paid</option>
                                        </select>

                                    </div>
                                </div>

                                <!-- Due Amount (Display only) -->
                                <div>
                                    <label class="text-base font-medium">Due Amount</label>
                                    <div class="my-2">
                                        <div class="block text-sm p-2.5 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 bg-gray-50"
                                            id="due_amount_display"> 0.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Fields Section -->


                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="text-base font-medium">Notes</label>
                            <div class="my-3">
                                <textarea id="notes" name="notes"
                                    class="block text-sm mt-1 w-full border-gray-300 rounded-md shadow-sm  focus:border-gray-900 focus:ring-gray-900"
                                    rows="6"></textarea>

                                @error('notes')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden inputs for services and calculations -->
                        <div id="hidden_services"></div>
                        <input type="hidden" id="hidden_due_amount" name="due_amount" value="0">

                        <div class="text-right pt-[23px]">
                            <button type="submit"
                                class="bg-gray-800 hover:bg-gray-700 text-base font-medium rounded-md px-11 py-2 text-white">
                                Submit Order
                            </button>
                        </div>

                    </form>
                    <!-- Customer Creation Modal -->
                    <x-modal name="create-customer" :show="false" maxWidth="lg" focusable>
                        <div class="px-6 py-6">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-medium text-gray-900">
                                    Add New Customer
                                </h2>
                                <button type="button" x-on:click="$dispatch('close-modal', 'create-customer')"
                                    class="text-gray-400 hover:text-gray-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <form id="customer-form" class="space-y-4">
                                <div class="grid grid-cols-1 gap-4">
                                    <!-- Name -->
                                    <div>
                                        <label for="customer_name"
                                            class="block text-sm font-medium text-gray-700">Name *</label>
                                        <input type="text" id="customer_name" name="name"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <div id="name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                                    </div>
                                    <!-- Phone -->
                                    <div>
                                        <label for="customer_phone"
                                            class="block text-sm font-medium text-gray-700">Phone *</label>
                                        <input type="tel" id="customer_phone" name="phone"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <div id="phone-error" class="text-red-500 text-sm mt-1 hidden"></div>
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="customer_email"
                                            class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" id="customer_email" name="email"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <div id="email-error" class="text-red-500 text-sm mt-1 hidden"></div>
                                    </div>

                                    <!-- Address -->
                                    <div>
                                        <label for="customer_address"
                                            class="block text-sm font-medium text-gray-700">Address</label>
                                        <textarea id="customer_address" name="address" rows="3"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                        <div id="address-error" class="text-red-500 text-sm mt-1 hidden"></div>
                                    </div>

                                    <!-- Company (Optional) -->
                                    <div>
                                        <label for="customer_company"
                                            class="block text-sm font-medium text-gray-700">Company</label>
                                        <input type="text" id="customer_company" name="company"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <div id="company-error" class="text-red-500 text-sm mt-1 hidden"></div>
                                    </div>
                                </div>

                                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                                    <button type="button" x-on:click="$dispatch('close-modal', 'create-customer')"
                                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition">
                                        Cancel
                                    </button>
                                    <button type="submit" id="save-customer-btn"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                                        <span id="save-customer-text">Save Customer</span>
                                        <span id="save-customer-loading" class="hidden">Saving...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </x-modal>
                </div>
            </div>
        </div>
    </div>

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

            // Discount and payment elements
            const discountType = document.getElementById('discount_type');
            const discountValue = document.getElementById('discount_value');
            const paidAmount = document.getElementById('paid_amount');
            const paymentStatus = document.getElementById('payment_status');

            // Event listeners for discount and payment
            discountType.addEventListener('change', handleDiscountTypeChange);
            discountValue.addEventListener('input', calculateTotals);
            paidAmount.addEventListener('input', calculatePaymentStatus);

            function handleDiscountTypeChange() {
                const discountValueInput = document.getElementById('discount_value');

                if (discountType.value === 'none') {
                    discountValueInput.disabled = true;
                    discountValueInput.value = 0;
                } else {
                    discountValueInput.disabled = false;
                }

                calculateTotals();
            }

            function calculateTotals() {
                const subtotal = selectedServices.reduce((sum, service) => {
                    return sum + (service.unit_price * service.quantity);
                }, 0);

                let discountAmount = 0;
                const discountVal = parseFloat(discountValue.value) || 0;

                if (discountType.value === 'percentage') {
                    discountAmount = (subtotal * discountVal) / 100;
                } else if (discountType.value === 'fixed') {
                    discountAmount = discountVal;
                }

                // Ensure discount doesn't exceed subtotal
                if (discountAmount > subtotal) {
                    discountAmount = subtotal;
                    discountValue.value = discountType.value === 'percentage' ? 100 : subtotal;
                }

                const totalAmount = subtotal - discountAmount;

                // Update displays
                document.getElementById('subtotal').textContent = ` ${subtotal.toFixed(2)}`;
                document.getElementById('display_subtotal').textContent = ` ${subtotal.toFixed(2)}`;
                document.getElementById('display_discount').textContent = `- ${discountAmount.toFixed(2)}`;
                document.getElementById('display_total').textContent = ` ${totalAmount.toFixed(2)}`;
                document.getElementById('paid_amount').value = totalAmount.toFixed(2);


                // Calculate payment status and due amount
                calculatePaymentStatus();

                // Update hidden inputs
                updateHiddenInputs();
            }

            function calculatePaymentStatus() {
                const subtotal = selectedServices.reduce((sum, service) => {
                    return sum + (service.unit_price * service.quantity);
                }, 0);

                let discountAmount = 0;
                const discountVal = parseFloat(discountValue.value) || 0;

                if (discountType.value === 'percentage') {
                    discountAmount = (subtotal * discountVal) / 100;
                } else if (discountType.value === 'fixed') {
                    discountAmount = discountVal;
                }

                if (discountAmount > subtotal) {
                    discountAmount = subtotal;
                }

                const totalAmount = subtotal - discountAmount;
                const paid = parseFloat(paidAmount.value) || 0;
                const due = totalAmount - paid;

                // Update due amount display
                document.getElementById('due_amount_display').textContent = `${Math.max(0, due).toFixed(2)}`;
                document.getElementById('hidden_due_amount').value = Math.max(0, due).toFixed(2);

                // Update payment status
                if (paid <= 0) {
                    paymentStatus.value = 'due';
                } else if (paid >= totalAmount) {
                    paymentStatus.value = 'paid';
                } else {
                    paymentStatus.value = 'partial';
                }
            }

            addServiceBtn.addEventListener('click', function() {
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];

                if (selectedOption.value === '') {
                    alert('Please select a service');
                    return;
                }

                const serviceId = selectedOption.value;
                const serviceName = selectedOption.dataset.name;
                const servicePrice = parseFloat(selectedOption.dataset.unit_price);

                // Check if service already added
                if (selectedServices.find(s => s.id == serviceId)) {
                    alert('This service is already added');
                    return;
                }

                // Add to selected services array
                const service = {
                    id: serviceId,
                    name: serviceName,
                    unit_price: servicePrice,
                    quantity: 1,
                    counter: serviceCounter++
                };
                selectedServices.push(service);

                // Add to table
                addServiceToTable(service);

                // Update totals
                calculateTotals();

                // Show table, hide no services message
                servicesTable.style.display = 'table';
                noServicesDiv.style.display = 'none';

                // Reset select
                serviceSelect.selectedIndex = 0;
            });

            function addServiceToTable(service) {
                const row = document.createElement('tr');
                row.id = `service_row_${service.counter}`;
                row.innerHTML = `
                    <td class="px-4 py-4 text-sm border-b">${service.name}</td>
                    <td class="px-4 py-4  border-b">
                        <input type="number" step="0.01" min="0" 
                               class="w-24 text-sm border-gray-300 rounded-md shadow-sm px-2 py-1 unit-price-input  focus:border-gray-900 focus:ring-gray-900" 
                               data-service-counter="${service.counter}" 
                               value="${service.unit_price}" />
                    </td>
                    <td class="px-4 py-4 border-b">
                        <input type="number" min="1" value="${service.quantity}" 
                               class="w-20 text-sm border-gray-300 px-2 py-1 rounded-md text-center quantity-input  focus:border-gray-900 focus:ring-gray-900" 
                               data-service-counter="${service.counter}">
                    </td>
                    <td class="px-4 py-4 text-sm border-b service-total">${(service.unit_price * service.quantity).toFixed(2)}</td>
                    <td class="px-4 py-4 border-b">
                        <button type="button" class="hover:text-red-500 text-red-600 text-xs px-2 py-1 rounded remove-service" 
                                data-service-counter="${service.counter}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" role="img">
                                <title>Delete</title>
                                <path d="M9 3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h5a1 1 0 1 1 0 2h-1l-1 14a3 3 0 0 1-3 3H8a3 3 0 0 1-3-3L4 5H3a1 1 0 1 1 0-2h6zm2 5a1 1 0 0 0-1 1v7a1 1 0 1 0 2 0V9a1 1 0 0 0-1-1zm4 0a1 1 0 0 0-1 1v7a1 1 0 1 0 2 0V9a1 1 0 0 0-1-1z"/>
                            </svg>
                        </button>
                    </td>
                `;
                servicesTbody.appendChild(row);

                // Add event listeners
                const quantityInput = row.querySelector('.quantity-input');
                quantityInput.addEventListener('input', function() {
                    const counter = parseInt(this.dataset.serviceCounter);
                    const quantity = parseInt(this.value) || 1;

                    // Update service object
                    const serviceIndex = selectedServices.findIndex(s => s.counter === counter);
                    if (serviceIndex !== -1) {
                        selectedServices[serviceIndex].quantity = quantity;

                        // Update row total
                        const serviceTotal = row.querySelector('.service-total');
                        serviceTotal.textContent =
                            `${(selectedServices[serviceIndex].unit_price * quantity).toFixed(2)}`;

                        // Update totals
                        calculateTotals();
                    }
                });

                const unitPriceInput = row.querySelector('.unit-price-input');
                unitPriceInput.addEventListener('input', function() {
                    const counter = parseInt(this.dataset.serviceCounter);
                    const unitPrice = parseFloat(this.value) || 0;

                    const serviceIndex = selectedServices.findIndex(s => s.counter === counter);
                    if (serviceIndex !== -1) {
                        selectedServices[serviceIndex].unit_price = unitPrice;

                        // Update row total
                        const serviceTotal = row.querySelector('.service-total');
                        serviceTotal.textContent =
                            `${(unitPrice * selectedServices[serviceIndex].quantity).toFixed(2)}`;

                        calculateTotals();
                    }
                });

                const removeBtn = row.querySelector('.remove-service');
                removeBtn.addEventListener('click', function() {
                    const counter = parseInt(this.dataset.serviceCounter);
                    removeService(counter);
                });
            }

            function removeService(counter) {
                // Remove from array
                selectedServices = selectedServices.filter(s => s.counter !== counter);

                // Remove from table
                const row = document.getElementById(`service_row_${counter}`);
                if (row) {
                    row.remove();
                }

                // Update totals
                calculateTotals();

                // Show/hide table
                if (selectedServices.length === 0) {
                    servicesTable.style.display = 'none';
                    noServicesDiv.style.display = 'block';
                }
            }

            function updateHiddenInputs() {
                hiddenServicesDiv.innerHTML = '';

                const subtotal = selectedServices.reduce((sum, service) => {
                    return sum + (service.unit_price * service.quantity);
                }, 0);

                let discountAmount = 0;
                const discountVal = parseFloat(discountValue.value) || 0;

                if (discountType.value === 'percentage') {
                    discountAmount = (subtotal * discountVal) / 100;
                } else if (discountType.value === 'fixed') {
                    discountAmount = discountVal;
                }

                if (discountAmount > subtotal) {
                    discountAmount = subtotal;
                }

                const totalAmount = subtotal - discountAmount;

                // Add calculation hidden inputs
                const subtotalInput = document.createElement('input');
                subtotalInput.type = 'hidden';
                subtotalInput.name = 'subtotal';
                subtotalInput.value = subtotal.toFixed(2);
                hiddenServicesDiv.appendChild(subtotalInput);

                const discountAmountInput = document.createElement('input');
                discountAmountInput.type = 'hidden';
                discountAmountInput.name = 'discount_amount';
                discountAmountInput.value = discountAmount.toFixed(2);
                hiddenServicesDiv.appendChild(discountAmountInput);

                const totalAmountInput = document.createElement('input');
                totalAmountInput.type = 'hidden';
                totalAmountInput.name = 'total_amount';
                totalAmountInput.value = totalAmount.toFixed(2);
                hiddenServicesDiv.appendChild(totalAmountInput);

                // Add service-specific hidden inputs
                selectedServices.forEach((service, index) => {
                    const subtotal = service.unit_price * service.quantity;

                    // Service ID
                    const serviceIdInput = document.createElement('input');
                    serviceIdInput.type = 'hidden';
                    serviceIdInput.name = `services[${index}][id]`;
                    serviceIdInput.value = service.id;

                    // Quantity
                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'hidden';
                    quantityInput.name = `services[${index}][quantity]`;
                    quantityInput.value = service.quantity;

                    // Unit Price
                    const unitPriceInput = document.createElement('input');
                    unitPriceInput.type = 'hidden';
                    unitPriceInput.name = `services[${index}][unit_price]`;
                    unitPriceInput.value = service.unit_price.toFixed(2);

                    // Subtotal (unit_price * quantity)
                    const subtotalInput = document.createElement('input');
                    subtotalInput.type = 'hidden';
                    subtotalInput.name = `services[${index}][subtotal]`;
                    subtotalInput.value = subtotal.toFixed(2);

                    // Append all inputs
                    hiddenServicesDiv.appendChild(serviceIdInput);
                    hiddenServicesDiv.appendChild(quantityInput);
                    hiddenServicesDiv.appendChild(unitPriceInput);
                    hiddenServicesDiv.appendChild(subtotalInput);
                });
            }

            // Initially hide the table
            servicesTable.style.display = 'none';

            // Initialize calculations
            calculateTotals();


            // Customer Modal Form Handler
            const customerForm = document.getElementById('customer-form');
            const saveCustomerBtn = document.getElementById('save-customer-btn');
            const saveCustomerText = document.getElementById('save-customer-text');
            const saveCustomerLoading = document.getElementById('save-customer-loading');

            customerForm.addEventListener('submit', function(e) {
                e.preventDefault();
                clearCustomerFormErrors();

                saveCustomerBtn.disabled = true;
                saveCustomerText.classList.add('hidden');
                saveCustomerLoading.classList.remove('hidden');

                const data = {
                    name: customerForm.name.value,
                    email: customerForm.email.value,
                    phone: customerForm.phone.value,
                    address: customerForm.address.value,
                    company: customerForm.company.value
                };

                $.ajax({
                    url: '{{ route('customers.OrderCustomerStore') }}',
                    type: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        saveCustomerBtn.disabled = false;
                        saveCustomerText.classList.remove('hidden');
                        saveCustomerLoading.classList.add('hidden');

                        if (response.status === true) {
                            window.dispatchEvent(new CustomEvent('close-modal', {
                                detail: 'create-customer'
                            }));

                            customerForm.reset();

                            const customerSelect = document.getElementById('customer_id');
                            const option = new Option(response.customer.name, response.customer
                                .id, true, true);
                            customerSelect.appendChild(option);
                            customerSelect.value = response.customer.id;
                        }
                    },
                    error: function(xhr) {
                        saveCustomerBtn.disabled = false;
                        saveCustomerText.classList.remove('hidden');
                        saveCustomerLoading.classList.add('hidden');

                        if (xhr.status === 422) {
                            showCustomerFormErrors(xhr.responseJSON.errors);
                        } else {
                            alert('Something went wrong. Please try again.');
                        }
                    }
                });
            });

            function clearCustomerFormErrors() {
                const errorElements = customerForm.querySelectorAll('.text-red-500');
                errorElements.forEach(el => {
                    el.classList.add('hidden');
                    el.textContent = '';
                });

                const inputElements = customerForm.querySelectorAll('input, textarea');
                inputElements.forEach(el => {
                    el.classList.remove('border-red-500');
                });
            }

            function showCustomerFormErrors(errors) {
                Object.keys(errors).forEach(field => {
                    const errorDiv = document.getElementById(`${field}-error`);
                    const inputElement = document.querySelector(`#customer_${field}`);

                    if (errorDiv) {
                        errorDiv.textContent = errors[field][0];
                        errorDiv.classList.remove('hidden');
                    }

                    if (inputElement) {
                        inputElement.classList.add('border-red-500');
                    }
                });
            }

        });

        //custom file input============================================
        let customFieldCounter = 0;

        document.getElementById('add_custom_field').addEventListener('click', function() {
            const wrapper = document.getElementById('custom_fields_wrapper');

            const fieldHtml = `
                    <div class="flex flex-wrap gap-3 py-3 px-0 rounded-md  relative" id="custom_field_${customFieldCounter}">
                        <div class="w-full md:flex-1">
                            <label class="block text-sm font-medium text-gray-700">Event Name</label>
                            <input type="text" name="custom_fields[${customFieldCounter}][event_name]" 
                                class="mt-1 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900">
                        </div>
                        <div class="w-full md:flex-1">
                            <label class="block text-sm font-medium text-gray-700">Event Date</label>
                            <input type="date" name="custom_fields[${customFieldCounter}][event_date]" 
                                class="mt-1 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900">
                        </div>
                        <div class="w-full md:flex-1">
                            <label class="block text-sm font-medium text-gray-700">Event Time</label>
                            <input type="time" name="custom_fields[${customFieldCounter}][event_time]" 
                                class="mt-1 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900" >
                        </div>
                        <button type="button" onclick="removeCustomField(${customFieldCounter})"
                            class="absolute top-2 right-2 text-red-500 hover:text-red-700">✕</button>
                    </div>
                `;

            wrapper.insertAdjacentHTML('beforeend', fieldHtml);

            customFieldCounter++;
        });

        function removeCustomField(counter) {
            document.getElementById(`custom_field_${counter}`).remove();
        }
        //validation=============================
        document.getElementById('order-form').addEventListener('submit', function(e) {
            let valid = true;

            // Clear previous error highlights
            const errorElements = this.querySelectorAll('.text-red-500');
            errorElements.forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            // 1. Customer validation
            const customer = document.getElementById('customer_id');
            if (customer.value === '') {
                const customerError = document.createElement('p');
                customerError.classList.add('text-red-500', 'text-sm', 'mt-1');
                customerError.textContent = 'Customer is required';
                customer.parentElement.appendChild(customerError);
                valid = false;
            }

            // 2. Order Date validation
            // Order Date
            const orderDate = document.getElementById('order_date');
            if (orderDate.value === '') {
                const orderDateError = document.createElement('p');
                orderDateError.classList.add('text-red-500', 'text-sm', 'mt-1');
                orderDateError.textContent = 'Order Date is required';
                orderDate.parentElement.appendChild(orderDateError);
                valid = false;
            }

            // Delivery Date
            const deliveryDate = document.getElementById('delivery_date');
            if (deliveryDate.value === '') {
                const deliveryDateError = document.createElement('p');
                deliveryDateError.classList.add('text-red-500', 'text-sm', 'mt-1');
                deliveryDateError.textContent = 'Delivery Date is required';
                deliveryDate.parentElement.appendChild(deliveryDateError);
                valid = false;
            } else if (orderDate.value !== '' && new Date(deliveryDate.value) <= new Date(orderDate.value)) {
                const deliveryDateError = document.createElement('p');
                deliveryDateError.classList.add('text-red-500', 'text-sm', 'mt-1');
                deliveryDateError.textContent = 'Delivery Date must be after Order Date';
                deliveryDate.parentElement.appendChild(deliveryDateError);
                valid = false;
            }
            const paymentMethod = document.getElementById('payment_method');
            if (paymentMethod.value === '') {
                const paymentMethodError = document.createElement('p');
                paymentMethodError.classList.add('text-red-500', 'text-sm', 'mt-1');
                paymentMethodError.textContent = 'Payment Method is required';
                paymentMethod.parentElement.appendChild(paymentMethodError);
                valid = false;
            }

            // 4. Services validation (at least one)
            const servicesTbody = document.getElementById('services_tbody');
            const serviceError = document.getElementById('service-error');
            console.log('Number of services:', servicesTbody.children.length);
            if (servicesTbody.children.length === 0) {
                e.preventDefault();
                serviceError.textContent = 'Please add at least one service.';
                serviceError.classList.remove('hidden');
                valid = false;
            } else {
                serviceError.textContent = '';
                serviceError.classList.remove('hidden');
            }

            if (!valid) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    </script>
</x-app-layout>
