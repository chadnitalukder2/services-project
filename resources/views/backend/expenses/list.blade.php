<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Expenses Management</h2>

            <!-- Filter Form -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <form method="GET" action="{{ route('expenses.index') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                    <!-- Category Filter -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" id="category_id"
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring focus:border-gray-900 focus:ring-gray-900 focus:ring-opacity-50">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <!-- Expense Date  (Optional) -->
                    <div>
                        <label for="expense_date_from" class="block text-sm font-medium text-gray-700 mb-1">Expense Date
                            </label>
                        <input type="date" name="expense_date_from" id="expense_date_from"
                            value="{{ request('expense_date_from') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div> --}}

                    <!-- Created At Date From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Created From</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring focus:border-gray-900 focus:ring-gray-900 focus:ring-opacity-50">
                    </div>

                    <!-- Created At Date To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Created To</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring focus:border-gray-900 focus:ring-gray-900 focus:ring-opacity-50">
                    </div>



                    <!-- Filter Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-gray-800 text-sm hover:bg-gray-700 text-white px-12 py-2 rounded-md ">
                            Filter
                        </button>
                        <a href="{{ route('expenses.index') }}"
                            class="bg-gray-500 text-white text-sm px-12 py-2 rounded-md hover:bg-gray-600">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            {{-- expense table --}}
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Expense List</h3>
                        <div class="flex space-x-2">
                            @can('create expenses')
                                <button onclick="openCreateExpenseModal()"
                                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                                    <i class="fa-solid fa-plus"></i>
                                    Add Expense</button>
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
                                    Title</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount</th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                @canany(['edit expenses', 'delete expenses'])
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                @endcanany

                            </tr>
                        </thead>
                        <tbody id="expensesTableBody" class="bg-white divide-y divide-gray-200">
                            @if ($expenses->isNotEmpty())
                                @foreach ($expenses as $expense)
                                    <td class="hidden" id="expense-description-{{ $expense->id }}">
                                        {{ $expense->description }}
                                    </td>
                                    <tr class="border-b" id="expense-row-{{ $expense->id }}">
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $expense->id }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $expense->title }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($expense->date)->format('d M, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $expense->category->name  ?? '---'}}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                             @if ($settings->currency_position == 'left')
                                              {{ $settings->currency ?? 'Tk' }}  {{ number_format($expense->amount, 2) }}
                                            @else
                                               {{ number_format($expense->amount, 2) }} {{ $settings->currency ?? 'Tk' }}
                                            @endif
                                        </td>


                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($expense->created_at)->format('d M, Y') }}</td>

                                        @canany(['edit expenses', 'delete expenses'])
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium flex gap-6">
                                                {{--  --}}

                                                @can('edit expenses')
                                                    <a href="javascript:void(0)"
                                                        onclick="openEditExpenseModal({{ $expense->id }})"
                                                        class="text-yellow-500 hover:text-yellow-600" title="Edit expense">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete expenses')
                                                    <a href="javascript:void(0)" onclick="deleteExpense({{ $expense->id }})"
                                                        class=" text-red-700  hover:text-red-600" title="Delate expense">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">No expenses found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot class="bg-gray-100">
                            <tr>
                                <td colspan="4" class="px-6 text-sm py-3 text-right font-bold text-gray-900">Total Expense:</td>
                                <td class="px-6 text-sm py-3 text-left font-bold text-gray-900">
                                    @if ($settings->currency_position == 'left')
                                        {{ $settings->currency ?? 'Tk' }} {{ number_format($totalExpense, 2) }}
                                    @else
                                        {{ number_format($totalExpense, 2) }} {{ $settings->currency ?? 'Tk' }}
                                    @endif
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $expenses->firstItem() }}</span>
                            to <span class="font-medium">{{ $expenses->lastItem() }}</span>
                            of <span class="font-medium">{{ $expenses->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex space-x-2">
                            <!-- Previous -->
                            @if ($expenses->onFirstPage())
                                <button
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                    disabled>
                                    Previous
                                </button>
                            @else
                                <a href="{{ $expenses->previousPageUrl() }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                    Previous
                                </a>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($expenses->getUrlRange(1, $expenses->lastPage()) as $page => $url)
                                @if ($page == $expenses->currentPage())
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
                            @if ($expenses->hasMorePages())
                                <a href="{{ $expenses->nextPageUrl() }}"
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

            <!-- Create Expense Modal -->
            <x-modal name="create-expense" class="sm:max-w-md mt-20" maxWidth="2xl">
                <div class="px-14 py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Add New Expense</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'create-expense')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="createExpenseForm" class="space-y-4">

                        <!-- Title -->
                        <div class="mt-6"> 
                            <label for="modal_title" class="block text-base font-medium mt-6">Title
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="modal_title" name="title"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                            <div id="modal_title-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <label for="modal_category_id"
                                class="block text-base font-medium mt-6">Category</label>
                            <select id="modal_category_id" name="category_id"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <option value="">Select Category</option>
                                @foreach ($expenseCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div id="modal_category-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="modal_amount" class="block text-base font-medium mt-6">Amount
                                <span class="text-red-500">*</span></label>
                            <input type="number" id="modal_amount" name="amount"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                            <div id="modal_amount-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="modal_date" class="block text-base font-medium mt-6">Date <span
                                    class="text-red-500">*</span></label>
                            <input type="date" id="modal_date" name="date"
                                class="mt-3 block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900"
                                value="{{ old('date', date('Y-m-d')) }}">
                            <div id="modal_date-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="modal_description"
                                class="block text-base font-medium mt-6">Description</label>
                            <textarea id="modal_description" name="description" rows="3"
                                class="mt-3 block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900"></textarea>
                            <div id="modal_description-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div class="flex justify-end gap-3 mt-6 pt-4">
                            <button type="button" x-on:click="$dispatch('close-modal', 'create-expense')"
                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-sm text-gray-800 rounded-md">
                                Cancel
                            </button>
                            <button type="submit" id="save-expense-btn"
                                class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-sm text-white rounded-md">
                                <span id="save-expense-text">Save Expense</span>
                                <span id="save-expense-loading" class="hidden">Saving...</span>
                            </button>
                        </div>
                    </form>


                </div>
            </x-modal>

            <x-modal name="edit-expense" class="sm:max-w-md mt-20" maxWidth="2xl">
                <div class="px-14 py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Edit Expense</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'edit-expense')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="editExpenseForm" class="space-y-4">
                        <input type="hidden" id="edit_expense_id">

                        <!-- Title -->
                        <div class="mt-6">
                            <label for="edit_title" class="block text-base font-medium mt-6">Title
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="edit_title" name="title"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                            <div id=edit_title-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <label for="edit_category_id"
                                class="block text-base font-medium">Category </label>
                            <select id="edit_category_id" name="category_id"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <option value="">Select Category</option>
                                @foreach ($expenseCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div id="edit_category-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <label for="edit_amount" class="block text-base font-medium mt-6">Amount <span
                                    class="text-red-500">*</span></label>
                            <input type="number" id="edit_amount" name="amount"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                            <div id="edit_amount-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <label for="edit_date" class="block text-base font-medium mt-6">Date <span
                                    class="text-red-500">*</span></label>
                            <input type="date" id="edit_date" name="date"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                            <div id="edit_date-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <label for="edit_description"
                                class="block text-base font-medium mt-6">Description</label>
                            <textarea id="edit_description" name="description" rows="3"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900"></textarea>
                            <div id="edit_description-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div class="flex justify-end gap-3 mt-6 pt-4">
                            <button type="button" x-on:click="$dispatch('close-modal', 'edit-expense')"
                                class="px-4 py-2 text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">
                                Cancel
                            </button>
                            <button type="submit" id="update-expense-btn"
                                class="px-4 py-2 text-sm bg-gray-800 hover:bg-gray-700 text-white rounded-md">
                                <span id="update-expense-text">Update Expense</span>
                                <span id="update-expense-loading" class="hidden">Updating...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </x-modal>

            <!-- Confirm Delete Modal ------------------------>
            <x-modal name="confirm-delete" class="sm:max-w-sm mt-20" maxWidth="sm" marginTop="20">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Confirm Delete</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to delete this expense?
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
            function openEditExpenseModal(expenseId) {
                const row = document.getElementById(`expense-row-${expenseId}`);
                if (!row) return;


                const cells = row.querySelectorAll('td');
                const title = cells[1].textContent.trim();
                const date = cells[2].textContent.trim();
                const category = cells[3].textContent.trim();
                const amountText = cells[4].textContent.trim();

                const amount = amountText.replace(/[^0-9.]/g, '');
                document.getElementById('edit_amount').value = amount;

                const description = document.getElementById(`expense-description-${expenseId}`).textContent.trim();
                document.getElementById('edit_description').value = description;

                // Set modal values
                document.getElementById('edit_expense_id').value = expenseId;
                document.getElementById('edit_date').value = parseTableDate(date);
                document.getElementById('edit_amount').value = amount;
                document.getElementById('edit_title').value = title;

                // Select the correct category option
                const categorySelect = document.getElementById('edit_category_id');
                Array.from(categorySelect.options).forEach(opt => {
                    opt.selected = opt.text === category;
                });

                document.getElementById('edit_description').value = description;

                // Clear previous errors
                ['category', 'amount', 'date', 'description'].forEach(id => {
                    const el = document.getElementById(`edit_${id}-error`);
                    if (el) {
                        el.textContent = '';
                        el.classList.add('hidden');
                    }
                });

                // Open modal
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'edit-expense'
                }));
            }

            function parseTableDate(dateStr) {
                const [day, monthStr, year] = dateStr.replace(',', '').split(' ');
                const monthNames = {
                    Jan: '01',
                    Feb: '02',
                    Mar: '03',
                    Apr: '04',
                    May: '05',
                    Jun: '06',
                    Jul: '07',
                    Aug: '08',
                    Sep: '09',
                    Oct: '10',
                    Nov: '11',
                    Dec: '12'
                };
                return `${year}-${monthNames[monthStr]}-${day.padStart(2,'0')}`;
            }

            document.getElementById('editExpenseForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const expenseId = document.getElementById('edit_expense_id').value;
                const data = {
                    title: document.getElementById('edit_title').value,
                    category_id: document.getElementById('edit_category_id').value,
                    amount: document.getElementById('edit_amount').value,
                    date: document.getElementById('edit_date').value,
                    description: document.getElementById('edit_description').value,
                };

                const btn = document.getElementById('update-expense-btn');
                const btnText = document.getElementById('update-expense-text');
                const btnLoading = document.getElementById('update-expense-loading');

                // Clear previous errors like create form
                ['category', 'title', 'amount', 'date', 'description'].forEach(id => {
                    const el = document.getElementById(`edit_${id}-error`);
                    if (el) {
                        el.textContent = '';
                        el.classList.add('hidden');
                    }
                });

                btn.disabled = true;
                btnText.classList.add('hidden');
                btnLoading.classList.remove('hidden');

                $.ajax({
                    url: `/expenses/${expenseId}`,
                    type: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            showNotification('Expense updated successfully!', 'success');
                            window.dispatchEvent(new CustomEvent('close-modal', {
                                detail: 'edit-expense'
                            }));
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showNotification(response.message || 'Error updating expense', 'error');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;

                            if (errors.title) {
                                const el = document.getElementById('edit_title-error');
                                if (el) {
                                    el.textContent = errors.title[0];
                                    el.classList.remove('hidden');
                                }
                            }
                            if (errors.category_id) {
                                const el = document.getElementById('edit_category-error');
                                if (el) {
                                    el.textContent = errors.category_id[0];
                                    el.classList.remove('hidden');
                                }
                            }
                            if (errors.amount) {
                                const el = document.getElementById('edit_amount-error');
                                if (el) {
                                    el.textContent = errors.amount[0];
                                    el.classList.remove('hidden');
                                }
                            }
                            if (errors.date) {
                                const el = document.getElementById('edit_date-error');
                                if (el) {
                                    el.textContent = errors.date[0];
                                    el.classList.remove('hidden');
                                }
                            }
                            if (errors.description) {
                                const el = document.getElementById('edit_description-error');
                                if (el) {
                                    el.textContent = errors.description[0];
                                    el.classList.remove('hidden');
                                }
                            }
                        } else {
                            showNotification('An error occurred!', 'error');
                        }
                    },
                    complete: function() {
                        btn.disabled = false;
                        btnText.classList.remove('hidden');
                        btnLoading.classList.add('hidden');
                    }
                });
            });

            //create==========================================

            function openCreateExpenseModal() {
                document.getElementById('createExpenseForm').reset();

                // Clear all previous errors
                ['category', 'amount', 'date', 'description'].forEach(id => {
                    const el = document.getElementById(`modal_${id}-error`);
                    if (el) {
                        el.textContent = '';
                        el.classList.add('hidden');
                    }
                });

                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'create-expense'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('createExpenseForm');
                const saveBtn = document.getElementById('save-expense-btn');
                const saveText = document.getElementById('save-expense-text');
                const saveLoading = document.getElementById('save-expense-loading');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Clear previous errors
                    ['category', 'title', 'amount', 'date', 'description'].forEach(id => {
                        const el = document.getElementById(`modal_${id}-error`);
                        if (el) {
                            el.textContent = '';
                            el.classList.add('hidden');
                        }
                    });

                    saveBtn.disabled = true;
                    saveText.classList.add('hidden');
                    saveLoading.classList.remove('hidden');

                    const data = {
                        title: document.getElementById('modal_title').value,
                        category_id: document.getElementById('modal_category_id').value,
                        amount: document.getElementById('modal_amount').value,
                        date: document.getElementById('modal_date').value,
                        description: document.getElementById('modal_description').value,
                    };

                    $.ajax({
                        url: '{{ route('expenses.store') }}',
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                showNotification(response.message ||
                                    'Expense created successfully!', 'success');
                                window.dispatchEvent(new CustomEvent('close-modal', {
                                    detail: 'create-expense'
                                }));
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showNotification(response.message || 'Error creating expense!',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;

                                if (errors.title) {
                                    const el = document.getElementById('modal_title-error');
                                    if (el) {
                                        el.textContent = errors.title[0];
                                        el.classList.remove('hidden');
                                    }
                                }
                                if (errors.category_id) {
                                    const el = document.getElementById('modal_category-error');
                                    if (el) {
                                        el.textContent = errors.category_id[0];
                                        el.classList.remove('hidden');
                                    }
                                }
                                if (errors.amount) {
                                    const el = document.getElementById('modal_amount-error');
                                    if (el) {
                                        el.textContent = errors.amount[0];
                                        el.classList.remove('hidden');
                                    }
                                }
                                if (errors.date) {
                                    const el = document.getElementById('modal_date-error');
                                    if (el) {
                                        el.textContent = errors.date[0];
                                        el.classList.remove('hidden');
                                    }
                                }
                                if (errors.description) {
                                    const el = document.getElementById('modal_description-error');
                                    if (el) {
                                        el.textContent = errors.description[0];
                                        el.classList.remove('hidden');
                                    }
                                }
                            } else {
                                showNotification('An error occurred while creating the expense!',
                                    'error');
                            }
                        },
                        complete: function() {
                            saveBtn.disabled = false;
                            saveText.classList.remove('hidden');
                            saveLoading.classList.add('hidden');
                        }
                    });
                });
            });


            //delete Expense=========================
            let deleteId = null;

            function deleteExpense(id) {
                deleteId = id;
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'confirm-delete'
                }));
            }
            document.addEventListener('DOMContentLoaded', function() {
                const confirmBtn = document.getElementById('confirmDeleteBtn');

                confirmBtn.addEventListener('click', function() {
                    if (!deleteId) return;

                    const row = document.getElementById(`expense-row-${deleteId}`);
                    if (row) row.style.opacity = '0.5';

                    $.ajax({
                        url: '{{ route('expenses.destroy') }}',
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
                                    'Expense deleted successfully!', 'success');
                                if (row) {
                                    row.style.transition = 'opacity 0.5s';
                                    row.style.opacity = '0';
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    setTimeout(() => location.reload(), 1000);
                                }
                            } else {
                                showNotification(response.message || 'Expense not found!', 'error');
                                if (row) row.style.opacity = '1';
                            }
                        },
                        error: function() {
                            showNotification('An error occurred while deleting the expense!',
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


            // Auto-submit form when filter values change (optional)
            document.getElementById('category_id').addEventListener('change', function() {
                // Uncomment the line below if you want auto-submit on category change
                // this.form.submit();
            });
        </script>
    </x-slot>
</x-app-layout>
