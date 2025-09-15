<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users/Create
            </h2>
            <a href="{{ route('users.index') }}"
                class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px" viewBox="0 0 640 640" fill="white">
                    <path
                        d="M73.4 297.4C60.9 309.9 60.9 330.2 73.4 342.7L233.4 502.7C245.9 515.2 266.2 515.2 278.7 502.7C291.2 490.2 291.2 469.9 278.7 457.4L173.3 352L544 352C561.7 352 576 337.7 576 320C576 302.3 561.7 288 544 288L173.3 288L278.7 182.6C291.2 170.1 291.2 149.8 278.7 137.3C266.2 124.8 245.9 124.8 233.4 137.3L73.4 297.3z" />
                </svg>
                Back</a>
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
                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                            id="role-{{ $role->id }}"
                                            class="border-gray-300 rounded-md shadow-sm" />
                                        <label class="ml-2"
                                            for="role-{{ $role->id }}">{{ $role->name }}</label>
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
