@extends('layout.dashboard')
@section('title', 'Rumah')
@section('content')

    <div class="bg-white rounded-lg shadow p-7">
        <div class="flex items-center justify-between mb-6">
            <div class="">
                <h1 class="mb-2 text-xl font-semibold ">Rumah</h1>
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
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2 dark:text-gray-400">Rumah</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="flex justify-end mb-6">
                <a href="{{ route('rumah.create') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-1">
                    + Tambah Rumah
                </a>
            </div>





        </div>
        <hr class="mb-6">
        {{-- Main content --}}
        <div class="grid gap-6 grid-cols-[repeat(auto-fit,_minmax(16rem,_1fr))]">

            {{-- Loop rumah --}}
            @forelse ($houses as $house)
                @php
                    $isActive = $house->status;
                @endphp

                {{-- Kartu Rumah --}}
                <a href="{{ route('rumah.show', ['house' => $house->id]) }}"
                    class="flex flex-col items-center justify-between p-6 text-center transition-all duration-300 transform border-2 rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 cursor-pointer
            {{ $isActive ? 'bg-green-50 border-green-400' : 'bg-gray-50 border-gray-400' }}">

                    {{-- Ikon Rumah --}}
                    <div class="mb-4 {{ $isActive ? 'text-green-500' : 'text-gray-500' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.1L3 10.1V20.1H8V14.1H16V20.1H21V10.1L12 2.1Z" />
                        </svg>
                    </div>

                    {{-- Nomor Rumah --}}
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $house->house_number }}
                    </h3>

                    {{-- Label Status --}}
                    <div
                        class="mt-4 px-4 py-1 text-xs font-semibold rounded-full
                {{ $isActive ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                        {{ $isActive ? 'Berpenghuni' : 'Tidak Berpenghuni' }}
                    </div>
                </a>

            @empty
                {{-- Tidak ada data --}}
                <div class="p-4 text-center text-gray-500 bg-gray-100 rounded-lg col-span-full">
                    Tidak ada data rumah untuk ditampilkan.
                </div>
            @endforelse

        </div>

    </div>

@endsection
