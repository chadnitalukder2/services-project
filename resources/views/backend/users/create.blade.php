<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users/Create
            </h2>
            <a href="{{ route('users.index') }}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <!-- Name -->
                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input placeholder="Enter Name" id="name"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="text"
                                    name="name" value="{{ old('name') }}" autofocus />

                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="email" class="text-lg font-medium">Email</label>
                            <div class="my-3">
                                <input placeholder="Enter Email" id="email"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="email"
                                    name="email" value="{{ old('email') }}" />

                                @error('email')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                             <label for="password" class="text-lg font-medium">Password</label>
                            <div class="my-3">
                                <input placeholder="Enter Password" id="password"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="password"
                                    name="password" value="{{ old('password') }}" />

                                @error('password')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                             <label for="confirm_password" class="text-lg font-medium">Confirm Password</label>
                            <div class="my-3">
                                <input placeholder="Enter Confirm Password" id="confirm_password"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="password"
                                    name="confirm_password" value="{{ old('confirm_password') }}" />

                                @error('confirm_password')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                                @error('email')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                        

                            <div class="grid grid-cols-4 gap-4 mb-4">
                                @if ($roles->isNotEmpty())
                                    @foreach ($roles as $role)
                                        <div class="mt-3">
                                            <input  type="checkbox" name="roles[]" value="{{ $role->name }}" id="role-{{ $role->id }}"
                                                class="border-gray-300 rounded-md shadow-sm" />
                                            <label class="ml-2" for="role-{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                            <button class="bg-slate-700 hover:bg-slate-600 text-sm rounded-md px-3 py-2 text-white">
                                Submit
                            </button>
                        </div>
                            </div>
                    </form>

                </div>
            </div>


</x-app-layout>
