<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarOpen: false }" class="bg-[#F5F7FA] h-screen overflow-hidden">
    <div class="block md:flex h-full w-full">
        <!-- Sidebar -->
        <x-dashboard.sidebar  />

        <!-- Main Content -->
        <div class="relative flex flex-col w-full h-full overflow-hidden bg-[#F5F7FA]">
            <!-- Header -->
            <x-dashboard.header  />

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-4">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
