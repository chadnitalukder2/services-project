<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Expenses') }}
            </h2>
            @can('create expenses')
                <a href="{{ route('expenses.create') }}"
                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px" viewBox="0 0 640 640" fill="white">
                        <path d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z"/>
                    </svg>
                    Create Expense</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />

            <!-- Filter Form -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <form method="GET" action="{{ route('expenses.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    
                    <!-- Category Filter -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                     <!-- Expense Date From (Optional) -->
                    <div>
                        <label for="expense_date_from" class="block text-sm font-medium text-gray-700 mb-1">Expense Date From</label>
                        <input type="date" name="expense_date_from" id="expense_date_from" value="{{ request('expense_date_from') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Created At Date From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Created From</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Created At Date To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Created To</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                   

                    <!-- Filter Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-md hover:bg-blue-700 focus:ring focus:ring-blue-200">
                            Filter
                        </button>
                        <a href="{{ route('expenses.index') }}" class="bg-gray-500 text-white px-8 py-2 rounded-md hover:bg-gray-600">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left " width="60">#</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-left">Category</th>
                        <th class="px-6 py-3 text-left">Amount</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        @canany(['edit expenses', 'delete expenses'])
                        <th class="px-6 py-3 text-center" width="180">Actions</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @if ($expenses->isNotEmpty())
                        @foreach ($expenses as $expense)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left">{{ ($expenses->total() - (($expenses->currentPage() - 1) * $expenses->perPage()) - $loop->index) }}</td>
                                <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($expense->date)->format('d M, Y') }}</td>
                                <td class="px-6 py-3 text-left">{{ $expense->category->name }}</td>
                                <td class="px-6 py-3 text-left">{{ $expense->amount }}</td>
                                <td class="px-6 py-3 text-left">{{ \Carbon\Carbon::parse($expense->created_at)->format('d M, Y') }}</td>
              
                                @canany(['edit expenses', 'delete expenses'])
                                <td class="px-6 py-3 text-center">
                                    @can('edit expenses')
                                        <a href="{{ route('expenses.edit', $expense->id) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                    @endcan
                                    @can('delete expenses')
                                        <a href="javascript:void()" onclick="deleteExpense({{ $expense->id }})" class="bg-red-700 text-sm rounded-md text-white px-3 py-2 hover:bg-red-600">Delete</a>
                                    @endcan
                                </td>
                                @endcanany
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No expenses found matching your criteria.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="mt-4">
                {{ $expenses->links() }}
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            function deleteExpense(id){
                if(confirm('Are you sure you want to delete this expense?')){
                    $.ajax({
                        url: '{{ route("expenses.destroy") }}',
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
                                alert('Expense not found');
                            }
                        }
                    });
                }
            }

            // Auto-submit form when filter values change (optional)
            document.getElementById('category_id').addEventListener('change', function() {
                // Uncomment the line below if you want auto-submit on category change
                // this.form.submit();
            });
        </script>
    </x-slot>
</x-app-layout>