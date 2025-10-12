<x-app-layout>

    <div class="lg:py-12 py-8 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />

            {{-- Category table --}}
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-wrap gap-4 justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Service Category List</h3>
                        <div class="flex space-x-2">
                            @can('create service category')
                                <button onclick="openCreateServiceCategoryModal()"
                                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                                    <i class="fa-solid fa-plus"></i>
                                    Add Category</button>
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
                                    SI</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                @canany(['edit service category', 'delete service category'])
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                @endcanany

                            </tr>
                        </thead>
                        <tbody id="serviceCategoryTableBody" class="bg-white divide-y divide-gray-200">
                            @if ($serviceCategory->isNotEmpty())
                             @php
                                $si = $serviceCategory->count();
                            @endphp
                                @foreach ($serviceCategory as $category)
                                    <tr class="border-b" id="category-row-{{ $category->id }}">
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $si-- }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $category->name }}
                                        </td>

                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($category->created_at)->format('d M, Y') }}</td>

                                        @canany(['edit service category', 'delete service category'])
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-base font-medium flex gap-6">

                                                @can('edit service category')
                                                    <a href="javascript:void(0)"
                                                        onclick="openEditCategoryModal({{ $category->id }}, '{{ $category->name }}')"
                                                        class="text-yellow-500 hover:text-yellow-600" title="Edit Category">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete service category')
                                                    <a href="javascript:void(0)" onclick="deleteCategory({{ $category->id }})"
                                                        class=" text-red-700 hover:text-red-600" title="Delate Category">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">No Service Category
                                        found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-wrap gap-4 justify-center sm:justify-between lg:justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $serviceCategory->firstItem() }}</span>
                            to <span class="font-medium">{{ $serviceCategory->lastItem() }}</span>
                            of <span class="font-medium">{{ $serviceCategory->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex flex-wrap gap-1 space-x-2">
                            <!-- Previous -->
                            @if ($serviceCategory->onFirstPage())
                                <button
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                    disabled>
                                    Previous
                                </button>
                            @else
                                <a href="{{ $serviceCategory->previousPageUrl() }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                    Previous
                                </a>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($serviceCategory->getUrlRange(1, $serviceCategory->lastPage()) as $page => $url)
                                @if ($page == $serviceCategory->currentPage())
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
                            @if ($serviceCategory->hasMorePages())
                                <a href="{{ $serviceCategory->nextPageUrl() }}"
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

            <!-- Create customer Modal -->
            <x-modal name="create-service-category" class="sm:max-w-md mt-20" maxWidth="2xl" marginTop="20">
                <div class="p-6 md:px-14 md:py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Add New Service Category</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'create-service-category')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="createServiceCategoryForm" class="space-y-4">
                        <!-- Name -->
                        <div class="mt-6">
                            <label for="category_name" class="block text-base font-medium">Category Name
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="category_name" name="name"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                            <div id="category-name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div class="flex justify-end gap-3 mt-6 pt-4">
                            <button type="button" x-on:click="$dispatch('close-modal', 'create-service-category')"
                                class="px-4 py-2 text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition">
                                Cancel
                            </button>
                            <button type="submit" id="save-category-btn"
                                class="px-4 py-2 text-sm bg-gray-800 hover:bg-gray-700 text-white rounded-md transition">
                                <span id="save-category-text">Save Category</span>
                                <span id="save-category-loading" class="hidden">Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </x-modal>

            <!-- Update customer Modal -->
            <x-modal name="edit-service-category" class="sm:max-w-md mt-20" maxWidth="2xl" marginTop="20">
                <div class="p-6 md:px-14 md:py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Edit service Category</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'edit-service-category')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="editserviceCategoryForm" class="space-y-4">
                        <input type="hidden" id="edit_category_id">
                        <div class="mt-6">
                            <label for="edit_category_name" class="block text-base font-medium">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_category_name" name="name"
                                class="mt-3 text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                            <div id="edit-category-name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div class="flex justify-end gap-3 mt-6 pt-4">
                            <button type="button" x-on:click="$dispatch('close-modal', 'edit-service-category')"
                                class="px-4 py-2 text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition">
                                Cancel
                            </button>
                            <button type="submit" id="update-category-btn"
                                class="px-4 text-sm py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-md transition">
                                <span id="update-category-text">Update Category</span>
                                <span id="update-category-loading" class="hidden">Updating...</span>
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
                        Are you sure you want to delete this service category?
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
            //update===========================================
            function openEditCategoryModal(id, name) {
                document.getElementById('edit_category_id').value = id;
                const nameEl = document.getElementById('edit_category_name');
                nameEl.value = name;

                const errorEl = document.getElementById('edit-category-name-error');
                errorEl.textContent = '';
                errorEl.classList.add('hidden');

                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'edit-service-category'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('editserviceCategoryForm');
                const saveBtn = document.getElementById('update-category-btn');
                const saveText = document.getElementById('update-category-text');
                const saveLoading = document.getElementById('update-category-loading');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const nameEl = document.getElementById('edit-category-name-error');
                    nameEl.textContent = '';
                    nameEl.classList.add('hidden');

                    saveBtn.disabled = true;
                    saveText.classList.add('hidden');
                    saveLoading.classList.remove('hidden');

                    const id = document.getElementById('edit_category_id').value;
                    const name = document.getElementById('edit_category_name').value;

                    $.ajax({
                        url: `/service_category/${id}`, // Assuming RESTful route
                        type: 'POST',
                        data: {
                            name
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                showNotification(response.message ||
                                    'Category updated successfully!', 'success');
                                window.dispatchEvent(new CustomEvent('close-modal', {
                                    detail: 'edit-service-category'
                                }));
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showNotification(response.message || 'Error updating category!',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                if (errors.name) {
                                    nameEl.textContent = errors.name[0];
                                    nameEl.classList.remove('hidden');
                                }
                            } else {
                                showNotification('An error occurred while updating the category!',
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

            // Create================

            function openCreateServiceCategoryModal() {
                document.getElementById('createServiceCategoryForm').reset();

                const errorEl = document.getElementById('category-name-error');
                errorEl.classList.add('hidden');
                errorEl.textContent = '';

                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'create-service-category'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('createServiceCategoryForm');
                const saveBtn = document.getElementById('save-category-btn');
                const saveText = document.getElementById('save-category-text');
                const saveLoading = document.getElementById('save-category-loading');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const nameEl = document.getElementById('category-name-error');
                    nameEl.textContent = '';
                    nameEl.classList.add('hidden');

                    saveBtn.disabled = true;
                    saveText.classList.add('hidden');
                    saveLoading.classList.remove('hidden');

                    const data = {
                        name: document.getElementById('category_name').value
                    };

                    $.ajax({
                        url: '{{ route('service_category.store') }}',
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                showNotification(response.message ||
                                    'Category created successfully!', 'success');
                                window.dispatchEvent(new CustomEvent('close-modal', {
                                    detail: 'create-service-category'
                                }));
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showNotification(response.message || 'Error creating category!',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                if (errors.name) {
                                    nameEl.textContent = errors.name[0];
                                    nameEl.classList.remove('hidden');
                                }
                            } else {
                                showNotification('An error occurred while creating the category!',
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

            //delete Category=========================
            let deleteId = null;

            function deleteCategory(id) {
                deleteId = id;
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'confirm-delete'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const confirmBtn = document.getElementById('confirmDeleteBtn');

                confirmBtn.addEventListener('click', function() {
                    if (!deleteId) return;

                    const row = document.getElementById(`category-row-${deleteId}`);
                    if (row) row.style.opacity = '0.5';

                    $.ajax({
                        url: '{{ route('service_category.destroy') }}',
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
                                    'Category deleted successfully!', 'success');
                                if (row) {
                                    row.style.transition = 'opacity 0.5s';
                                    row.style.opacity = '0';
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    setTimeout(() => location.reload(), 1000);
                                }
                            } else {
                                showNotification(response.message || 'Category not found!',
                                    'error');
                                if (row) row.style.opacity = '1';
                            }
                        },
                        error: function() {
                            showNotification('An error occurred while deleting the category!',
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
        </script>
    </x-slot>
</x-app-layout>
