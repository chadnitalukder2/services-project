<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Services') }}
            </h2>
            @can('create services')
                <a href="{{ route('services.create') }}"
                    class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />

            <!-- Search and Filter Form -->
            <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                <form method="GET" action="{{ route('services.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    
                    <!-- Service Name Search -->
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Service</label>
                        <input type="text" 
                               name="search" 
                               id="search"
                               placeholder="Search by service name..." 
                               value="{{ request('search') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Price Range - Min -->
                    <div>
                        <label for="price_min" class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                        <input type="number" 
                               name="price_min" 
                               id="price_min"
                               placeholder="0.00"
                               step="0.01"
                               min="0"
                               value="{{ request('price_min') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Price Range - Max -->
                    <div>
                        <label for="price_max" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                        <input type="number" 
                               name="price_max" 
                               id="price_max"
                               placeholder="1000.00"
                               step="0.01"
                               min="0"
                               value="{{ request('price_max') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Sort Dropdown -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select name="sort" id="sort" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="lg:col-span-5 flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:ring focus:ring-blue-200">
                            Search
                        </button>
                        <a href="{{ route('services.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Results Summary -->
            @if(request()->hasAny(['search', 'price_min', 'price_max', 'sort']))
                <div class="bg-blue-50 border border-blue-200 rounded-md p-3 mb-4">
                    <p class="text-sm text-blue-800">
                        @if(request('search'))
                            Search results for "<strong>{{ request('search') }}</strong>"
                        @else
                            Showing all services
                        @endif
                        
                        @if(request('price_min') || request('price_max'))
                            - Price range: 
                            {{ request('price_min') ? '$'.number_format(request('price_min'), 2) : '$0.00' }} 
                            to 
                            {{ request('price_max') ? '$'.number_format(request('price_max'), 2) : '∞' }}
                        @endif
                        
                        - Sorted by {{ request('sort') == 'asc' ? 'oldest first' : 'newest first' }}
                        ({{ $services->total() }} {{ Str::plural('result', $services->total()) }} found)
                    </p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b">
                            <th class="px-6 py-3 text-left " width="60">#</th>
                            <th class="px-6 py-3 text-left">Service Name</th>
                            <th class="px-6 py-3 text-left">Price</th>
                            <th class="px-6 py-3 text-left" width="180">Created</th>
                            @canany(['edit services', 'delete services'])
                            <th class="px-6 py-3 text-center" width="180">Actions</th>
                            @endcanany
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @if ($services->isNotEmpty())
                            @foreach ($services as $service)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-3 text-left">{{ ($services->total() - (($services->currentPage() - 1) * $services->perPage()) - $loop->index) }}</td>
                                    <td class="px-6 py-3 text-left">
                                        @if(request('search'))
                                            {!! str_ireplace(request('search'), '<mark class="bg-yellow-200">' . request('search') . '</mark>', e($service->name)) !!}
                                        @else
                                            {{ $service->name }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-left">
                                       {{ number_format($service->unit_price, 2) }}
                                    </td>
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
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    @if(request()->hasAny(['search', 'price_min', 'price_max']))
                                        No services found matching your search criteria.
                                    @else
                                        No services found.
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

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
                    alert('Minimum price cannot be greater than maximum price');
                    this.value = '';
                }
            });

            document.getElementById('price_max').addEventListener('change', function() {
                const maxPrice = parseFloat(this.value);
                const minPriceField = document.getElementById('price_min');
                const minPrice = parseFloat(minPriceField.value);
                
                if (minPrice && maxPrice && maxPrice < minPrice) {
                    alert('Maximum price cannot be less than minimum price');
                    this.value = '';
                }
            });
        </script>
    </x-slot>
</x-app-layout>