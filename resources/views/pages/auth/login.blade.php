@extends('layout.app')
@section('title', 'Login')

@section('content')
    @if (session('success'))
        <div id="toast-success"
            class="fixed z-50 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg top-5 right-5 dark:text-gray-400 dark:bg-gray-800"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Check icon</span>
            </div>
            {{-- Mengambil pesan dari session --}}
            <div class="text-sm font-normal ms-3">{{ session('success') }}</div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#toast-success" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif
    <div class="flex items-center justify-center min-h-screen px-4 bg-white md:bg-gray-100">
        <div class="w-full p-0 md:max-w-sm md:rounded-lg md:shadow-md md:p-6 md:bg-white">

            {{-- Header --}}
            <div class="px-2 mb-6 text-center">
                <div class="flex items-center justify-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="" srcset="" class="w-24 h-auto">
                </div>
                <h1 class="text-xl font-bold text-gray-800 md:text-2xl">Selamat datang di MyKomplek</h1>
                <p class="mt-1 text-xs text-gray-500">Silakan masuk untuk melanjutkan ke dashboard Anda.</p>
            </div>

            {{-- Error Message --}}
            @if (session('error'))
                <div class="px-4 py-2 mb-4 text-sm text-red-600 bg-red-100 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.auth') }}" class="px-2 space-y-4 md:px-0">
                @csrf

                {{-- Username --}}
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300"
                        required autofocus>
                    @error('username')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password"
                        class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300"
                        required>
                    @error('password')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="w-full px-4 py-2 text-white transition bg-blue-600 rounded-md hover:bg-blue-700">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
