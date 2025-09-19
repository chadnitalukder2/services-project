<x-app-layout>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Services Management</h2>

            <!-- Search and Filter Form -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('services.index') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">

                    <!-- Service Name Search -->
                    <div class="">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search
                            Service</label>
                        <input type="text" name="search" id="search" placeholder="Search by name..."
                            value="{{ request('search') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- CategorySearch -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" id="category_id"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">All Categories</option>
                            @foreach ($serviceCategories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range - Min -->
                    <div>
                        <label for="price_min" class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                        <input type="number" name="price_min" id="price_min" placeholder="0.00" step="0.01"
                            min="0" value="{{ request('price_min') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Price Range - Max -->
                    <div>
                        <label for="price_max" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                        <input type="number" name="price_max" id="price_max" placeholder="1000.00" step="0.01"
                            min="0" value="{{ request('price_max') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Sort Dropdown -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select name="sort" id="sort"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First
                            </option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First
                            </option>
                            <option value="active" {{ request('sort') == 'active' ? 'selected' : '' }}>Active Services
                            </option>
                            <option value="inactive" {{ request('sort') == 'inactive' ? 'selected' : '' }}>Inactive
                                Services</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="gap-2" style="display: block; margin:0 auto; margin-top: 24px;">
                        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                            Search
                        </button>
                        <a href="{{ route('services.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"
                            style="padding: 10px 18px;">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            {{-- service table --}}
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Service List</h3>
                        <div class="flex space-x-2">
                            @can('create services')
                                <button onclick="openCreateServiceModal()"
                                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                                    <i class="fa-solid fa-plus"></i>
                                    Create Service</button>
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
                                    Service Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                @canany(['edit services', 'delete services'])
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                @endcanany

                            </tr>
                        </thead>
                        <tbody id="servicesTableBody" class="bg-white divide-y divide-gray-200">
                            @if ($services->isNotEmpty())
                                @foreach ($services as $service)
                                    <td class="hidden" id="service-description-{{ $service->id }}">
                                        {{ $service->description }}
                                    </td>
                                    <tr class="border-b" id="service-row-{{ $service->id }}">

                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $service->id }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $service->name }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $service->category->name }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            @if ($settings->currency_position == 'left')
                                               {{ $settings->currency ?? 'Tk' }} {{ number_format($service->unit_price, 2) }} 
                                            @else
                                               {{ number_format($service->unit_price, 2) }} {{ $settings->currency ?? 'Tk' }}
                                            @endif
                                          
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            @if ($service->status == 'active')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($service->created_at)->format('d M, Y') }}</td>

                                        @canany(['edit services', 'delete services'])
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium flex gap-6">
                                                @can('edit services')
                                                    <a href="javascript:void(0)"
                                                        onclick="openEditServiceModal({{ $service->id }})"
                                                        class="text-yellow-500 hover:text-yellow-600" title="Edit service">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete services')
                                                    <a href="javascript:void(0)" onclick="deleteService({{ $service->id }})"
                                                        class=" text-red-700 hover:text-red-600" title="Delate service">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">No services found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $services->firstItem() }}</span>
                            to <span class="font-medium">{{ $services->lastItem() }}</span>
                            of <span class="font-medium">{{ $services->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex space-x-2">
                            <!-- Previous -->
                            @if ($services->onFirstPage())
                                <button
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                    disabled>
                                    Previous
                                </button>
                            @else
                                <a href="{{ $services->previousPageUrl() }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                    Previous
                                </a>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                                @if ($page == $services->currentPage())
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
                            @if ($services->hasMorePages())
                                <a href="{{ $services->nextPageUrl() }}"
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

            <!-- Create Service Modal -->
            <x-modal name="create-service" class="sm:max-w-md mt-20" maxWidth="2xl">
                <div class="px-14 py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Create New Service</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'create-service')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="createServiceForm" class="space-y-4">

                        <!-- Name -->
                        <div class="mt-6">
                            <label for="modal_name" class="block text-base font-medium">Service Name
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="modal_name" name="name"
                                class="mt-3 text-sm  block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                            <div id="modal_name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label for="modal_category_id"
                                class="block text-base font-medium mt-6">Category <span
                                    class="text-red-500">*</span></label>
                            <select id="modal_category_id" name="category_id"
                                class="mt-3 text-sm  block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <option value="">Select Category</option>
                                @foreach ($serviceCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div id="modal_category-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="modal_price" class="block text-base font-medium mt-6">Price
                                <span class="text-red-500">*</span></label>
                            <input type="number" id="modal_price" name="unit_price"
                                class="mt-3 text-sm  block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                            <div id="modal_price-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="modal_status" class="block text-base font-medium mt-6">Status
                                <span class="text-red-500">*</span></label>
                            <select id="modal_status" name="status"
                                class="block text-sm  mt-1 w-full border-gray-300 rounded-md shadow-sm  focus:border-gray-900 focus:ring-gray-900">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                            <div id="modal_date-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="modal_description"
                                class="block text-base font-medium mt-6">Description</label>
                            <textarea id="modal_description" name="description" rows="5"
                                class="mt-3 text-sm  block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900"></textarea>
                            <div id="modal_description-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div class="flex justify-end gap-3 mt-6 pt-4">
                            <button type="button" x-on:click="$dispatch('close-modal', 'create-service')"
                                class="px-4 py-2 text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">
                                Cancel
                            </button>
                            <button type="submit" id="save-service-btn"
                                class="px-4 py-2 text-sm bg-gray-800 hover:bg-gray-700 text-white rounded-md">
                                <span id="save-service-text">Save service</span>
                                <span id="save-service-loading" class="hidden">Saving...</span>
                            </button>
                        </div>
                    </form>


                </div>
            </x-modal>

            <!-- Edit Service Modal -->
            <x-modal name="edit-service" class="sm:max-w-md mt-20" maxWidth="2xl">
                <div class="px-14 py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Edit Service</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'edit-service')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="editServiceForm" class="space-y-4">
                        <input type="hidden" id="edit_service_id">

                        <!-- Name -->
                        <div>
                            <label for="edit_name" class="block text-base font-medium mt-6">
                                Service Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_name" name="name"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm 
                           focus:border-gray-900 focus:ring-gray-900">
                            <div id="edit_name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="edit_category_id" class="block text-base font-medium mt-6">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_category_id" name="category_id"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm 
                           focus:border-gray-900 focus:ring-gray-900">
                                <option value="">Select Category</option>
                                @foreach ($serviceCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div id="edit_category-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                        
                        <!-- Price -->
                        <div>
                            <label for="edit_price" class="block text-base font-medium mt-6">
                                Price <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="edit_price" name="unit_price" step="0.01" min="0"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm 
                           focus:border-gray-900 focus:ring-gray-900">
                            <div id="edit_price-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="edit_status" class="block text-base font-medium mt-6">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_status" name="status"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm 
                           focus:border-gray-900 focus:ring-gray-900">
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div id="edit_status-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="edit_description" class="block text-base font-medium mt-6">
                                Description
                            </label>
                            <textarea id="edit_description" name="description" rows="5"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm 
                           focus:border-gray-900 focus:ring-gray-900"></textarea>
                            <div id="edit_description-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 mt-6 pt-4">
                            <button type="button" x-on:click="$dispatch('close-modal', 'edit-service')"
                                class="px-4 py-2 text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">
                                Cancel
                            </button>
                            <button type="submit" id="update-service-btn"
                                class="px-4 py-2 text-sm bg-gray-800 hover:bg-gray-700 text-white rounded-md">
                                <span id="update-service-text">Update Service</span>
                                <span id="update-service-loading" class="hidden">Updating...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </x-modal>

            <!-- Confirm Delete Modal -->
            <x-modal name="confirm-delete" maxWidth="sm" marginTop="20">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Confirm Delete</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to delete this service? This action cannot be undone.
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

    <x-slot name="script">
        <script type="text/javascript">
            //update===================================================
            function openEditServiceModal(serviceId) {
                const row = document.getElementById(`service-row-${serviceId}`);
                if (!row) return;

                const cells = row.querySelectorAll('td');
                const name = cells[1].textContent.trim();
                const category = cells[2].textContent.trim();
                const priceText = cells[3].textContent.trim();
                const price = priceText.replace(/[^0-9.]/g, '');

                document.getElementById('edit_service_id').value = serviceId;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_price').value = price;

                const categorySelect = document.getElementById('edit_category_id');
                Array.from(categorySelect.options).forEach(opt => {
                    opt.selected = opt.text === category;
                });

                const statusText = cells[4].textContent.trim().toLowerCase();
                document.getElementById('edit_status').value = statusText;

                const descriptionEl = document.getElementById(`service-description-${serviceId}`);
                document.getElementById('edit_description').value = descriptionEl ? descriptionEl.textContent.trim() : '';

                ['name', 'category', 'price', 'status', 'description'].forEach(id => {
                    const el = document.getElementById(`edit_${id}-error`);
                    if (el) {
                        el.textContent = '';
                        el.classList.add('hidden');
                    }
                });

                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'edit-service'
                }));
            }

            document.getElementById('editServiceForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const serviceId = document.getElementById('edit_service_id').value;
                const data = {
                    category_id: document.getElementById('edit_category_id').value,
                    name: document.getElementById('edit_name').value,
                    unit_price: document.getElementById('edit_price').value,
                    status: document.getElementById('edit_status').value,
                    description: document.getElementById('edit_description').value,
                };

                const btn = document.getElementById('update-service-btn');
                const btnText = document.getElementById('update-service-text');
                const btnLoading = document.getElementById('update-service-loading');

                ['category', 'name', 'unit_price', 'status', 'description'].forEach(id => {
                    const el = document.getElementById(`edit_${id}-error`);
                    if (el) {
                        el.textContent = '';
                        el.classList.add('hidden');
                    }
                });

                btn.disabled = true;
                btnText.classList.add('hidden');
                btnLoading.classList.remove('hidden');

                $.ajax({
                    url: `/services/${serviceId}`,
                    type: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            showNotification('Service updated successfully!', 'success');
                            window.dispatchEvent(new CustomEvent('close-modal', {
                                detail: 'edit-service'
                            }));
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showNotification(response.message || 'Error updating service', 'error');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;

                            if (errors.category_id) {
                                const el = document.getElementById('edit_category-error'); // ✅ correct
                                el.textContent = errors.category_id[0];
                                el.classList.remove('hidden');
                            }
                            if (errors.unit_price) {
                                const el = document.getElementById('edit_price-error');
                                el.textContent = errors.unit_price[0];
                                el.classList.remove('hidden');
                            }
                            if (errors.name) {
                                const el = document.getElementById('edit_name-error');
                                el.textContent = errors.name[0];
                                el.classList.remove('hidden');
                            }
                            if (errors.status) {
                                const el = document.getElementById('edit_status-error');
                                el.textContent = errors.status[0];
                                el.classList.remove('hidden');
                            }
                        } else {
                            showNotification('An error occurred while creating the service!',
                                'error');
                        }
                    },
                    complete: function() {
                        btn.disabled = false;
                        btnText.classList.remove('hidden');
                        btnLoading.classList.add('hidden');
                    }
                });
            });

            //create==========================================
            function openCreateServiceModal() {
                document.getElementById('createServiceForm').reset();

                ['category', 'name', 'unit_price', 'status', 'description'].forEach(id => {
                    const el = document.getElementById(`modal_${id}-error`);
                    if (el) {
                        el.textContent = '';
                        el.classList.add('hidden');
                    }
                });


                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'create-service'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('createServiceForm');
                const saveBtn = document.getElementById('save-service-btn');
                const saveText = document.getElementById('save-service-text');
                const saveLoading = document.getElementById('save-service-loading');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    ['category', 'name', 'unit_price', 'status', 'description'].forEach(id => {
                        const el = document.getElementById(`modal_${id}-error`);
                        if (el) {
                            el.textContent = '';
                            el.classList.add('hidden');
                        }
                    });


                    saveBtn.disabled = true;
                    saveText.classList.add('hidden');
                    saveLoading.classList.remove('hidden');

                    const data = {
                        category_id: document.getElementById('modal_category_id').value,
                        name: document.getElementById('modal_name').value,
                        unit_price: document.getElementById('modal_price').value,
                        status: document.getElementById('modal_status').value,
                        description: document.getElementById('modal_description').value,
                    };

                    $.ajax({
                        url: '{{ route('services.store') }}',
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                showNotification(response.message ||
                                    'service created successfully!', 'success');
                                window.dispatchEvent(new CustomEvent('close-modal', {
                                    detail: 'create-service'
                                }));
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showNotification(response.message || 'Error creating service!',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;

                                // Show validation errors
                                if (errors.category_id) {
                                    const el = document.getElementById('modal_category-error');
                                    if (el) {
                                        el.textContent = errors.category_id[0];
                                        el.classList.remove('hidden');
                                    }
                                }
                                if (errors.unit_price) {
                                    const el = document.getElementById('modal_price-error');
                                    if (el) {
                                        el.textContent = errors.unit_price[0];
                                        el.classList.remove('hidden');
                                    }
                                }
                                if (errors.name) {
                                    const el = document.getElementById('modal_name-error');
                                    if (el) {
                                        el.textContent = errors.name[0];
                                        el.classList.remove('hidden');
                                    }
                                }
                                if (errors.status) {
                                    const el = document.getElementById('modal_status-error');
                                    if (el) {
                                        el.textContent = errors.status[0];
                                        el.classList.remove('hidden');
                                    }
                                }
                            } else {
                                showNotification('An error occurred while creating the service!',
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
            //delete===========================================================
            let deleteId = null;

            function deleteService(id) {
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

                    const row = document.getElementById(`service-row-${deleteId}`);
                    if (row) row.style.opacity = '0.5';

                    $.ajax({
                        url: '{{ route('services.destroy') }}',
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
                                    'Service deleted successfully!', 'success');
                                if (row) {
                                    row.style.transition = 'opacity 0.5s';
                                    row.style.opacity = '0';
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    setTimeout(() => location.reload(), 1000);
                                }
                            } else {
                                showNotification(response.message || 'Service not found!', 'error');
                                if (row) row.style.opacity = '1';
                            }
                        },
                        error: function() {
                            showNotification('An error occurred while deleting the service!',
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


            //filter and search form handlers===========================

            document.getElementById('search').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    this.form.submit();
                }
            });

            document.getElementById('price_min').addEventListener('change', function() {
                const minPrice = parseFloat(this.value);
                const maxPriceField = document.getElementById('price_max');
                const maxPrice = parseFloat(maxPriceField.value);

                if (minPrice && maxPrice && minPrice > maxPrice) {
                    showToast('Minimum price cannot be greater than maximum price!', 'error');
                    this.value = '';
                }
            });

            document.getElementById('price_max').addEventListener('change', function() {
                const maxPrice = parseFloat(this.value);
                const minPriceField = document.getElementById('price_min');
                const minPrice = parseFloat(minPriceField.value);

                if (minPrice && maxPrice && maxPrice < minPrice) {
                    showToast('Maximum price cannot be less than minimum price!', 'error');
                    this.value = '';
                }
            });
        </script>
    </x-slot>
</x-app-layout>
