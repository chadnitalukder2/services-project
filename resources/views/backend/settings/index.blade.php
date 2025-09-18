<x-app-layout>
    <x-message />
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="">

                <h2 class="text-xl font-bold mb-4">Site Settings</h2>

                <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $setting->title ?? '') }}"
                            class="border p-2 w-full rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Address</label>
                        <input type="text" name="address" value="{{ old('address', $setting->address ?? '') }}"
                            class="border p-2 w-full rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $setting->phone ?? '') }}"
                            class="border p-2 w-full rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $setting->email ?? '') }}"
                            class="border p-2 w-full rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Currency</label>
                        <input type="text" name="currency" value="{{ old('currency', $setting->currency ?? '') }}"
                            placeholder="e.g., USD, BDT" class="border p-2 w-full rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Currency Position</label>
                        <select name="currency_position" class="border p-2 w-full rounded">
                            <option value="left"
                                {{ ($setting->currency_position ?? 'left') == 'left' ? 'selected' : '' }}>Left ($ 100)
                            </option>
                            <option value="right"
                                {{ ($setting->currency_position ?? '') == 'right' ? 'selected' : '' }}>
                                Right (100 $)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Logo</label>
                        <input type="file" name="logo" id="logoInput" class="border p-2 w-full rounded"
                            accept="image/*">

                        <!-- Image Preview Container -->
                        <div class="mt-3">
                            <!-- Current Logo -->
                            @if (!empty($setting->logo))
                                <div id="currentLogo">
                                    <p class="text-sm text-gray-600 mb-2">Current Logo:</p>
                                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="Current Logo"
                                        class="h-20 w-auto border rounded shadow-sm">
                                </div>
                            @endif

                            <!-- Preview Container (initially hidden) -->
                            <div id="imagePreviewContainer" class="hidden">
                                <p class="text-sm text-gray-600 mb-2 mt-4">New Logo Preview:</p>
                                <div class="relative inline-block">
                                    <img id="imagePreview" src="" alt="Preview"
                                        class="h-20 w-auto border rounded shadow-sm">
                                    <button type="button" id="removePreview"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition duration-200">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Message</label>
                        <textarea name="message" rows="4" class="border p-2 w-full rounded" placeholder="Enter your site message...">{{ old('message', $setting->message ?? '') }}</textarea>
                    </div>

                    <div>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition duration-200">
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
