<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:400,500,600" rel="stylesheet" />
    @include('layout.head')
    <!-- Styles / Scripts -->
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

<body class="">
    @yield('content')
    <x-toast />
    @include('layout.scriptjs')
</body>

</html>
