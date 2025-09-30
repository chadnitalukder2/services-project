<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
    style="display: none;">
    <x-message />
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
                            <span class="text-sm font-medium capitalize" id="modalCustomerName"></span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-600">Current Status:</span>
                            <span class="text-sm font-medium capitalize" id="modalCurrentStatus"></span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-600 capitalize">Current Payment Method:</span>
                            <span class="text-sm font-medium capitalize" id="modalCurrentPaymentMethod"></span>
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
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:border-gray-900 focus:ring-gray-900 focus:border-transparent"
                        placeholder="Enter payment amount">
                    <div class="mt-1">
                        <button type="button" onclick="setFullPayment()"
                            class="text-xs text-blue-600 hover:text-blue-800">
                            Pay Full Due Amount
                        </button>
                    </div>
                    {{-- <div class="mt-2 text-sm text-gray-600">
                        <span id="statusPreview"></span>
                    </div> --}}
                </div>

                <div class="mb-4">
                    <label for="paymentMethod" class="block text-sm font-medium text-gray-700 mb-2">Invoice Expiry
                        Date</label>
                    <input type="date" name="expiry_date" id="ExpiryDate"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:border-gray-900 focus:ring-gray-900 focus:border-transparent">

                </div>

                <div class="mb-4">
                    <label for="paymentMethod" class="block text-sm font-medium text-gray-700 mb-2">Payment
                        Method</label>
                    <select id="paymentMethod" name="payment_method"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:border-gray-900 focus:ring-gray-900 focus:border-transparent"
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
                        class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm rounded-md disabled:opacity-50">
                        Process Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<style>
    body.modal-open {
        overflow: hidden !important;
    }

    /* Check if scrollbar exists and add padding accordingly */
    @media screen {
        body.modal-open {
            padding-right: 17px !important;
        }
    }

    @supports (-webkit-appearance: none) {
        body.modal-open {
            padding-right: 17px !important;
        }
    }

    @-moz-document url-prefix() {
        body.modal-open {
            padding-right: 17px !important;
        }
    }

    #paymentModal {
        transition: all 0.3s ease-in-out;
    }

    #paymentModal>div {
        transition: all 0.3s ease-in-out;
        transform: scale(0.9);
        opacity: 0;
    }

    #paymentModal.show {
        display: block !important;
    }

    #paymentModal.show>div {
        transform: scale(1);
        opacity: 1;
    }
</style>

<script>
    let currentInvoice = null;

    function openPaymentModal(invoice) {
        currentInvoice = invoice;

        function padOrderId(id) {
            return id.toString().padStart(5, '0');
        }

        // Populate modal fields
        document.getElementById('invoiceId').value = invoice.id;
        document.getElementById('modalOrderId').textContent = '#' + padOrderId(invoice.order_id);
        document.getElementById('modalCustomerName').textContent = invoice.customer_name;
        document.getElementById('modalTotalAmount').textContent = parseFloat(invoice.amount).toFixed(2) + '৳';
        document.getElementById('modalPaidAmount').textContent = parseFloat(invoice.paid_amount).toFixed(2) + '৳';
        document.getElementById('modalDueAmount').textContent = parseFloat(invoice.due_amount).toFixed(2) + '৳';

        document.getElementById('modalCurrentStatus').textContent = invoice.status || 'due';
        document.getElementById('modalCurrentPaymentMethod').textContent = invoice.payment_method || 'Not set';

        document.getElementById('ExpiryDate').value = invoice.expiry_date || '';
        if (invoice.expiry_date) {
            const date = new Date(invoice.expiry_date);
            const formattedDate = date.toISOString().split('T')[0]; // YYYY-MM-DD
            document.getElementById('ExpiryDate').value = formattedDate;
        } else {
            document.getElementById('ExpiryDate').value = '';
        }


        if (invoice.payment_method) {
            document.getElementById('paymentMethod').value = invoice.payment_method;
        }
        document.getElementById('paymentAmount').setAttribute('max', invoice.due_amount);

        // Prevent layout shift - Calculate scrollbar width dynamically
        const hasScrollbar = document.body.scrollHeight > window.innerHeight;
        if (hasScrollbar) {
            const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
            document.body.style.paddingRight = scrollbarWidth + 'px';
        }

        // Add modal-open class to prevent scrolling
        document.body.classList.add('modal-open');

        // Show modal with smooth transition
        const modal = document.getElementById('paymentModal');
        modal.style.display = 'block';

        // Trigger animation after a small delay
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);

        // Update status preview initially
        updateStatusPreview();
    }

    function closePaymentModal() {
        const modal = document.getElementById('paymentModal');

        // Start closing animation
        modal.classList.remove('show');

        // Hide modal after animation completes
        setTimeout(() => {
            modal.style.display = 'none';

            // Restore body scroll and remove padding
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = '';

            // Reset form
            document.getElementById('paymentForm').reset();
            document.getElementById('statusPreview').textContent = '';
            currentInvoice = null;
        }, 300);
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

        let newStatus = 'due';
        let statusColor = 'text-red-600';

        if (newDueAmount <= 0) {
            newStatus = 'paid';
            statusColor = 'text-green-600';
        } else if (newPaidAmount > 0) {
            newStatus = 'partial';
            statusColor = 'text-yellow-600';
        }

        document.getElementById('statusPreview').innerHTML =
            `New Status: <span class="font-medium ${statusColor}">${newStatus}</span>`;
    }

    function calculateNewStatus(currentPaidAmount, paymentAmount, totalAmount) {
        const newPaidAmount = currentPaidAmount + paymentAmount;
        const newDueAmount = totalAmount - newPaidAmount;

        if (newDueAmount <= 0) {
            return 'paid';
        } else if (newPaidAmount > 0) {
            return 'partial';
        } else {
            return 'due';
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
                order_id: Number(currentInvoice.order_id),
                customer_id: Number(currentInvoice.customer_id),
                amount: Number(currentInvoice.amount),
                paid_amount: Number(currentPaidAmount + paymentAmount),
                due_amount: Number(totalAmount - (currentPaidAmount + paymentAmount)),
                payment_method: document.getElementById('paymentMethod').value,
                expiry_date: document.getElementById('ExpiryDate').value,
                status: newStatus,
            };

            console.log("Submitting data:", data);

            $.ajax({
                url: '{{ route('invoices.process-payment') }}',
                type: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    showNotification(response.message || 'Payment updated successfully!', 'success');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    showNotification(response.message || 'Order not found!', 'error');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
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

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && document.getElementById('paymentModal').style.display === 'block') {
            closePaymentModal();
        }
    });
</script>
