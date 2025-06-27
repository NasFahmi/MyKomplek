@extends('layout.dashboard')
{{-- Memperbaiki cara menampilkan title --}}
@section('title', 'Detail Warga' . $resident->name)
@section('content')

    <div x-data="{ deleteModalOpen: false, imageModalOpen: false }" class="bg-white rounded-lg shadow p-7">
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <h1 class="text-xl font-semibold">Detail Warga {{ $resident->name }}</h1>

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
                            <a href="{{ route('rumah.index') }}"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Warga</a>
                        </div>
                    </li> --}}
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2 dark:text-gray-400">Warga</span>
                        </div>
                    </li>
                </ol>
            </nav>

        </div>
        <hr class="mb-6">

        {{-- ====================================================== --}}
        {{-- MAIN CONTENT --}}
        {{-- ====================================================== --}}
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">


            {{-- Kolom Kiri/Atas: Foto Profil --}}
            <div class="md:col-span-1">
                <div class="flex flex-col items-center text-center">
                    {{-- FIX: Tampilan Foto Identitas --}}
                    <div class="w-full max-w-xs mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-600">Foto Identitas</label>
                        {{-- FIX: Dibuat agar bisa diklik untuk membuka modal gambar --}}
                        <button @click="imageModalOpen = true" type="button"
                            class="w-full transition-transform duration-200 hover:scale-105">
                            <img class="object-contain w-full bg-gray-100 border border-gray-200 rounded-lg shadow-md aspect-video"
                                src="{{ asset('storage/' . $resident->identity_photo) }}"
                                alt="Foto Identitas {{ $resident->name }}"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/EBF4FF/7F9CF5?text=Gambar+Tidak+Tersedia';">
                        </button>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $resident->name }}</h2>
                    <p class="text-sm text-gray-500">Penghuni di Rumah {{ $resident->house }}</p>
                    <div class="flex items-center w-full max-w-xs mt-4 space-x-3">
                        <a href="{{ route('warga.edit', $resident->id) }}"
                            class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 border border-transparent rounded-md shadow-sm gap-x-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                            </svg>
                            Edit
                        </a>
                        <button @click="deleteModalOpen = true" type="button"
                            class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-red-700 transition-colors bg-red-100 border border-transparent rounded-md shadow-sm gap-x-2 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                            </svg>
                            Hapus
                        </button>
                    </div>

                </div>
            </div>
            {{-- Kolom Kanan/Bawah: Informasi Detail --}}
            <div class="md:col-span-2">
                <div class="p-6 border rounded-lg bg-gray-50">
                    <h3 class="pb-3 mb-4 text-lg font-semibold text-gray-900 border-b">Informasi Kontak & Status</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $resident->phone_number }}</dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Status Pernikahan</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                {{ $resident->married_status ? 'Menikah' : 'Belum Menikah' }}</dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Status Tinggal</dt>
                            <dd class="mt-1">
                                @if ($resident->status == 'tetap')
                                    <span
                                        class="px-3 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Tetap</span>
                                @else
                                    <span
                                        class="px-3 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded-full">Kontrak</span>
                                @endif
                            </dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Status Penghuni</dt>
                            <dd class="mt-1">
                                @if ($resident->houseResidents[0]->date_of_exit)
                                    <span class="px-3 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Sudah
                                        Keluar</span>
                                @else
                                    <span
                                        class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Masih
                                        Menghuni</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="p-6 mt-6 border rounded-lg bg-gray-50">
                    <h3 class="pb-3 mb-4 text-lg font-semibold text-gray-900 border-b">Riwayat Tinggal</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Masuk</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                {{ \Carbon\Carbon::parse($resident->houseResidents[0]->date_of_entry)->isoFormat('D MMMM YYYY') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Keluar</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                @if ($resident->houseResidents[0]->date_of_exit)
                                    {{ \Carbon\Carbon::parse($resident->houseResidents[0]->date_of_exi)->isoFormat('D MMMM YYYY') }}
                                @else
                                    <span class="italic text-gray-500">-</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>


        {{-- MODAL UNTUK MELIHAT GAMBAR IDENTITAS --}}
        <div x-show="imageModalOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="display: none;">
            <div @click="imageModalOpen = false" class="fixed inset-0 bg-black/70"></div>
            <div class="relative w-full max-w-3xl max-h-full p-4 mx-auto" @click.stop>
                <img src="{{ asset('storage/' . $resident->identity_photo) }}" alt="Foto Identitas {{ $resident->name }}"
                    class="object-contain w-full h-full">
                <button @click="imageModalOpen = false"
                    class="absolute top-0 right-0 p-2 m-2 text-white rounded-full bg-black/50 hover:bg-black/75">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        {{-- MODAL KONFIRMASI delete --}}
        <div x-show="deleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            {{-- Latar Belakang Modal --}}
            <div @click="deleteModalOpen = false" class="fixed inset-0 z-0 bg-black/50"></div>

            {{-- Konten Modal --}}
            <div class="z-10 w-full max-w-md p-6 mx-auto bg-white rounded-lg shadow-lg" @click.stop>
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <h3 class="mt-5 text-lg font-semibold text-gray-900">Hapus Data Warga</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Anda yakin ingin menghapus data Warga {{ $resident->name }}? Tindakan ini tidak dapat
                        dibatalkan.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <button @click="deleteModalOpen = false" type="button"
                        class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Batal
                    </button>
                    {{-- Tombol ini akan men-submit form delete --}}
                    <button @click="$refs.deleteForm.submit()" type="button"
                        class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>

        {{-- Form delete yang Sebenarnya (Tersembunyi) --}}
        {{-- Pastikan Anda memiliki route dengan nama 'resident.delete' --}}
        <form x-ref="deleteForm" action="{{ route('warga.destroy', $resident->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
    </div>


@endsection
