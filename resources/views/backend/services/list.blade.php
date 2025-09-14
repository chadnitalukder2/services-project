<x-app-layout>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <!-- Search and Filter Form -->
            <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                <form method="GET" action="{{ route('services.index') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">

                    <!-- Service Name Search -->
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search
                            Service</label>
                        <input type="text" name="search" id="search"
                            placeholder="Search by service name and status..." value="{{ request('search') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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
                        <button type="submit"
                            class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
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
                                <a href="{{ route('services.create') }}"
                                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px"
                                        viewBox="0 0 640 640" fill="white">
                                        <path
                                            d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                                    </svg>
                                    Create Service</a>
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
                                    Price</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="servicesTableBody" class="bg-white divide-y divide-gray-200">
                            @if ($services->isNotEmpty())
                                @foreach ($services as $service)
                                    <tr class="border-b" id="service-row-{{ $service->id }}">
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            #{{ str_pad($service->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $service->name }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ number_format($service->unit_price, 2) }} tk
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
                                                class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium flex gap-3">
                                                {{--  --}}

                                                @can('edit services')
                                                    <a href="{{ route('services.edit', $service->id) }}"
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
            let deleteId = null;

            function deleteService(id) {
                deleteId = id;

                // Open your modal via Alpine dispatch
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'confirm-delete'
                }));
            }

            // Attach event to confirm button once page is ready
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

            document.getElementById('sort').addEventListener('change', function() {
                this.form.submit();
            });

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
