<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                    Process Payment
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closePaymentModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="paymentForm" method="POST">
                @csrf
                <input type="hidden" id="invoiceId" name="invoice_id">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Invoice Details</label>
                    <div class="bg-gray-50 p-3 rounded-md">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-600">Order ID:</span>
                            <span class="text-sm font-medium" id="modalOrderId"></span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-600">Customer:</span>
                            <span class="text-sm font-medium" id="modalCustomerName"></span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-600">Current Status:</span>
                            <span class="text-sm font-medium" id="modalCurrentStatus"></span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-600">Current Payment Method:</span>
                            <span class="text-sm font-medium" id="modalCurrentPaymentMethod"></span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-600">Total Amount:</span>
                            <span class="text-sm font-medium" id="modalTotalAmount"></span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-600">Paid Amount:</span>
                            <span class="text-sm font-medium" id="modalPaidAmount"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Due Amount:</span>
                            <span class="text-sm font-medium text-red-600" id="modalDueAmount"></span>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="paymentAmount" class="block text-sm font-medium text-gray-700 mb-2">Payment
                        Amount</label>
                    <input type="number" id="paymentAmount" name="payment_amount" step="0.01" min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter payment amount" required>
                    <div class="mt-1">
                        <button type="button" onclick="setFullPayment()"
                            class="text-xs text-blue-600 hover:text-blue-800">
                            Pay Full Due Amount
                        </button>
                    </div>
                    <div class="mt-2 text-sm text-gray-600">
                        <span id="statusPreview"></span>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="paymentMethod" class="block text-sm font-medium text-gray-700 mb-2">Payment
                        Method</label>
                    <select id="paymentMethod" name="payment_method"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                        <option value="">Select Payment Method</option>
                        <option value="card">Card</option>
                        <option value="bkash">bKash</option>
                        <option value="nagad">Nagad</option>
                        <option value="rocket">Rocket</option>
                        <option value="upay">Upay</option>
                        <option value="cash on delivery">Cash on Delivery</option>
                    </select>
                </div>

                <div class="flex items-center justify-end pt-4 border-gray-200 space-x-3">
                    <button type="button" onclick="closePaymentModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 text-sm rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" id="submitPaymentBtn"
                        class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 disabled:opacity-50">
                        Process Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let currentInvoice = null;

    function openPaymentModal(invoice) {
        currentInvoice = invoice;

        // Populate modal fields
        document.getElementById('invoiceId').value = invoice.id;
        document.getElementById('modalOrderId').textContent = invoice.order_id;
        document.getElementById('modalCustomerName').textContent = invoice.customer_name;
        document.getElementById('modalTotalAmount').textContent = '$' + parseFloat(invoice.amount).toFixed(2);
        document.getElementById('modalPaidAmount').textContent = '$' + parseFloat(invoice.paid_amount).toFixed(2);
        document.getElementById('modalDueAmount').textContent = '$' + parseFloat(invoice.due_amount).toFixed(2);

        document.getElementById('modalCurrentStatus').textContent = invoice.status || 'Due';
        document.getElementById('modalCurrentPaymentMethod').textContent = invoice.payment_method || 'Not set';

        if (invoice.payment_method) {
            document.getElementById('paymentMethod').value = invoice.payment_method;
        }
        document.getElementById('paymentAmount').setAttribute('max', invoice.due_amount);

        // Show modal
        document.getElementById('paymentModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Update status preview initially
        updateStatusPreview();
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('paymentForm').reset();
        document.getElementById('statusPreview').textContent = '';
        currentInvoice = null;
    }

    function setFullPayment() {
        if (currentInvoice) {
            document.getElementById('paymentAmount').value = currentInvoice.due_amount;
            updateStatusPreview();
        }
    }

    function updateStatusPreview() {
        if (!currentInvoice) return;

        const paymentAmount = parseFloat(document.getElementById('paymentAmount').value) || 0;
        const currentPaidAmount = parseFloat(currentInvoice.paid_amount) || 0;
        const totalAmount = parseFloat(currentInvoice.amount);

        const newPaidAmount = currentPaidAmount + paymentAmount;
        const newDueAmount = totalAmount - newPaidAmount;

        let newStatus = 'Due';
        let statusColor = 'text-red-600';

        if (newDueAmount <= 0) {
            newStatus = 'Paid';
            statusColor = 'text-green-600';
        } else if (newPaidAmount > 0) {
            newStatus = 'Partial';
            statusColor = 'text-yellow-600';
        }

        document.getElementById('statusPreview').innerHTML =
            `New Status: <span class="font-medium ${statusColor}">${newStatus}</span>`;
    }

    function calculateNewStatus(currentPaidAmount, paymentAmount, totalAmount) {
        const newPaidAmount = currentPaidAmount + paymentAmount;
        const newDueAmount = totalAmount - newPaidAmount;

        if (newDueAmount <= 0) {
            return 'Paid';
        } else if (newPaidAmount > 0) {
            return 'Partial';
        } else {
            return 'Due';
        }
    }

    // Add event listener for payment amount changes
    document.getElementById('paymentAmount').addEventListener('input', updateStatusPreview);

    // Handle form submission
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitPaymentBtn');
            const originalText = submitBtn.textContent;

            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';

            const paymentAmount = parseFloat(document.getElementById('paymentAmount').value) || 0;
            const currentPaidAmount = parseFloat(currentInvoice.paid_amount) || 0;
            const totalAmount = parseFloat(currentInvoice.amount);

            const newStatus = calculateNewStatus(currentPaidAmount, paymentAmount, totalAmount);

            const data = {
                id: currentInvoice.id,
                order_id: currentInvoice.order_id,
                customer_id: currentInvoice.customer_id,
                amount: currentInvoice.amount,
                paid_amount: currentPaidAmount + paymentAmount,
                due_amount: totalAmount - (currentPaidAmount + paymentAmount),
                payment_method: document.getElementById('paymentMethod').value,
                status: newStatus,
            };

            $.ajax({
                url: '{{ route('invoices.process-payment') }}',
                type: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log("Server response:", response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    console.error("Response:", xhr.responseText);
                }
            });
        });
    });



    // Close modal when clicking outside
    document.getElementById('paymentModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePaymentModal();
        }
    });
</script>
