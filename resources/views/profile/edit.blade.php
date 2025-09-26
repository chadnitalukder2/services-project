<x-app-layout>

  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 lg:py-12 py-8 px-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">User Profile Information</h2>
       <div class="">
        <div class=" mx-auto   space-y-6">
            
            <!-- Profile Information -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
    </div>




  
</x-app-layout>
