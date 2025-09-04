<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customers/Edit
            </h2>
            <a href="{{ route('customers.index') }}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                        @csrf
                        <!-- Name -->
                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input placeholder="Enter Name" id="name"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="text"
                                    name="name" value="{{ old('name', $customer->name) }}" autofocus />

                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="email" class="text-lg font-medium">Email</label>
                            <div class="my-3">
                                <input placeholder="Enter Email" id="email"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="email"
                                    name="email" value="{{ old('email', $customer->email) }}" autofocus />

                                @error('email')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="phone" class="text-lg font-medium">Phone</label>
                            <div class="my-3">
                                <input placeholder="Enter Phone" id="phone"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="number"
                                    name="phone" value="{{ old('phone', $customer->phone) }}" autofocus />

                                @error('phone')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="address" class="text-lg font-medium">Address</label>
                            <div class="my-3">
                                <input placeholder="Enter Address" id="address"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="text"
                                    name="address" value="{{ old('address', $customer->address) }}" autofocus />

                                @error('address')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="company" class="text-lg font-medium">Company</label>
                            <div class="my-3">
                                <input placeholder="Enter Company" id="company"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="text"
                                    name="company" value="{{ old('company', $customer->company) }}" autofocus />

                                @error('company')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <button class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>
</x-app-layout>
