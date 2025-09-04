<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Services') }}
            </h2>
            <a href="{{ route('services.create') }}"
                class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Create</a>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left " width="60">#</th>
                        <th class="px-6 py-3 text-left">Service Name</th>
                        <th class="px-6 py-3 text-left">Price</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        <th class="px-6 py-3 text-center" width="180">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @if ($services->isNotEmpty())
                        @foreach ($services as $service)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left">{{ $service->id }}</td>
                                <td class="px-6 py-3 text-left">{{ $service->name }}</td>
                                <td class="px-6 py-3 text-left">{{ $service->unit_price }}</td>
                                <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($service->created_at)->format('d M, Y') }}</td>
                               @canany(['edit services', 'delete services'])
                                <td class="px-6 py-3 text-center">
                                    @can('edit services')
                                        <a href="{{ route('services.edit', $service->id) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                    @endcan
                                    @can('delete services')
                                        <a href="javascript:void()" onclick="deleteService({{ $service->id }})" class="bg-red-700 text-sm rounded-md text-white px-3 py-2 hover:bg-red-600">Delete</a>
                                    @endcan
                                </td>
                                @endcanany
                            </tr>
                        @endforeach
                    @endif

                </tbody>

            </table>
            <div class="mt-4">
                {{ $services->links() }}
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
   function deleteService(id){
    if(confirm('Are you sure you want to delete this service?')){
        $.ajax({
            url: '{{ route("services.destroy") }}',
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
                    alert('Service not found');
                }
            }
        });
    }
   }
</script>
    </x-slot>
</x-app-layout>
