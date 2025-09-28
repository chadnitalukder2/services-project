<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title & Filters -->
       <div class="mb-8">
    @php
        $hour = now('Asia/Dhaka')->format('H');

        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Good Morning';
            $borderColor = 'border-green-500';
            $bgColor = 'bg-green-50';
            $textColor = 'text-green-700';
            $icon = '<i class="fa-solid fa-sun text-green-500"></i>'; // morning sun
        } elseif ($hour >= 12 && $hour < 13) {
            $greeting = 'Good Noon';
            $borderColor = 'border-amber-500';
            $bgColor = 'bg-amber-50';
            $textColor = 'text-amber-700';
            $icon = '<i class="fa-solid fa-sun text-amber-500"></i>'; // noon sun
        } elseif ($hour >= 13 && $hour < 17) {
            $greeting = 'Good Afternoon';
            $borderColor = 'border-yellow-500';
            $bgColor = 'bg-yellow-50';
            $textColor = 'text-yellow-700';
            $icon = '<i class="fa-solid fa-sun text-yellow-500"></i>'; // afternoon sun
        } elseif ($hour >= 17 && $hour < 21) {
            $greeting = 'Good Evening';
            $borderColor = 'border-orange-500';
            $bgColor = 'bg-orange-50';
            $textColor = 'text-orange-700';
            $icon = '<i class="fa-solid fa-city text-orange-500"></i>'; // evening city
        } else {
            $greeting = 'Good Night';
            $borderColor = 'border-indigo-500';
            $bgColor = 'bg-indigo-50';
            $textColor = 'text-indigo-700';
            $icon = '<i class="fa-solid fa-moon text-indigo-500"></i>'; // night moon
        }

        $username = ucwords(strtolower(Auth::user()->name));
        $fullMessage = "$icon $greeting, $username!";
        $currentTime = now('Asia/Dhaka')->format('g:i A');
        $currentDate = now('Asia/Dhaka')->format('F j, Y');
    @endphp

    <div class="bg-white rounded-xl px-5 py-3 border-l-4 {{ $borderColor }}">
        <h1 class="text-sm font-medium {{ $textColor }} mb-1">
            {!! $fullMessage !!} {{-- Use {!! !!} to render HTML icons --}}
        </h1>
        <p class="text-gray-600 text-xs">
            Welcome back! Let’s make today productive and successful.
            <span class="ml-2 text-gray-500">({{ $currentTime }} • {{ $currentDate }})</span>
        </p>
    </div>
</div>



        <!-- Company Info & Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm border p-6  mx-auto">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Information</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Company Name -->
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $settings->title ?? 'Tech Solutions Ltd' }}</p>
                        <p class="text-xs text-gray-500"> Company Name</p>
                    </div>
                </div>

                <!-- Address -->
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">
                            {{ $settings->address ?? 'Gulshan Avenue, Dhaka, Bangladesh' }}</p>
                        <p class="text-xs text-gray-500"> Address</p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $$settings->phone ?? '+880 123 456 789' }}</p>
                        <p class="text-xs text-gray-500">Contact Number</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $settings->email ?? 'contact@techsolutions.com' }}</p>
                        <p class="text-xs text-gray-500">Company Email</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const message = @json($fullMessage);
            const container = document.getElementById('welcomeMessage');
            let i = 0;

            function typeWriter() {
                if (i < message.length) {
                    container.innerHTML += message.charAt(i);
                    i++;
                    setTimeout(typeWriter, 100); // typing speed
                }
            }
            typeWriter();
        });
    </script>
</x-app-layout>
