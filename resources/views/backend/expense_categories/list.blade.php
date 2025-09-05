<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Expense Categories') }}
            </h2>
            @can('create expense categories')
                <a href="{{ route('expense_categories.create') }}"
                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px" viewBox="0 0 640 640" fill="white">
  <path d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z"/>
</svg>

                    Create Expense Category</a>
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
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        @canany(['edit expense categories', 'delete expense categories'])
                            <th class="px-6 py-3 text-center" width="180">Actions</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @if ($expenseCategories->isNotEmpty())
                        @foreach ($expenseCategories as $category)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left">
                                    {{ $expenseCategories->total() - ($expenseCategories->currentPage() - 1) * $expenseCategories->perPage() - $loop->index }}
                                </td>
                                <td class="px-6 py-3 text-left">{{ $category->name }}</td>
                                <td class="px-6 py-3 text-left">
                                    {{ \Carbon\Carbon::parse($category->created_at)->format('d M, Y') }}</td>
                                @canany(['edit expense categories', 'delete expense categories'])
                                    <td class="px-6 py-3 text-center">
                                        @can('edit expense categories')
                                            <a href="{{ route('expense_categories.edit', $category->id) }}"
                                                class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600">Edit</a>
                                        @endcan
                                        @can('delete expense categories')
                                            <a href="javascript:void()" onclick="deleteCategory({{ $category->id }})"
                                                class="bg-red-700 text-sm rounded-md text-white px-3 py-2 hover:bg-red-600">Delete</a>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                    @endif

                </tbody>

            </table>
            <div class="mt-4">
                {{ $expenseCategories->links() }}
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            function deleteCategory(id) {
                if (confirm('Are you sure you want to delete this category?')) {
                    $.ajax({
                        url: '{{ route('expense_categories.destroy') }}',
                        type: 'DELETE',
                        data: {
                            id: id,
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                location.reload();
                            } else {
                                alert('Category not found');
                            }
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
