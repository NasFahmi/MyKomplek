@extends('layout.dashboard')
@section('title', 'Pengaturan')
@section('content')

    <div class="bg-white rounded-lg shadow p-7">
        <div class="flex items-center justify-between">
            <h1 class="mb-6 text-xl font-semibold">Pengaturan Akun</h1>


            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="#"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    {{-- <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="#"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Pengaturan</a>
                        </div>
                    </li> --}}
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="text-sm font-medium text-gray-500 ms-1 md:ms-2 dark:text-gray-400">Pengaturan</span>
                        </div>
                    </li>
                </ol>
            </nav>

        </div>
        <hr class="mb-6">
        <div class="flex flex-col gap-8 md:flex-row">
            <!-- Profile Section -->
            <div class="flex flex-col items-center w-full text-center md:w-1/3">
                <div class="relative mb-4">
                    <img class="object-cover w-32 h-32 border-4 border-gray-200 rounded-full"
                        src="{{ asset('images/profile_picture.png') }}" alt="Foto Profil">
                    {{-- <button class="absolute bottom-0 right-0 p-2 text-white bg-blue-500 rounded-full hover:bg-blue-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button> --}}
                </div>

                <h2 class="text-xl font-semibold">{{ auth()->user()->name }}</h2>
                <p class="text-gray-500">{{ auth()->user()->email }}</p>

                <form method="POST" action="{{ route('logout') }}" class="w-full mt-4">
                    @csrf
                    <button type="submit"
                        class="flex items-center justify-center w-full gap-2 px-4 py-2 text-red-500 border border-red-500 rounded-md hover:bg-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>

            <!-- Account Settings -->
            <div class="w-full md:w-2/3">
                <h3 class="mb-4 text-lg font-medium">Informasi Akun</h3>

                <div class="space-y-4">
                    {{-- Username --}}
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                        <input type="text" id="username" readonly value="{{ auth()->user()->username }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" id="email" readonly value="{{ auth()->user()->email }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                </div>

                {{-- Password Change --}}
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <h3 class="mb-4 text-lg font-medium">Ubah Password</h3>

                    <form method="POST" action="{{ route('reset-password.put') }}">
                        @csrf
                        @method('PUT')

                        {{-- Input untuk Password Saat Ini --}}
                        <div class="mb-4">
                            <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900">
                                Password Saat Ini
                            </label>
                            <input type="password" id="current_password" name="current_password" value="{{old('current_password')}}"
                                class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5
                  @error('current_password')
                      border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500
                  @else
                      border-gray-300 focus:ring-blue-500 focus:border-blue-500
                  @enderror"
                                required>
                            {{-- Blok untuk menampilkan pesan error --}}
                            @error('current_password')
                                <p class="mt-2 text-sm text-red-600"><span class="font-medium">Oops!</span> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Input untuk Password Baru --}}
                        <div class="mb-4">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                                Password Baru
                            </label>
                            <input type="password" id="password" name="password" value="{{old('password')}}"
                                class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5
                  @error('password')
                      border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500
                  @else
                      border-gray-300 focus:ring-blue-500 focus:border-blue-500
                  @enderror"
                                required>
                            {{-- Blok untuk menampilkan pesan error --}}
                            @error('password')
                                <p class="mt-2 text-sm text-red-600"><span class="font-medium">Oops!</span> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Input untuk Konfirmasi Password --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">
                                Konfirmasi Password
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}"
                                class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5
                  @error('password_confirmation')
                      border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500
                  @else
                      border-gray-300 focus:ring-blue-500 focus:border-blue-500
                  @enderror"
                                required>
                            {{-- Blok untuk menampilkan pesan error --}}
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600"><span class="font-medium">Oops!</span> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Simpan Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
