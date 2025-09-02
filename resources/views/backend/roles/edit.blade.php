<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles/Edit
            </h2>
            <a href="{{ route('roles.index') }}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        <!-- Name -->
                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input placeholder="Enter Name" id="name"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="text"
                                    name="name" value="{{ old('name', $role->name) }}" autofocus />

                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-4 gap-4 mb-4">
                                @if ($permissions->isNotEmpty())
                                    @foreach ($permissions as $permission)
                                        <div class="mt-3">
                                            <input {{ $hasPermissions->contains($permission->name) ? 'checked' : '' }} type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission-{{ $permission->id }}"
                                                class="border-gray-300 rounded-md shadow-sm" />
                                            <label class="ml-2" for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                            <button class="bg-slate-700 hover:bg-slate-600 text-sm rounded-md px-3 py-2 text-white">
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>


</x-app-layout>
