@extends('layout.dashboard')
@section('title', 'Pengaturan')
@section('content')
    <!-- Breadcrumb -->
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard.index') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Pengaturan</span>
                </div>
            </li>
        </ol>
    </nav>

    <h1 class="mb-6 text-2xl font-bold">Pengaturan Akun</h1>
    {{auth()->user()    }}

    <div class="p-6 bg-white rounded-lg shadow">
        <div class="flex flex-col gap-8 md:flex-row">
            <!-- Profile Section -->
            <div class="w-full md:w-1/3">
                <div class="flex flex-col items-center">
                    <!-- Profile Photo -->
                    <div class="relative mb-4">
                        {{-- <img class="object-cover w-32 h-32 border-4 border-gray-200 rounded-full"
                            src="{{ auth()->user()->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="Profile photo"> --}}
                        <button
                            class="absolute bottom-0 right-0 p-2 text-white transition bg-blue-500 rounded-full hover:bg-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>

                    <h2 class="text-xl font-semibold">{{ auth()->user() }}</h2>
                    <p class="text-gray-500">{{ auth()->user() }}</p>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="w-full mt-4">
                        @csrf
                        <button type="submit"
                            class="flex items-center justify-center w-full gap-2 px-4 py-2 text-red-500 transition border border-red-500 rounded-md hover:bg-red-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Account Information Section -->
            <div class="w-full md:w-2/3">
                <h3 class="mb-4 text-lg font-medium">Informasi Akun</h3>

                <div class="space-y-4">
                    <!-- Username -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Username</label>
                        <div class="flex mt-1 rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center px-3 text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50 sm:text-sm">
                                @
                            </span>
                            <input type="text" value="{{ auth()->user() }}"
                                class="flex-1 block w-full min-w-0 px-3 py-2 bg-white border border-gray-300 rounded-none rounded-r-md"
                                readonly>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" value="{{ auth()->user() }}"
                            class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm"
                            readonly>
                    </div>

                    <!-- Change Password Form -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="mb-4 text-lg font-medium">Ubah Password</h3>

                        <form method="POST" action="{{ route('reset-password.put') }}">
                            @csrf
                            @method('PUT')

                            <!-- Current Password -->
                            <div class="mb-4">
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat
                                    Ini</label>
                                <input type="password" name="current_password" id="current_password"
                                    autocomplete="current-password"
                                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>

                            <!-- New Password -->
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <input type="password" name="password" id="password" autocomplete="new-password"
                                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    autocomplete="new-password"
                                    class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Simpan Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
