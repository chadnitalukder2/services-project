<x-app-layout>
    <x-message />
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Setting</h2>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class=" p-14">

                <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center gap-5 mb-6">
                        <div class="mb-4 w-1/2">
                            <label class="block text-base font-medium mb-2">Company Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $setting->title ?? '') }}"
                                class="block text-sm p-2.5 w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900"
                                required>
                        </div>

                        <div class="mb-4 w-1/2">
                            <label class="block text-base font-medium mb-2">Address</label>
                            <input type="text" name="address" value="{{ old('address', $setting->address ?? '') }}"
                                class="block text-sm p-2.5 w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        </div>
                    </div>
                    <div class="flex items-center gap-5 mb-6">
                        <div class="mb-4 w-1/2">
                            <label class="block text-base font-medium mb-2">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $setting->phone ?? '') }}"
                                class="block text-sm p-2.5 w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        </div>

                        <div class="mb-4 w-1/2">
                            <label class="block text-base font-medium mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $setting->email ?? '') }}"
                                class="block text-sm p-2.5 w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        </div>
                    </div>

                    <div class="flex items-center gap-5 mb-6">
                        <div class="mb-4 w-1/2">
                            <label class="block text-base font-medium mb-2">Currency</label>
                            <input type="text" name="currency"
                                value="{{ old('currency', $setting->currency ?? '') }}" placeholder="e.g., USD, BDT"
                                class="block text-sm p-2.5 w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                        </div>

                        <div class="mb-4 w-1/2">
                            <label class="block text-base font-medium mb-2">Currency Position</label>
                            <select name="currency_position"
                                class="block text-sm p-2.5 w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900">
                                <option value="left"
                                    {{ ($setting->currency_position ?? 'left') == 'left' ? 'selected' : '' }}>Left ($
                                    100)
                                </option>
                                <option value="right"
                                    {{ ($setting->currency_position ?? '') == 'right' ? 'selected' : '' }}>
                                    Right (100 $)</option>
                            </select>
                        </div>
                    </div>



                    <div class="mb-4 mt-6">
                        <label class="text-base font-medium">Logo</label>
                        <div class="flex gap-5 items-center">
                            <input type="file" name="logo" id="logoInput"
                                class="block text-sm p-2.5 w-1/2 border border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900"
                                accept="image/*">

                            <!-- Image Preview Container -->
                            <div class=" flex gap-8 items-center">
                                <!-- Current Logo -->
                                @if (!empty($setting->logo))
                                    <div id="currentLogo">
                                        <p class="text-sm text-gray-600 mb-2">Current Logo</p>
                                        <img src="{{ asset('storage/' . $setting->logo) }}" alt="Current Logo"
                                            class="w-[110px] h-[110px] border rounded shadow-sm ">
                                    </div>
                                @endif

                                <!-- Preview Container (initially hidden) -->
                                <div id="imagePreviewContainer" class="hidden">
                                    <p class="text-sm text-gray-600 mb-2 ">New Logo</p>
                                    <div class="relative inline-block">
                                        <img id="imagePreview" src="" alt="Preview"
                                            class="w-[110px] h-[110px]  border rounded shadow-sm">
                                        <button type="button" id="removePreview"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition duration-200">
                                            ×
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mb-6 mt-6">
                        <label class="text-base font-medium">Message</label>
                        <textarea name="message" rows="4"
                            class="block mt-3 text-sm p-2.5 w-full border-gray-300 rounded-md shadow-sm focus:border-gray-900 focus:ring-gray-900"
                            placeholder="Enter your site message...">{{ old('message', $setting->message ?? '') }}</textarea>
                    </div>

                    <div class="text-right mt-10 ">
                        <button type="submit"
                            class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2  text-sm rounded-md transition duration-200">
                            {{ $setting->exists ? 'Update Settings' : 'Save Settings' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoInput = document.getElementById('logoInput');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const removePreview = document.getElementById('removePreview');
            const currentLogo = document.getElementById('currentLogo');

            // Handle file input change
            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Please select a valid image file.');
                        logoInput.value = '';
                        return;
                    }

                    // Validate file size (2MB limit)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Please select an image smaller than 2MB.');
                        logoInput.value = '';
                        return;
                    }

                    // Create file reader
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.classList.remove('hidden');

                        // Hide current logo when new one is selected
                        if (currentLogo) {
                            currentLogo.style.opacity = '0.5';
                        }
                    };

                    reader.readAsDataURL(file);
                } else {
                    // No file selected
                    hidePreview();
                }
            });

            // Handle remove preview
            removePreview.addEventListener('click', function() {
                hidePreview();
                logoInput.value = '';
            });

            function hidePreview() {
                imagePreviewContainer.classList.add('hidden');
                imagePreview.src = '';

                // Restore current logo visibility
                if (currentLogo) {
                    currentLogo.style.opacity = '1';
                }
            }
        });
    </script>
</x-app-layout>
