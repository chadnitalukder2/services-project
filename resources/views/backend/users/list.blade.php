<x-app-layout>

    <div class="lg:py-12 py-8 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-message />

            {{-- user table --}}
            <div class="bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Users List</h3>
                        <div class="flex space-x-2">
                            @can('create users')
                                <button onclick="openCreateUserModal()"
                                    class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                                    <i class="fa-solid fa-plus"></i>
                                    Add User</button>
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
                                    User ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Username</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Roles</th>


                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>

                                @canany(['edit users', 'delete users'])
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                @endcanany

                            </tr>
                        </thead>
                        <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                            @if ($users->isNotEmpty())
                                @foreach ($users as $user)
                                    <tr class="border-b" id="user-row-{{ $user->id }}">
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $user->id }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4 text-left text-sm font-medium text-gray-900">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-3 text-left">
                                            {{ $user->roles->isNotEmpty() ? $user->roles->pluck('name')->implode(', ') : '---' }}
                                        </td>
                                        </td>

                                        <td class="px-6 py-4 text-left whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</td>

                                        @canany(['edit users', 'delete users'])
                                            <td
                                                class="px-6 py-4 text-center whitespace-nowrap text-base font-medium flex gap-6">
                                                @can('edit users')
                                                    <a href="javascript:void(0)"
                                                        onclick="openEditUserModal({{ $user->id }})"
                                                        class="text-yellow-500 hover:text-yellow-600" title="Edit User">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete users')
                                                    <a href="javascript:void(0)" onclick="deleteUser({{ $user->id }})"
                                                        class=" text-red-700 hover:text-red-600" title="Delate User">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">No users found
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
                            Showing <span class="font-medium">{{ $users->firstItem() }}</span>
                            to <span class="font-medium">{{ $users->lastItem() }}</span>
                            of <span class="font-medium">{{ $users->total() }}</span> results
                        </div>

                        <!-- Pagination buttons -->
                        <div class="flex flex-wrap gap-1 space-x-2">
                            <!-- Previous -->
                            @if ($users->onFirstPage())
                                <button
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm cursor-not-allowed"
                                    disabled>
                                    Previous
                                </button>
                            @else
                                <a href="{{ $users->previousPageUrl() }}"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded-md text-sm hover:bg-gray-200">
                                    Previous
                                </a>
                            @endif

                            <!-- Page numbers -->
                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                @if ($page == $users->currentPage())
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
                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}"
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

            <!-- Create User Modal -->
            <x-modal name="create-user" class="sm:max-w-md mt-20" maxWidth="2xl">
                <div class="p-6 md:px-14 md:py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Create New User</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'create-user')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="createUserForm">
                        @csrf
                        <div class="mb-4 mt-6">
                            <label for="name" class="block text-base font-medium mb-2">Username <span
                                    class="text-red-500">*</span></label>
                            <input id="name" type="text" name="name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            <p id="nameError" class="text-red-500 text-sm mt-1 hidden"></p>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-base font-medium mb-2">Email <span
                                    class="text-red-500">*</span></label>
                            <input id="email" type="email" name="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            <p id="emailError" class="text-red-500 text-sm mt-1 hidden"></p>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-base font-medium mb-2">Password <span
                                    class="text-red-500">*</span></label>
                            <input id="password" type="password" name="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            <p id="passwordError" class="text-red-500 text-sm mt-1 hidden"></p>
                        </div>

                        <div class="mb-4">
                            <label for="confirm_password" class="block text-base font-medium mb-2">Confirm
                                Password <span class="text-red-500">*</span></label>
                            <input id="confirm_password" type="password" name="confirm_password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            <p id="confirmPasswordError" class="text-red-500 text-sm mt-1 hidden"></p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-base font-medium mb-2">
                                Roles
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-3">
                                @if (isset($roles) && $roles->isNotEmpty())
                                    @foreach ($roles as $role)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                style="--tw-ring-shadow: none;"
                                                class="mr-2 h-4 w-4 text-gray-600 border-gray-300 rounded focus:outline-none focus:ring-0">
                                            <span class="text-sm text-gray-700">{{ $role->name }}</span>
                                        </label>
                                    @endforeach
                                @else
                                    <p class="text-gray-500 text-sm">No Roles available</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button"
                                class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                                x-on:click="$dispatch('close-modal', 'create-user')">
                                Cancel
                            </button>
                            <button type="submit" id="createUserBtn"
                                class="px-4 py-2 text-sm bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                <span id="createBtnText">Add User</span>
                                <span id="createBtnLoading" class="hidden">
                                    <i class="fas fa-spinner fa-spin mr-1"></i>Creating...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </x-modal>

            <!-- Edit User Modal -->
            <x-modal name="edit-user" class="sm:max-w-md mt-20" maxWidth="2xl">
                <div class="p-6 md:px-14 md:py-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Edit User</h2>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            x-on:click="$dispatch('close-modal', 'edit-user')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="editUserForm">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">

                        <div class="mb-6 mt-6">
                            <label class="block text-base font-medium mb-2">Username <span
                                    class="text-red-500">*</span></label>
                            <input id="edit_name" type="text" name="name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            <p id="editNameError" class="text-red-500 text-sm mt-1 hidden"></p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-base font-medium mb-2">Email <span
                                    class="text-red-500">*</span></label>
                            <input id="edit_email" type="email" name="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            <p id="editEmailError" class="text-red-500 text-sm mt-1 hidden"></p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-base font-medium mb-2">
                                Roles
                            </label>
                            <div id="edit_roles"
                                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-3">
                                @if (isset($roles) && $roles->isNotEmpty())
                                    @foreach ($roles as $role)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                style="--tw-ring-shadow: none;"
                                                class="mr-2 h-4 w-4 text-gray-600 border-gray-300 rounded focus:outline-none focus:ring-0">
                                            <span class="text-sm text-gray-700">{{ $role->name }}</span>
                                        </label>
                                    @endforeach
                                @else
                                    <p class="text-gray-500 text-sm">No Roles available</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button"
                                class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                                x-on:click="$dispatch('close-modal', 'edit-user')">Cancel</button>

                            <button type="submit" id="editUserBtn"
                                class="px-4 py-2 text-sm bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                <span id="editBtnText">Update User</span>
                                <span id="editBtnLoading" class="hidden">
                                    <i class="fas fa-spinner fa-spin mr-1"></i>Updating...
                                </span>
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
                        Are you sure you want to delete this user?
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
            //update=============================================
            function openEditUserModal(userId) {
                const row = document.getElementById(`user-row-${userId}`);

                // pick values from table columns
                const name = row.querySelector('td:nth-child(2)').textContent.trim();
                const email = row.querySelector('td:nth-child(3)').textContent.trim();
                const rolesText = row.querySelector('td:nth-child(4)').textContent.trim();

                // fill modal fields
                document.getElementById('edit_id').value = userId;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_email').value = email;

                // roles checkboxes
                const selectedRoles = rolesText === '---' ? [] : rolesText.split(',').map(r => r.trim());

                document.querySelectorAll('#edit_roles input[type="checkbox"]').forEach(cb => cb.checked = false);

                document.querySelectorAll('#edit_roles input[type="checkbox"]').forEach(cb => {
                    if (selectedRoles.includes(cb.value)) cb.checked = true;
                });

                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'edit-user'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const editForm = document.getElementById('editUserForm');
                const editBtn = document.getElementById('editUserBtn');
                const editBtnText = document.getElementById('editBtnText');
                const editBtnLoading = document.getElementById('editBtnLoading');

                const editNameError = document.getElementById('editNameError');
                const editEmailError = document.getElementById('editEmailError');

                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Reset errors
                    [editNameError, editEmailError].forEach(el => {
                        el.classList.add('hidden');
                        el.textContent = '';
                    });

                    editBtn.disabled = true;
                    editBtnText.classList.add('hidden');
                    editBtnLoading.classList.remove('hidden');

                    const userId = document.getElementById('edit_id').value;
                    const data = {
                        name: editForm.name.value || document.getElementById('edit_name').value,
                        email: editForm.email.value || document.getElementById('edit_email').value,
                        roles: Array.from(editForm.querySelectorAll('input[name="roles[]"]:checked'))
                            .map(input => input.value),
                    };

                    $.ajax({
                        url: `/users/${userId}`,
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                showNotification(response.message || 'User updated successfully!',
                                    'success');
                                window.dispatchEvent(new CustomEvent('close-modal', {
                                    detail: 'edit-user'
                                }));
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showNotification(response.message || 'Error updating user!',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                if (errors.name) {
                                    editNameError.textContent = errors.name[0];
                                    editNameError.classList.remove('hidden');
                                }
                                if (errors.email) {
                                    editEmailError.textContent = errors.email[0];
                                    editEmailError.classList.remove('hidden');
                                }
                            } else {
                                showNotification('An error occurred while updating the user!',
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

            function openCreateUserModal() {
                document.getElementById('createUserForm').reset();
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'create-user'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const createForm = document.getElementById('createUserForm');
                const createBtn = document.getElementById('createUserBtn');
                const createBtnText = document.getElementById('createBtnText');
                const createBtnLoading = document.getElementById('createBtnLoading');

                // Error placeholders
                const nameError = document.getElementById('nameError');
                const emailError = document.getElementById('emailError');
                const passwordError = document.getElementById('passwordError');
                const confirmPasswordError = document.getElementById('confirmPasswordError');

                createForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    [nameError, emailError, passwordError, confirmPasswordError].forEach(el => {
                        el.classList.add('hidden');
                        el.textContent = '';
                    });

                    createBtn.disabled = true;
                    createBtnText.classList.add('hidden');
                    createBtnLoading.classList.remove('hidden');

                    const data = {
                        name: createForm.name.value,
                        email: createForm.email.value,
                        password: createForm.password.value,
                        confirm_password: createForm.confirm_password.value,
                        roles: Array.from(createForm.querySelectorAll('input[name="roles[]"]:checked'))
                            .map(input => input.value),
                    };

                    $.ajax({
                        url: '{{ route('users.store') }}',
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                showNotification(response.message || 'User created successfully!',
                                    'success');

                                window.dispatchEvent(new CustomEvent('close-modal', {
                                    detail: 'create-user'
                                }));
                                createForm.reset();
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                showNotification(response.message || 'Error creating user!',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;

                                if (errors.name) {
                                    nameError.textContent = errors.name[0];
                                    nameError.classList.remove('hidden');
                                }
                                if (errors.email) {
                                    emailError.textContent = errors.email[0];
                                    emailError.classList.remove('hidden');
                                }
                                if (errors.password) {
                                    passwordError.textContent = errors.password[0];
                                    passwordError.classList.remove('hidden');
                                }
                                if (errors.confirm_password) {
                                    confirmPasswordError.textContent = errors.confirm_password[
                                        0];
                                    confirmPasswordError.classList.remove('hidden');
                                }
                            } else {
                                showNotification('An unexpected error occurred!', 'error');
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

            //delete User=========================
            let deleteId = null;

            function deleteUser(id) {
                deleteId = id;
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'confirm-delete'
                }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                const confirmBtn = document.getElementById('confirmDeleteBtn');

                confirmBtn.addEventListener('click', function() {
                    if (!deleteId) return;

                    const row = document.getElementById(`user-row-${deleteId}`);
                    if (row) row.style.opacity = '0.5';

                    $.ajax({
                        url: '{{ route('users.destroy') }}',
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
                                    'User deleted successfully!', 'success');
                                if (row) {
                                    row.style.transition = 'opacity 0.5s';
                                    row.style.opacity = '0';
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    setTimeout(() => location.reload(), 1000);
                                }
                            } else {
                                showNotification(response.message || 'User not found!', 'error');
                                if (row) row.style.opacity = '1';
                            }
                        },
                        error: function() {
                            showNotification('An error occurred while deleting the user!',
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
