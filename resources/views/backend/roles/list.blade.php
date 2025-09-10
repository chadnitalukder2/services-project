<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            @can('create roles')
                <a href="{{ route('roles.create') }}"
                    class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px" viewBox="0 0 640 640" fill="white">
                        <path
                            d="M352 128C352 110.3 337.7 96 320 96C302.3 96 288 110.3 288 128L288 288L128 288C110.3 288 96 302.3 96 320C96 337.7 110.3 352 128 352L288 352L288 512C288 529.7 302.3 544 320 544C337.7 544 352 529.7 352 512L352 352L512 352C529.7 352 544 337.7 544 320C544 302.3 529.7 288 512 288L352 288L352 128z" />
                    </svg>

                    Create Role</a>
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
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Permissions</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        @canany(['edit roles', 'delete roles'])
                            <th class="px-6 py-3 text-center" width="180">Actions</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @if ($roles->isNotEmpty())
                        @foreach ($roles as $role)
                            <tr class="border-b">
                                <td class="px-6 py-3 text-left">
                                    {{ $roles->total() - ($roles->currentPage() - 1) * $roles->perPage() - $loop->index }}
                                </td>
                                <td class="px-6 py-3 text-left">{{ $role->name }}</td>
                                <td class="px-6 py-3 text-left"> {{ $role->permissions->pluck('name')->implode(', ') }}
                                </td>
                                <td class="px-6 py-3 text-left">
                                    {{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}</td>
                                @canany(['edit roles', 'delete roles'])
                                    <td class="px-6 py-3 text-center">
                                        @can('edit roles')
                                            <a href="{{ route('roles.edit', $role->id) }}"
                                                class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md text-white px-3 py-2">Edit</a>
                                        @endcan
                                        @can('delete roles')
                                            <a href="javascript:void()" onclick="deleteRole({{ $role->id }})"
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
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            function deleteRole(id) {
                if (confirm('Are you sure you want to delete this role?')) {
                    $.ajax({
                        url: '{{ route('roles.destroy') }}',
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
                                alert('Role not found');
                            }
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
