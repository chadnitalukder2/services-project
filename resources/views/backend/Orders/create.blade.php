
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
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <!-- Customer -->
                        <div class="mb-6">
                            <label for="customer_id" class="text-lg font-medium">Customer</label>
                            <div class="my-3">
                                <select id="customer_id" name="customer_id"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select a customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
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
                                <input type="date" id="order_date" name="order_date" value="{{ date('Y-m-d') }}"
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
                                    <option value="pending" selected>Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="done">Done</option>
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
                                    <option value="card">Card</option>
                                    <option value="bkash">bKash</option>
                                    <option value="nagad">Nagad</option>
                                    <option value="rocket">Rocket</option>
                                    <option value="upay">Upay</option>
                                    <option value="cash_on_delivery" selected>Cash on Delivery</option>
                                </select>

                                @error('payment_method')
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
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Service Name</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Unit Price</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Quantity</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Total</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="services_tbody">
                                        <!-- Services will be added here dynamically -->
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="3" class="px-4 py-2 text-right text-lg font-bold">Subtotal:</td>
                                            <td class="px-4 py-2 text-lg font-bold" id="subtotal">$0.00</td>
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
                        <div class="mb-6 border-t pt-6">
                            <h3 class="text-lg font-medium mb-4">Discount & Total Calculation</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Discount Type -->
                                <div>
                                    <label for="discount_type" class="text-md font-medium">Discount Type</label>
                                    <div class="my-2">
                                        <select id="discount_type" name="discount_type"
                                            class="block w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="none">No Discount</option>
                                            <option value="percentage">Percentage (%)</option>
                                            <option value="fixed">Fixed Amount ($)</option>
                                        </select>
                                        @error('discount_type')
                                            <p class="text-red-400 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Discount Value -->
                                <div>
                                    <label for="discount_value" class="text-md font-medium">Discount Value</label>
                                    <div class="my-2">
                                        <input type="number" step="0.01" min="0" id="discount_value" name="discount_value"
                                            class="block w-full border-gray-300 rounded-md shadow-sm" value="0" disabled />
                                        @error('discount_value')
                                            <p class="text-red-400 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Total Calculation Display -->
                            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-right">
                                        <div class="py-1"><strong>Subtotal:</strong></div>
                                        <div class="py-1"><strong>Discount:</strong></div>
                                        <div class="py-1 text-xl border-t border-gray-300"><strong>Total Amount:</strong></div>
                                    </div>
                                    <div>
                                        <div class="py-1" id="display_subtotal">$0.00</div>
                                        <div class="py-1" id="display_discount">$0.00</div>
                                        <div class="py-1 text-xl border-t border-gray-300" id="display_total">$0.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information Section -->
                        <div class="mb-6 border-t pt-6">
                            <h3 class="text-lg font-medium mb-4">Payment Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Paid Amount -->
                                <div>
                                    <label for="paid_amount" class="text-md font-medium">Paid Amount</label>
                                    <div class="my-2">
                                        <input type="number" step="0.01" min="0" id="paid_amount" name="paid_amount"
                                            class="block w-full border-gray-300 rounded-md shadow-sm" value="0" />
                                        @error('paid_amount')
                                            <p class="text-red-400 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Payment Status (Auto-calculated) -->
                                <div>
                                    <label for="payment_status" class="text-md font-medium">Payment Status</label>
                                    <div class="my-2">
                                        <select id="payment_status" name="payment_status"
                                            class="block w-full border-gray-300 rounded-md shadow-sm" disabled>
                                            <option value="unpaid">Unpaid</option>
                                            <option value="partial">Partial</option>
                                            <option value="paid">Paid</option>
                                        </select>
                                        @error('payment_status')
                                            <p class="text-red-400 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Due Amount (Display only) -->
                                <div>
                                    <label class="text-md font-medium">Due Amount</label>
                                    <div class="my-2">
                                        <div class="block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 bg-gray-50" id="due_amount_display">$0.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="text-lg font-medium">Notes</label>
                            <div class="my-3">
                                <textarea id="notes" name="notes" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                    rows="3"></textarea>

                                @error('notes')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden inputs for services and calculations -->
                        <div id="hidden_services"></div>
                        <input type="hidden" id="hidden_due_amount" name="due_amount" value="0">

                        <button type="submit"
                            class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white">
                            Submit Order
                        </button>
                    </form>
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
                document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
                document.getElementById('display_subtotal').textContent = `$${subtotal.toFixed(2)}`;
                document.getElementById('display_discount').textContent = `-$${discountAmount.toFixed(2)}`;
                document.getElementById('display_total').textContent = `$${totalAmount.toFixed(2)}`;

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
                document.getElementById('due_amount_display').textContent = `$${Math.max(0, due).toFixed(2)}`;
                document.getElementById('hidden_due_amount').value = Math.max(0, due).toFixed(2);

                // Update payment status
                if (paid <= 0) {
                    paymentStatus.value = 'unpaid';
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
                        serviceTotal.textContent = `$${(selectedServices[serviceIndex].unit_price * quantity).toFixed(2)}`;

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
                        serviceTotal.textContent = `$${(unitPrice * selectedServices[serviceIndex].quantity).toFixed(2)}`;

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
        });
    </script>
</x-app-layout>