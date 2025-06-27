@props(['currentPath' => '/dashboard'])

@php
    $routeNames = [
        'dashboard' => 'Dashboard',
        'rumah' => 'Rumah',
        'warga' => 'Warga',
        'pembayaran' => 'Pembayaran',
        'pengeluaran' => 'Pengeluaran',
        'pengaturan' => 'Pengaturan',
    ];

    $currentName = Route::currentRouteName();
    $title = 'Dashboard';

    foreach ($routeNames as $key => $label) {
        if (Str::startsWith($currentName, $key)) {
            $title = $label;
            break;
        }
    }
@endphp

<header class="sticky top-0 z-10 flex flex-col gap-5 p-4 bg-white shadow">
    <div class="flex items-center justify-between">
        {{-- Hamburger Menu for Mobile --}}
        <button class="text-gray-600 md:hidden focus:outline-none" @click="sidebarOpen = true">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H20" stroke="#000000" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>

        {{-- Title --}}
        <h2 class="text-xl text-[#192853] font-semibold">{{ $title }}</h2>

        {{-- Right Icons --}}
        <div class="flex items-center space-x-4">


            <a href="{{ route('pengaturan.index') }}" class="hidden cursor-pointer md:block">
                <div class="flex items-center justify-center w-10 h-10 text-red-700 rounded-full bg-red-50">
                    {{-- Inline SVG --}}
                    {!! file_get_contents(public_path('icon/ic_settings_outline.svg')) !!}
                </div>

            </a>


            <!-- Profile Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                    <div class="w-10 h-10 bg-[#F5F7FA] rounded-full overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('images/profile_picture.png') }}" alt="Profile"
                            class="object-cover w-full h-full" />
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.outside="open = false" x-transition
                    class="absolute right-0 z-50 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-lg">

                    <div class="px-4 py-2 text-sm text-gray-700">
                        {{ auth()->user()->name ?? 'Pengguna' }}
                    </div>
                    <div class="border-t"></div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-100">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>


        </div>
    </div>

</header>
