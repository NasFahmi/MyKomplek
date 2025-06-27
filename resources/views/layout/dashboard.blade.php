<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />


    @include('layout.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

</head>

<body x-data="{ sidebarOpen: false }" class="bg-[#F5F7FA] h-screen overflow-hidden">
    <x-toast />
    <div class="block w-full h-full md:flex">
        <!-- Sidebar -->
        <x-dashboard.sidebar />

        <!-- Main Content -->
        <div class="relative flex flex-col w-full h-full overflow-hidden bg-[#F5F7FA]">
            <!-- Header -->
            <x-dashboard.header />

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto md:px-9 md:py-6">
                @yield('content')
            </div>
        </div>
    </div>

    @include('layout.scriptjs')
</body>

</html>
