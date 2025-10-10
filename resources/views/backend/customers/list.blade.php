<x-app-layout>


    <div class="lg:py-12 py-8 ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
            <x-message />
            <h2 class="text-xl lg:text-2xl font-bold text-gray-900 mb-6">Customers Management</h2>

            <!-- Search and Filter Form -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('customers.index') }}" class="flex flex-wrap items-center gap-4">

                    <!-- Search Input -->
                    <div class="w-full sm:flex-1 min-w-[250px] md:min-w-[300px]">
                        <input type="text" name="search" placeholder="Search by name, email, phone, or address..."
                            value="{{ request('search') }}"
                            class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-1 focus:border-gray-900 focus:ring-gray-900 focus:ring-opacity-50">
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="w-full sm:w-auto">
                        <select name="sort"
                            class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm text-sm focus:ring-1 focus:border-gray-900 focus:ring-gray-900 focus:ring-opacity-50">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First
                            </option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First
                            </option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex  sm:flex-row gap-2 w-full sm:w-auto">
                        <button type="submit"
                            class="w-full basis-1/2 sm:w-auto bg-orange-600 text-sm hover:bg-orange-500 text-white px-4 py-2 rounded-md">
                            Search
                        </button>
                        <a href="{{ route('customers.index') }}"
                            class="w-full basis-1/2 sm:w-auto bg-gray-500 text-sm text-white px-4 py-2 rounded-md hover:bg-gray-600 text-center">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            {{-- Customer table --}}
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Customers List</h3>
                        <div class="flex space-x-2">
                            @can('create customers')
                                <button onclick="openCreateCustomerModal()"
                                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                                    <i class="fa-solid fa-plus"></i>
                                    Add Customer</button>
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
                                    # ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Phone</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Address</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Company</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                @canany(['edit customers', 'delete customers'])
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody id="customersTableBody" class="bg-white divide-y divide-gray-200">
                            @if ($customers->isNotEmpty())
                                @foreach ($customers as $customer)
                                    <tr class="border-b" id="customer-row-{{ $customer->id }}">
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $customer->id }}</td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $customer->name }}</td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $customer->phone }}</td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $customer->email ?? '---' }}</td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $customer->address ?? '---' }}</td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $customer->company ?? '---' }}</td>
                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($customer->created_at)->format('d M, Y') }}
                                        </td>
                                        @canany(['edit customers', 'delete customers'])
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium flex gap-4">
                                                @can('edit customers')
                                                    <a href="javascript:void(0)"
                                                        onclick="openEditCustomerModal({{ $customer->id }})"
                                                        class="text-yellow-500 hover:text-yellow-600" title="Edit Customer">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete customers')
                                                    <a href="javascript:void(0)" onclick="deleteCustomer({{ $customer->id }})"
                                                        class="text-red-700 hover:text-red-600" title="Delete Customer">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">No customers found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-wrap gap-4 justify-center sm:justify-between lg:justify-between ">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $customers->firstItem() }}</span>
                            to <span class="font-medium">{{ $customers->lastItem() }}</span>
                            of <span class="font-medium">{{ $customers->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex flex-wrap gap-2">
                            <!-- Previous -->
                            @if ($customers->onFirstPage())
                                <button
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                    disabled>
                                    Previous
                                </button>
                            @else
                                <a href="{{ $customers->previousPageUrl() }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                    Previous
                                </a>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                                @if ($page == $customers->currentPage())
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
                            @if ($customers->hasMorePages())
                                <a href="{{ $customers->nextPageUrl() }}"
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

            <!-- Create customer Modal -->
            <x-modal name="create-customer" class="sm:max-w-md mt-20" maxWidth="2xl">
                <div class="px-6 py-6  md:px-14 md:py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Add New Customer</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'create-customer')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="createCustomerForm" class="space-y-4">
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Name -->
                            <div>
                                <label for="customer_name" class="block text-base font-medium">Name
                                    <span class="text-red-500">*</span></label>
                                <input type="text" id="customer_name" name="name"
                                    class="mt-2 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <div id="name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            <!-- Phone -->
                            <div>
                                <label for="customer_phone" class="block text-base font-medium">Phone
                                    <span class="text-red-500">*</span></label>
                                <input type="number" id="customer_phone" name="phone"
                                    class="mt-2 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <div id="phone-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="customer_email" class="block text-base font-medium">Email</label>
                                <input type="email" id="customer_email" name="email"
                                    class="mt-2 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <div id="email-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="customer_address" class="block text-base font-medium">Address</label>
                                <textarea id="customer_address" name="address" rows="3"
                                    class="mt-2 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900"></textarea>
                                <div id="address-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>

                            <!-- Company -->
                            <div>
                                <label for="customer_company" class="block text-base font-medium">Company</label>
                                <input type="text" id="customer_company" name="company"
                                    class="mt-2 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <div id="company-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-end gap-3 mt-10 pt-4">
                            <button type="button" x-on:click="$dispatch('close-modal', 'create-customer')"
                                class="px-4 py-2 text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition">
                                Cancel
                            </button>
                            <button type="submit" id="save-customer-btn"
                                class="px-4 py-2 text-sm bg-gray-800 hover:bg-gray-700 text-white rounded-md transition">
                                <span id="save-customer-text">Save Customer</span>
                                <span id="save-customer-loading" class="hidden">Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </x-modal>

            <!-- Edit Customer Modal -->
            <x-modal name="edit-customer" class="sm:max-w-md mt-20" maxWidth="2xl">
                <div class="px-6 py-6 md:px-14 md:py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Update Customer</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'edit-customer')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="editCustomerForm" class="space-y-4">
                        <input type="hidden" id="edit_customer_id" name="customer_id">
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Name -->
                            <div>
                                <label for="edit_customer_name" class="block text-base font-medium">Name
                                    <span class="text-red-500">*</span></label>
                                <input type="text" id="edit_customer_name" name="name"
                                    class="mt-2 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <div id="edit-name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            <!-- Phone -->
                            <div>
                                <label for="edit_customer_phone" class="block text-base font-medium">Phone
                                    <span class="text-red-500">*</span></label>
                                <input type="number" id="edit_customer_phone" name="phone"
                                    class="mt-2 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <div id="edit-phone-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            <!-- Email -->
                            <div>
                                <label for="edit_customer_email" class="block text-base font-medium">Email</label>
                                <input type="email" id="edit_customer_email" name="email"
                                    class="mt-2 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <div id="edit-email-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            <!-- Address -->
                            <div>
                                <label for="edit_customer_address" class="block text-base font-medium">Address</label>
                                <textarea id="edit_customer_address" name="address" rows="3"
                                    class="mt-2 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900"></textarea>
                                <div id="edit-address-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            <!-- Company -->
                            <div>
                                <label for="edit_customer_company" class="block text-base font-medium">Company</label>
                                <input type="text" id="edit_customer_company" name="company"
                                    class="mt-2 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <div id="edit-company-error" class="text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-end gap-3 mt-10 pt-4">
                            <button type="button" x-on:click="$dispatch('close-modal', 'edit-customer')"
                                class="px-4 py-2 text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition">
                                Cancel
                            </button>
                            <button type="submit" id="update-customer-btn"
                                class="px-4 py-2 text-sm bg-gray-800 hover:bg-gray-700 text-white rounded-md transition">
                                <span id="update-customer-text">Update Customer</span>
                                <span id="update-customer-loading" class="hidden">Updating...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </x-modal>

            <!-- Confirm Delete Modal -->
            <x-modal name="confirm-delete" class="sm:max-w-sm mt-20" maxWidth="sm" marginTop="20">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Confirm Delete</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to delete this customer? This action cannot be undone.
                    </p>
                    <div class="mt-4 flex flex-wrap justify-end gap-3">
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


    <x-slot name="script">
        <script type="text/javascript">
            function openEditCustomerModal(customerId) {
                const row = document.getElementById(`customer-row-${customerId}`);
                if (!row) return;

                const cells = row.querySelectorAll('td');
                const name = cells[1].textContent.trim();
                const phone = cells[2].textContent.trim();
                const email = cells[3].textContent.trim() === '---' ? '' : cells[3].textContent.trim();
                const address = cells[4].textContent.trim() === '---' ? '' : cells[4].textContent.trim();
                const company = cells[5].textContent.trim() === '---' ? '' : cells[5].textContent.trim();

                document.getElementById('edit_customer_id').value = customerId;
                document.getElementById('edit_customer_name').value = name;
                document.getElementById('edit_customer_phone').value = phone;
                document.getElementById('edit_customer_email').value = email;
                document.getElementById('edit_customer_address').value = address;
                document.getElementById('edit_customer_company').value = company;

                ['edit-name', 'edit-phone', 'edit-email', 'edit-address', 'edit-company'].forEach(id => {
                    document.getElementById(id + '-error').classList.add('hidden');
                    document.getElementById(id + '-error').textContent = '';
                });

                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'edit-customer'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const editForm = document.getElementById('editCustomerForm');
                const updateBtn = document.getElementById('update-customer-btn');
                const updateText = document.getElementById('update-customer-text');
                const updateLoading = document.getElementById('update-customer-loading');

                if (editForm) {
                    editForm.addEventListener('submit', function(e) {
                        e.preventDefault();


                        ['edit-name', 'edit-phone', 'edit-email', 'edit-address', 'edit-company'].forEach(
                            id => {
                                const el = document.getElementById(id + '-error');
                                el.textContent = '';
                                el.classList.add('hidden');
                            });

                        updateBtn.disabled = true;
                        updateText.classList.add('hidden');
                        updateLoading.classList.remove('hidden');

                        const customerId = document.getElementById('edit_customer_id').value;
                        const data = {
                            name: document.getElementById('edit_customer_name').value,
                            phone: document.getElementById('edit_customer_phone').value,
                            email: document.getElementById('edit_customer_email').value,
                            address: document.getElementById('edit_customer_address').value,
                            company: document.getElementById('edit_customer_company').value
                        };

                        $.ajax({
                            url: `/customers/${customerId}`,
                            type: 'POST',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === true) {
                                    showNotification(response.message ||
                                        'Customer updated successfully!', 'success');
                                    window.dispatchEvent(new CustomEvent('close-modal', {
                                        detail: 'edit-customer'
                                    }));
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    showNotification(response.message || 'Error updating customer!',
                                        'error');
                                }
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    const errors = xhr.responseJSON.errors;

                                    // Show validation errors
                                    if (errors.name) {
                                        const nameEl = document.getElementById('edit-name-error');
                                        nameEl.textContent = errors.name[0];
                                        nameEl.classList.remove('hidden');
                                    }
                                    if (errors.phone) {
                                        const phoneEl = document.getElementById('edit-phone-error');
                                        phoneEl.textContent = errors.phone[0];
                                        phoneEl.classList.remove('hidden');
                                    }
                                    if (errors.email) {
                                        const emailEl = document.getElementById('edit-email-error');
                                        emailEl.textContent = errors.email[0];
                                        emailEl.classList.remove('hidden');
                                    }
                                } else {
                                    showNotification(
                                        'An error occurred while updating the customer!',
                                        'error');
                                }
                            },
                            complete: function() {
                                updateBtn.disabled = false;
                                updateText.classList.remove('hidden');
                                updateLoading.classList.add('hidden');
                            }
                        });
                    });
                }
            });
            // Create================

            function openCreateCustomerModal() {
                document.getElementById('createCustomerForm').reset();

                // Hide previous errors
                ['name', 'phone', 'email', 'address', 'company'].forEach(id => {
                    document.getElementById(id + '-error').classList.add('hidden');
                    document.getElementById(id + '-error').textContent = '';
                });

                // Open modal
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'create-customer'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('createCustomerForm');
                const saveBtn = document.getElementById('save-customer-btn');
                const saveText = document.getElementById('save-customer-text');
                const saveLoading = document.getElementById('save-customer-loading');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Clear previous name & phone errors
                    ['name', 'phone'].forEach(id => {
                        const el = document.getElementById(id + '-error');
                        el.textContent = '';
                        el.classList.add('hidden');
                    });

                    saveBtn.disabled = true;
                    saveText.classList.add('hidden');
                    saveLoading.classList.remove('hidden');

                    const data = {
                        name: document.getElementById('customer_name').value,
                        phone: document.getElementById('customer_phone').value,
                        email: document.getElementById('customer_email').value,
                        address: document.getElementById('customer_address').value,
                        company: document.getElementById('customer_company').value
                    };

                    $.ajax({
                        url: '{{ route('customers.store') }}',
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                showNotification(response.message ||
                                    'Customer Save successfully!', 'success');
                                window.dispatchEvent(new CustomEvent('close-modal', {
                                    detail: 'create-customer'
                                }));
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showNotification(response.message || 'Error creating customer!',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;

                                // Only show name and phone errors
                                if (errors.name) {
                                    const nameEl = document.getElementById('name-error');
                                    nameEl.textContent = errors.name[0];
                                    nameEl.classList.remove('hidden');
                                }
                                if (errors.phone) {
                                    const phoneEl = document.getElementById('phone-error');
                                    phoneEl.textContent = errors.phone[0];
                                    phoneEl.classList.remove('hidden');
                                }
                            } else {
                                showNotification('An error occurred while creating the customer!',
                                    'error');
                            }
                        },
                        complete: function() {
                            saveBtn.disabled = false;
                            saveText.classList.remove('hidden');
                            saveLoading.classList.add('hidden');
                        }
                    });
                });
            });


            //delete Customer=========================
            let deleteId = null;

            function deleteCustomer(id) {
                deleteId = id;
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'confirm-delete'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const confirmBtn = document.getElementById('confirmDeleteBtn');

                confirmBtn.addEventListener('click', function() {
                    if (!deleteId) return;

                    const row = document.getElementById(`customer-row-${deleteId}`);
                    if (row) row.style.opacity = '0.5';

                    $.ajax({
                        url: '{{ route('customers.destroy') }}',
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
                                    'Customer deleted successfully!', 'success');
                                if (row) {
                                    row.style.transition = 'opacity 0.5s';
                                    row.style.opacity = '0';
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    setTimeout(() => location.reload(), 1000);
                                }
                            } else {
                                showNotification(response.message || 'Customer not found!',
                                    'error');
                                if (row) row.style.opacity = '1';
                            }
                        },
                        error: function() {
                            showNotification('An error occurred while deleting the customer!',
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
