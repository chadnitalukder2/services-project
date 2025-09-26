<x-app-layout>

    <div class="lg:py-12 py-8 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />

            {{-- Roles table --}}
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Roles List</h3>
                        <div class="flex space-x-2">
                            @can('create roles')
                                <button onclick="openCreateRoleModal()"
                                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                                    <i class="fa-solid fa-plus"></i>
                                    Add Role</button>
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
                                    Role ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Permission</th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                @canany(['edit roles', 'delete roles'])
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                @endcanany

                            </tr>
                        </thead>
                        <tbody id="rolesTableBody" class="bg-white divide-y divide-gray-200">
                            @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                    <tr class="border-b" id="role-row-{{ $role->id }}">
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $role->id }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900 capitalize">
                                            {{ $role->name }}</td>
                                        <td class="px-6 py-3 text-left">
                                            @if ($role->permissions->isNotEmpty())
                                                @foreach ($role->permissions as $permission)
                                                    <span
                                                        class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded mr-1 mb-1">
                                                        {{ $permission->name }}
                                                    </span>
                                                @endforeach
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}</td>

                                        @canany(['edit roles', 'delete roles'])
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium flex gap-6">
                                                {{--  --}}

                                                @can('edit roles')
                                                    <a href="javascript:void(0)"
                                                        onclick="openEditRoleModal({{ $role->id }})"
                                                        class="text-yellow-500 hover:text-yellow-600" title="Edit Role">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete roles')
                                                    <a href="javascript:void(0)" onclick="deleteRole({{ $role->id }})"
                                                        class=" text-red-700 hover:text-red-600" title="Delete Role">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">No roles found
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
                            Showing <span class="font-medium">{{ $roles->firstItem() }}</span>
                            to <span class="font-medium">{{ $roles->lastItem() }}</span>
                            of <span class="font-medium">{{ $roles->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex flex-wrap gap-1 space-x-2">
                            <!-- Previous -->
                            @if ($roles->onFirstPage())
                                <button
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                    disabled>
                                    Previous
                                </button>
                            @else
                                <a href="{{ $roles->previousPageUrl() }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                    Previous
                                </a>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($roles->getUrlRange(1, $roles->lastPage()) as $page => $url)
                                @if ($page == $roles->currentPage())
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
                            @if ($roles->hasMorePages())
                                <a href="{{ $roles->nextPageUrl() }}"
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

            <!-- Create Role Modal -->
            <x-modal name="create-role" class="sm:max-w-md mt-20" maxWidth="5xl">
                <div class="p-6 md:px-14 md:py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Add New Role</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'create-role')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="createRoleForm">
                        @csrf
                        <div class="mb-4 mt-6">
                            <label for="rolName" class="block text-base font-medium">
                                Role Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="roleName" name="name"
                                class="w-full mt-3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="Enter role name">
                            <div id="roleNameError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div class="mb-6">
                            @php
                                $modules = $permissions->pluck('module')->unique();
                            @endphp

                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-2 border rounded bg-gray-50 capitalize">
                                @foreach ($permissions as $permission)
                                    @php
                                        $colorClass = 'text-gray-700 bg-gray-100';

                                        if (Str::contains($permission->name, 'delete')) {
                                            $colorClass = 'text-red-700 bg-red-100 border border-red-300';
                                        } elseif (
                                            Str::contains($permission->name, 'edit') ||
                                            Str::contains($permission->name, 'update')
                                        ) {
                                            $colorClass = 'text-blue-700 bg-blue-100 border border-blue-300';
                                        } elseif (Str::contains($permission->name, 'view')) {
                                            $colorClass = 'text-green-700 bg-green-100 border border-green-300';
                                        } elseif (Str::contains($permission->name, 'create')) {
                                            $colorClass = 'text-purple-700 bg-purple-100 border border-purple-300';
                                        }
                                    @endphp

                                    <label class="flex items-center px-2 py-1 rounded {{ $colorClass }}">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                            class="mr-2 h-4 w-4 text-gray-600 border-gray-300 rounded focus:outline-none focus:ring-0">
                                        <span class="text-sm font-medium">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button"
                                class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                                x-on:click="$dispatch('close-modal', 'create-role')">
                                Cancel
                            </button>
                            <button type="submit" id="createRoleBtn"
                                class="px-4 py-2 text-sm bg-gray-800 text-white rounded hover:bg-gray-700">
                                <span id="createBtnText">Add Role</span>
                                <span id="createBtnLoading" class="hidden">
                                    <i class="fas fa-spinner fa-spin mr-1"></i>Creating...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </x-modal>

            <!-- Edit Role Modal -->
            <x-modal name="edit-role" class="sm:max-w-md mt-20" maxWidth="5xl">
                <div class="p-6 md:px-14 md:py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Update Role</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'edit-role')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="editRoleForm">
                        @csrf
                        <input type="hidden" id="editRoleId" name="role_id">

                        <div class="mb-4 mt-6">
                            <label for="editRoleName" class="block text-base font-medium mb-2">
                                Role Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="editRoleName" name="name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                placeholder="Enter role name">
                            <div id="editRoleNameError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div class="mb-6">
                            @php
                                $modules = $permissions->pluck('module')->unique();
                            @endphp

                            @foreach ($modules as $module)
                                <div class="mb-4">
                                    <label class="block text-base font-medium mb-2 capitalize">{{ $module }}
                                        Permissions</label>

                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-2 border rounded bg-gray-50 capitalize">
                                        @foreach ($permissions->where('module', $module) as $permission)
                                            @php
                                                // Assign color classes based on permission type
                                                $colorClass = 'text-gray-700 bg-gray-100 border';
                                                if (Str::contains($permission->name, 'delete')) {
                                                    $colorClass = 'text-red-700 bg-red-100 border-red-300';
                                                } elseif (
                                                    Str::contains($permission->name, 'edit') ||
                                                    Str::contains($permission->name, 'update')
                                                ) {
                                                    $colorClass = 'text-blue-700 bg-blue-100 border-blue-300';
                                                } elseif (Str::contains($permission->name, 'view')) {
                                                    $colorClass = 'text-green-700 bg-green-100 border-green-300';
                                                } elseif (Str::contains($permission->name, 'create')) {
                                                    $colorClass = 'text-purple-700 bg-purple-100 border-purple-300';
                                                }

                                                // Check if this permission is already assigned to the role
                                                $isChecked = in_array($permission->name, $rolePermissions ?? []);
                                            @endphp

                                            <label class="flex items-center px-2 py-1 rounded {{ $colorClass }}">
                                                <input type="checkbox" name="permissions[]"
                                                    value="{{ $permission->name }}"
                                                    class="mr-2 h-4 w-4 text-gray-600 border-gray-300 rounded focus:outline-none focus:ring-0"
                                                    @if ($isChecked) checked @endif>
                                                <span class="text-sm font-medium">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button"
                                class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                                x-on:click="$dispatch('close-modal', 'edit-role')">
                                Cancel
                            </button>
                            <button type="submit" id="editRoleBtn"
                                class="px-4 py-2 text-sm bg-gray-800 hover:bg-gray-700 text-white rounded-md ">
                                <span id="editBtnText">Update Role</span>
                                <span id="editBtnLoading" class="hidden">
                                    <i class="fas fa-spinner fa-spin mr-1"></i>Updating...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </x-modal>

            <!-- Confirm Delete Modal -->
            <x-modal name="confirm-delete" class="sm:max-w-sm mt-20" maxWidth="sm" marginTop="20">
                <div class="p-8">
                    <h2 class="text-lg font-medium text-gray-900">Confirm Delete</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to delete this role?
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
            //update==========================================
            function openEditRoleModal(roleId) {
                const row = document.getElementById(`role-row-${roleId}`);
                const roleName = row.querySelector('td:nth-child(2)').textContent.trim();
                const permissionsText = row.querySelector('td:nth-child(3)').textContent.trim();

                document.getElementById('editRoleId').value = roleId;
                document.getElementById('editRoleName').value = roleName;

                // const selectedPermissions = permissionsText.split(',').map(p => p.trim());
                const selectedPermissions = Array.from(row.querySelectorAll('td:nth-child(3) span'))
                    .map(span => span.textContent.trim());

                // Uncheck all first
                document.querySelectorAll('#editRoleForm input[name="permissions[]"]').forEach(cb => cb.checked = false);

                // Check those that exist in the role
                document.querySelectorAll('#editRoleForm input[name="permissions[]"]').forEach(cb => {
                    if (selectedPermissions.includes(cb.value)) cb.checked = true;
                });

                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'edit-role'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const editForm = document.getElementById('editRoleForm');
                const editBtn = document.getElementById('editRoleBtn');
                const editBtnText = document.getElementById('editBtnText');
                const editBtnLoading = document.getElementById('editBtnLoading');
                const editRoleNameError = document.getElementById('editRoleNameError');

                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    editRoleNameError.classList.add('hidden');
                    editRoleNameError.textContent = '';

                    editBtn.disabled = true;
                    editBtnText.classList.add('hidden');
                    editBtnLoading.classList.remove('hidden');

                    const roleId = document.getElementById('editRoleId').value;
                    const roleName = document.getElementById('editRoleName').value;
                    const permissions = Array.from(editForm.querySelectorAll(
                            'input[name="permissions[]"]:checked'))
                        .map(input => input.value);

                    $.ajax({
                        url: `/roles/${roleId}`,
                        type: 'POST',
                        data: {
                            name: roleName,
                            permissions: permissions
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                showNotification(response.message || 'Role updated successfully!',
                                    'success');
                                window.dispatchEvent(new CustomEvent('close-modal', {
                                    detail: 'edit-role'
                                }));
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showNotification(response.message || 'Error updating role!',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                if (errors.name) {
                                    editRoleNameError.textContent = errors.name[0];
                                    editRoleNameError.classList.remove('hidden');
                                }
                            } else {
                                showNotification('An error occurred while updating the role!',
                                    'error');
                            }
                        },
                        complete: function() {
                            editBtn.disabled = false;
                            editBtnText.classList.remove('hidden');
                            editBtnLoading.classList.add('hidden');
                        }
                    });
                });
            });

            // Create================

            function openCreateRoleModal() {
                document.getElementById('createRoleForm').reset();
                document.getElementById('roleNameError').classList.add('hidden');
                // Open modal
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'create-role'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const createForm = document.getElementById('createRoleForm');
                const createBtn = document.getElementById('createRoleBtn');
                const createBtnText = document.getElementById('createBtnText');
                const createBtnLoading = document.getElementById('createBtnLoading');
                const roleNameError = document.getElementById('roleNameError');

                createForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    roleNameError.classList.add('hidden');
                    roleNameError.textContent = '';

                    createBtn.disabled = true;
                    createBtnText.classList.add('hidden');
                    createBtnLoading.classList.remove('hidden');

                    // Collect input values manually
                    const roleName = document.getElementById('roleName').value;

                    // Collect checked permissions
                    const permissions = Array.from(createForm.querySelectorAll(
                            'input[name="permissions[]"]:checked'))
                        .map(input => input.value);

                    // Prepare data object
                    const data = {
                        name: roleName,
                        permissions: permissions
                    };

                    $.ajax({
                        url: '{{ route('roles.store') }}',
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                showNotification(response.message || 'Role created successfully!',
                                    'success');

                                // Close modal
                                window.dispatchEvent(new CustomEvent('close-modal', {
                                    detail: 'create-role'
                                }));

                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showNotification(response.message || 'Error creating role!',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                if (errors.name) {
                                    roleNameError.textContent = errors.name[0];
                                    roleNameError.classList.remove('hidden');
                                }
                            } else {
                                showNotification('An error occurred while creating the role!',
                                    'error');
                            }
                        },
                        complete: function() {
                            createBtn.disabled = false;
                            createBtnText.classList.remove('hidden');
                            createBtnLoading.classList.add('hidden');
                        }
                    });
                });
            });

            //delete Role=========================
            let deleteId = null;

            function deleteRole(id) {
                deleteId = id;
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'confirm-delete'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const confirmBtn = document.getElementById('confirmDeleteBtn');

                confirmBtn.addEventListener('click', function() {
                    if (!deleteId) return;

                    const row = document.getElementById(`role-row-${deleteId}`);
                    if (row) row.style.opacity = '0.5';

                    $.ajax({
                        url: '{{ route('roles.destroy') }}',
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
                                    'Role deleted successfully!', 'success');
                                if (row) {
                                    row.style.transition = 'opacity 0.5s';
                                    row.style.opacity = '0';
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    setTimeout(() => location.reload(), 1000);
                                }
                            } else {
                                showNotification(response.message || 'Role not found!', 'error');
                                if (row) row.style.opacity = '1';
                            }
                        },
                        error: function() {
                            showNotification('An error occurred while deleting the role!',
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
