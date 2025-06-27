@props(['isOpen' => false])

@php
    use Illuminate\Support\Str;

    $menus = [
        ['route' => 'dashboard.index', 'label' => 'Dashboard', 'icon' => 'ic_home'],
        ['route' => 'rumah.index', 'label' => 'Rumah', 'icon' => 'ic_house'],
        ['route' => 'warga.index', 'label' => 'Warga', 'icon' => 'ic_users'],
        ['route' => 'pembayaran.index', 'label' => 'Pembayaran', 'icon' => 'ic_credit_card'],
        ['route' => 'pengeluaran.index', 'label' => 'Pengeluaran', 'icon' => 'ic_expense'],
        ['route' => 'pengaturan.index', 'label' => 'Pengaturan', 'icon' => 'ic_settings'],
    ];

    $currentRoute = Route::currentRouteName();
    $activeRouteGroup = Str::before($currentRoute, '.'); // Ambil bagian awal prefix seperti "rumah", "warga", dst
@endphp

{{-- Desktop Sidebar --}}
<aside class="w-[280px] bg-white overflow-y-auto text-black hidden md:flex flex-col">
    <div class="flex items-center justify-center gap-3 mb-12 mt-7">
        <img src="{{ asset('images/logo.png') }}" alt="" class="w-10 h-auto">
        <h1 class="font-bold text-[#192853]">My Komplek</h1>
    </div>
    <nav class="flex flex-col pr-4 mb-12 gap-9">
        @foreach ($menus as $menu)
            @php
                $menuGroup = Str::before($menu['route'], '.');
                $isActive = $activeRouteGroup === $menuGroup;
            @endphp
            <a href="{{ route($menu['route']) }}"
               class="relative flex items-center gap-5 px-4 py-3 transition-colors duration-200 ease-in-out
               {{ $isActive ? 'text-[#6c8bf5] font-medium' : 'text-[#B1B1B1] hover:text-[#7a7a7a]' }}">
                @if ($isActive)
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-[#6c8bf5] rounded-r-md"></span>
                @endif
                <div class="w-7 h-7 ml-3.5 [&>svg]:w-full [&>svg]:h-full [&>svg]:fill-current">
                    {!! file_get_contents(public_path("icon/{$menu['icon']}.svg")) !!}
                </div>
                <span>{{ $menu['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>

{{-- Mobile Sidebar --}}
<div class="flex md:hidden">
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black bg-opacity-20" x-cloak>
    </div>

    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed top-0 left-0 z-50 w-64 h-full overflow-y-auto text-black bg-white shadow-xl" x-cloak>
        <div class="flex items-center justify-between p-4 mt-2 mb-12">
            <button @click="sidebarOpen = false">
                <svg class="w-8 h-8 text-black" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6.995 7.006a1 1 0 0 1 1.414 0L12 10.586l3.591-3.58a1 1 0 1 1 1.414 1.414L13.414 12l3.59 3.591a1 1 0 0 1-1.414 1.414L12 13.414l-3.591 3.591a1 1 0 0 1-1.414-1.414L10.586 12 6.995 8.409a1 1 0 0 1 0-1.403z" />
                </svg>
            </button>
            <div class="flex items-center justify-center w-7/12">
                <img src="{{ asset('images/logo.png') }}" alt="" class="w-20 h-auto">
            </div>
        </div>

        <nav class="flex flex-col pr-4 mb-12 gap-9">
            @foreach ($menus as $menu)
                @php
                    $menuGroup = Str::before($menu['route'], '.');
                    $isActive = $activeRouteGroup === $menuGroup;
                @endphp
                <a href="{{ route($menu['route']) }}" @click="sidebarOpen = false"
                   class="relative flex items-center gap-5 px-4 py-3 transition-colors duration-200 ease-in-out
                   {{ $isActive ? 'text-[#6c8bf5] font-medium' : 'text-[#B1B1B1] hover:text-[#7a7a7a]' }}">
                    @if ($isActive)
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-[#6c8bf5] rounded-r-md"></span>
                    @endif
                    <div class="w-7 h-7 ml-3.5 [&>svg]:w-full [&>svg]:h-full [&>svg]:fill-current">
                        {!! file_get_contents(public_path("icon/{$menu['icon']}.svg")) !!}
                    </div>
                    <span>{{ $menu['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>
</div>
