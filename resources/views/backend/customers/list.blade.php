<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />

            <!-- Search and Filter Form -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('customers.index') }}" class="flex flex-wrap items-center gap-4">

                    <!-- Search Input -->
                    <div class="flex-1 min-w-64">
                        <input type="text" name="search" placeholder="Search by name, email, phone, or address..."
                            value="{{ request('search') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Sort Dropdown -->
                    <div>
                        <select name="sort"
                            class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First
                            </option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First
                            </option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md ">
                            Search
                        </button>
                        <a href="{{ route('customers.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            {{-- Customer table --}}
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">customers List</h3>
                        <div class="flex space-x-2">
                            @can('create customers')
                                <a href="{{ route('customers.create') }}"
                                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px"
                                        viewBox="0 0 640 640" fill="white">
                                        <path
                                            d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                                    </svg>
                                    Create Customer</a>
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
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="customersTableBody" class="bg-white divide-y divide-gray-200">
                            @if ($customers->isNotEmpty())
                                @foreach ($customers as $customer)
                                    <tr class="border-b" id="customer-row-{{ $customer->id }}">
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            #{{ str_pad($customer->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $customer->name }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $customer->phone }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $customer->email ?? '---' }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $customer->address ?? '---' }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $customer->company ?? '---' }}
                                        </td>

                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($customer->created_at)->format('d M, Y') }}</td>

                                        @canany(['edit customers', 'delete customers'])
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium flex gap-3">
                                                {{--  --}}

                                                @can('edit customers')
                                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                                        class="text-yellow-500 hover:text-yellow-600" title="Edit Customer">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete customers')
                                                    <a href="javascript:void(0)" onclick="deleteCustomer({{ $customer->id }})"
                                                        class=" text-red-700 hover:text-red-600" title="Delate Customer">
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
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $customers->firstItem() }}</span>
                            to <span class="font-medium">{{ $customers->lastItem() }}</span>
                            of <span class="font-medium">{{ $customers->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex space-x-2">
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

             <!-- Confirm Delete Modal ------------------------>
            <x-modal name="confirm-delete" class="sm:max-w-sm mt-20" maxWidth="sm" marginTop="20">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Confirm Delete</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to delete this customer?
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

    <x-slot name="script">
        <script type="text/javascript">

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
                                showNotification(response.message || 'Customer not found!', 'error');
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

        //====================================================
          

            // Auto-submit form when sort changes (optional)
            document.querySelector('select[name="sort"]').addEventListener('change', function() {
                this.form.submit();
            });

            // Enter key to submit search
            document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    this.form.submit();
                }
            });
        </script>
    </x-slot>
</x-app-layout>
