<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Services/Edit
            </h2>
            <a href="{{ route('services.index') }}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('services.update', $service->id) }}">
                        @csrf
                        <!-- Name -->
                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input placeholder="Enter Name" id="name"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="text"
                                    name="name" value="{{ old('name', $service->name) }}" autofocus />

                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="unit_price" class="text-lg font-medium">Price</label>
                            <div class="my-3">
                                <input placeholder="Enter Price" id="unit_price"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="text"
                                    name="unit_price" value="{{ old('unit_price', $service->unit_price) }}" autofocus />

                                @error('unit_price')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                        <div>
                            <label for="description" class="text-lg font-medium">Description</label>
                            <div class="my-3">
                                <textarea rows="4" placeholder="Enter Description" id="description"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm"
                                    name="description">{{ old('description', $service->description) }}</textarea>

                                @error('description')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>

                        

                            <button class="bg-slate-700 hover:bg-slate-600 text-sm rounded-md px-3 py-2 text-white">
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>


</x-app-layout>
