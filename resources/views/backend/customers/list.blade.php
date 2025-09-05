<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customers') }}
            </h2>
            @can('create customers')
                <a href="{{ route('customers.create') }}"
                    class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />

            <!-- Search and Filter Form -->
            <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                <form method="GET" action="{{ route('customers.index') }}" class="flex flex-wrap items-center gap-4">
                    
                    <!-- Search Input -->
                    <div class="flex-1 min-w-64">
                        <input type="text" 
                               name="search" 
                               placeholder="Search by name, email, phone, or address..." 
                               value="{{ request('search') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Sort Dropdown -->
                    <div>
                        <select name="sort" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:ring focus:ring-blue-200">
                            Search
                        </button>
                        <a href="{{ route('customers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b">
                            <th class="px-6 py-3 text-left " width="60">#</th>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Phone</th>
                            <th class="px-6 py-3 text-left">Address</th>
                            <th class="px-6 py-3 text-left">Company</th>
                            <th class="px-6 py-3 text-left" width="180">Created</th>
                            @canany(['edit customers', 'delete customers'])
                            <th class="px-6 py-3 text-center" width="180">Actions</th>
                            @endcanany
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @if ($customers->isNotEmpty())
                            @foreach ($customers as $customer)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-3 text-left">{{ ($customers->total() - (($customers->currentPage() - 1) * $customers->perPage()) - $loop->index) }}</td>
                                    <td class="px-6 py-3 text-left">
                                        @if(request('search'))
                                            {!! str_ireplace(request('search'), '<mark class="bg-yellow-200">' . request('search') . '</mark>', e($customer->name)) !!}
                                        @else
                                            {{ $customer->name }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-left">
                                        @if(request('search'))
                                            {!! str_ireplace(request('search'), '<mark class="bg-yellow-200">' . request('search') . '</mark>', e($customer->email)) !!}
                                        @else
                                            {{ $customer->email }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-left">
                                        @if(request('search'))
                                            {!! str_ireplace(request('search'), '<mark class="bg-yellow-200">' . request('search') . '</mark>', e($customer->phone)) !!}
                                        @else
                                            {{ $customer->phone }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-left">
                                        @if(request('search'))
                                            {!! str_ireplace(request('search'), '<mark class="bg-yellow-200">' . request('search') . '</mark>', e($customer->address)) !!}
                                        @else
                                            {{ $customer->address }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-left">
                                        @if(request('search'))
                                            {!! str_ireplace(request('search'), '<mark class="bg-yellow-200">' . request('search') . '</mark>', e($customer->company)) !!}
                                        @else
                                            {{ $customer->company }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($customer->created_at)->format('d M, Y') }}</td>
                                    @canany(['edit customers', 'delete customers'])
                                    <td class="px-6 py-3 text-center">
                                        @can('edit customers')
                                            <a href="{{ route('customers.edit', $customer->id) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                        @endcan
                                        @can('delete customers')
                                            <a href="javascript:void()" onclick="deleteCustomer({{ $customer->id }})" class="bg-red-700 text-sm rounded-md text-white px-3 py-2 hover:bg-red-600">Delete</a>
                                        @endcan
                                    </td>
                                    @endcanany
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    @if(request('search'))
                                        No customers found matching "<strong>{{ request('search') }}</strong>".
                                    @else
                                        No customers found.
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            function deleteCustomer(id){
                if(confirm('Are you sure you want to delete this customer?')){
                    $.ajax({
                        url: '{{ route("customers.destroy") }}',
                        type: 'DELETE',
                        data: {
                            id: id,
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if(response.status) {
                                location.reload();
                            } else {
                                alert('Customer not found');
                            }
                        }
                    });
                }
            }

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