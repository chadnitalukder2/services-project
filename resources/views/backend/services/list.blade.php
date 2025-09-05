<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Services') }}
            </h2>
            @can('create services')
                <a href="{{ route('services.create') }}"
                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px" viewBox="0 0 640 640" fill="white">
  <path d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z"/>
</svg>

                    Create Service</a>
            @endcan
        </div>
    </x-slot>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

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
                               placeholder="Search by service name and status..." 
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
                            <option value="active" {{ request('sort') == 'active' ? 'selected' : '' }}>Active Services</option>
                            <option value="inactive" {{ request('sort') == 'inactive' ? 'selected' : '' }}>Inactive Services</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="gap-2" style="display: block; margin:0 auto; margin-top: 24px;" >
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:ring focus:ring-blue-200" >
                            Search
                        </button>
                        <a href="{{ route('services.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600" style="padding: 10px 18px;">
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
                            <th class="px-6 py-3 text-left">Service Name</th>
                            <th class="px-6 py-3 text-left">Price</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left" width="180">Created</th>
                            @canany(['edit services', 'delete services'])
                            <th class="px-6 py-3 text-center" width="180">Actions</th>
                            @endcanany
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @if ($services->isNotEmpty())
                            @foreach ($services as $service)
                                <tr class="border-b hover:bg-gray-50" id="service-row-{{ $service->id }}">
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
                                    <td class="px-6 py-3 text-left">
                                        @if($service->status == 'active')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Inactive
                                            </span>
                                        @endif
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
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
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
            // Toast notification function
            function showToast(message, type = 'success') {
                const toastContainer = document.getElementById('toast-container');
                const toast = document.createElement('div');
                
                const bgColor = type === 'success' ? 'bg-green-400' : 'bg-red-200';
                const icon = type === 'success' ? '✓' : '✗';
                
                toast.className = `${bgColor} text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2 transform translate-x-full transition-transform duration-300 ease-in-out`;
                toast.innerHTML = `
                    <span class="text-lg font-bold">${icon}</span>
                    <span>${message}</span>
                    <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <span class="text-lg">&times;</span>
                    </button>
                `;
                
                toastContainer.appendChild(toast);
                
                // Slide in animation
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);
                
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (toast.parentElement) {
                            toast.remove();
                        }
                    }, 300);
                }, 4000);
            }

            function deleteService(id) {
                if(confirm('Are you sure you want to delete this service?')) {
                    // Show loading state
                    const row = document.getElementById(`service-row-${id}`);
                    if (row) {
                        row.style.opacity = '0.5';
                    }
                    
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
                                showToast(response.message || 'Service deleted successfully!', 'success');
                                // Fade out and remove the row
                                if (row) {
                                    row.style.transition = 'opacity 0.5s';
                                    row.style.opacity = '0';
                                    setTimeout(() => {
                                        location.reload();
                                    }, 3000);
                                } else {
                                    setTimeout(() => location.reload(), 1000);
                                }
                            } else {
                                showToast(response.message || 'Service not found!', 'error');
                                if (row) {
                                    row.style.opacity = '1';
                                }
                            }
                        },
                        error: function() {
                            showToast('An error occurred while deleting the service!', 'error');
                            if (row) {
                                row.style.opacity = '1';
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