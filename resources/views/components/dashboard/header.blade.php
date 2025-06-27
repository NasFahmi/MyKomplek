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
            <div class="hidden md:block">
                {{-- <x-dashboard.search-bar /> --}}
            </div>


            <a href="{{ route('pengaturan.index') }}" class="hidden md:block cursor-pointer">
                <div class="w-10 h-10 flex items-center justify-center bg-red-50 rounded-full text-red-700">
                    {{-- Inline SVG --}}
                    {!! file_get_contents(public_path('icon/ic_settings_outline.svg')) !!}
                </div>

            </a>


            <div class="flex md:block cursor-pointer items-center space-x-4 w-[40px] h-[40px]">
                <div class="w-10 h-10 flex items-center justify-center bg-[#F5F7FA] rounded-full overflow-hidden">
                    <img src="{{ asset('images/profile_picture.png') }}" alt="Profile"
                        class="w-full h-full object-cover" />
                </div>
            </div>

        </div>
    </div>

    {{-- SearchBar for Mobile --}}
    <div class="mt-2 md:hidden">

    </div>
</header>
