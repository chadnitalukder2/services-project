<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Permissions/Create
            </h2>
            <a href="{{ route('permissions.index') }}"
                class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('permissions.store') }}">
                        @csrf
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Permission Name')" />
                            <x-text-input placeholder="Enter Name" id="name" class="my-3 block mt-1 w-1/2" type="text" name="name"
                                :value="old('name')" autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />

                                <button class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">
                                    Submit
                                </button>
                        </div>
                    </form>

                </div>
            </div>


</x-app-layout>
