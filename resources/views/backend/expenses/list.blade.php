<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Expenses') }}
            </h2>
            @can('create expenses')
                <a href="{{ route('expenses.create') }}"
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
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-left">Category</th>
                        <th class="px-6 py-3 text-left">Amount</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        @canany(['edit services', 'delete services'])
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
</script>
    </x-slot>
</x-app-layout>
