<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Expenses/Create
            </h2>
            <a href="{{ route('expenses.index') }}" class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white flex justify-center items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" height="12px" width="12px" viewBox="0 0 640 640" fill="white">
                 <path d="M73.4 297.4C60.9 309.9 60.9 330.2 73.4 342.7L233.4 502.7C245.9 515.2 266.2 515.2 278.7 502.7C291.2 490.2 291.2 469.9 278.7 457.4L173.3 352L544 352C561.7 352 576 337.7 576 320C576 302.3 561.7 288 544 288L173.3 288L278.7 182.6C291.2 170.1 291.2 149.8 278.7 137.3C266.2 124.8 245.9 124.8 233.4 137.3L73.4 297.3z"/>
                </svg>
                Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('expenses.store') }}">
                        @csrf
                        <!-- Name -->
                        <div>
                            <label for="name" class="text-lg font-medium">Category</label>
                            <div class="my-3">
                                <select id="category_id" class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm"
                                    name="category_id" autofocus>
                                    <option value="">Select Category</option>
                                    @foreach ($expenseCategories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="amount" class="text-lg font-medium">Amount</label>
                            <div class="my-3">
                                <input placeholder="Enter Amount" id="amount"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" type="number"
                                    name="amount" :value="old('amount')" autofocus />

                                @error('amount')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="date" class="text-lg font-medium">Date</label>
                            <div class="my-3">
                                <input type="date" id="date"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" name="date"
                                    value="{{ old('date') }}" autofocus />

                                @error('date')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="description" class="text-lg font-medium">Description</label>
                            <div class="my-3">
                                <textarea rows="4" placeholder="Enter Description" id="description"
                                    class="block mt-1 w-1/2 border-gray-300 rounded-md shadow-sm" name="description" :value="old('description')"
                                    autofocus></textarea>

                                @error('description')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>

                        <button class="bg-gray-800 hover:bg-gray-700 text-sm rounded-md px-3 py-2 text-white">
                            Submit
                        </button>
                </div>
                </form>

            </div>
        </div>


</x-app-layout>
