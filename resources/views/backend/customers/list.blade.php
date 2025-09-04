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

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left " width="60">#</th>
                        <th class="px-6 py-3 text-left"> Name</th>
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
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left">{{ $customer->id }}</td>
                                <td class="px-6 py-3 text-left">{{ $customer->name }}</td>
                                <td class="px-6 py-3 text-left">{{ $customer->email }}</td>
                                <td class="px-6 py-3 text-left">{{ $customer->phone }}</td>
                                <td class="px-6 py-3 text-left">{{ $customer->address }}</td>
                                <td class="px-6 py-3 text-left">{{ $customer->company }}</td>
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
                    @endif

                </tbody>

            </table>
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
</script>
    </x-slot>
</x-app-layout>
