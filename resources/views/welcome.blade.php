<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">

        <div class="max-w-4xl w-full space-y-12">

            {{-- Welcome Section --}}
            @php
                $hour = now()->format('H');
                if ($hour < 12) $greeting = 'Good Morning';
                elseif ($hour < 18) $greeting = 'Good Afternoon';
                else $greeting = 'Good Evening';
            @endphp
            <div class="bg-gradient-to-r from-blue-100 to-white shadow-xl rounded-3xl p-10 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full bg-blue-200 opacity-20 rounded-3xl -z-10"></div>
                <h1 class="text-5xl font-extrabold text-gray-900 mb-4 animate-fade-in">{{ $greeting }}, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-700 text-lg animate-fade-in delay-150">Welcome back to your dashboard. Enjoy your day!</p>
            </div>

            {{-- Company Info Section --}}
            <div class="bg-white shadow-2xl rounded-3xl p-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Company Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Company Name --}}
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl shadow-sm hover:shadow-md transition">
                        <svg class="w-6 h-6 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <p class="font-semibold text-gray-900">{{ $company_name ?? 'Your Company Name' }}</p>
                    </div>

                    {{-- Address --}}
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl shadow-sm hover:shadow-md transition">
                        <svg class="w-6 h-6 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-gray-700">{{ $company_address ?? '123 Business Street, Dhaka, Bangladesh' }}</p>
                    </div>

                    {{-- Phone --}}
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl shadow-sm hover:shadow-md transition">
                        <svg class="w-6 h-6 text-purple-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <p class="text-gray-700">{{ $company_phone ?? '+880 123 456 789' }}</p>
                    </div>

                    {{-- Email --}}
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl shadow-sm hover:shadow-md transition">
                        <svg class="w-6 h-6 text-red-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-700">{{ $company_email ?? 'info@company.com' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Fade-in Animation --}}
    <style>
        .animate-fade-in {
            animation: fadeIn 1s ease-in-out forwards;
            opacity: 0;
        }
        .animate-fade-in.delay-150 {
            animation-delay: 0.15s;
        }
        @keyframes fadeIn {
            to { opacity: 1; transform: translateY(0); }
            from { opacity: 0; transform: translateY(-10px); }
        }
    </style>
</x-app-layout>
