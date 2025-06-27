@extends('layout.app')
@section('title', 'Login')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-white md:bg-gray-100 px-4">
        <div
            class="w-full md:max-w-sm  md:rounded-lg md:shadow-md md:p-6 p-0  md:bg-white">

            {{-- Header --}}
            <div class="text-center mb-6 px-2">
                <div class="flex justify-center items-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="" srcset="" class="w-24 h-auto">
                </div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">Selamat datang di MyKomplek</h1>
                <p class="text-xs text-gray-500 mt-1">Silakan masuk untuk melanjutkan ke dashboard Anda.</p>
            </div>

            {{-- Error Message --}}
            @if (session('error'))
                <div class="bg-red-100 text-red-600 px-4 py-2 rounded mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.auth') }}" class="space-y-4 px-2 md:px-0">
                @csrf

                {{-- Username --}}
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300"
                        required autofocus>
                    @error('username')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300"
                        required>
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
