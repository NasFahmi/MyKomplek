@extends('layout.dashboard')
{{-- Memperbaiki cara menampilkan title --}}
@section('title', 'Detail Penghuni' . $houseData->house_number)
@section('content')

    <div x-data="{ checkoutModalOpen: false, imageModalOpen: false }" class="bg-white rounded-lg shadow p-7">
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <h1 class="text-xl font-semibold">Detail Penghuni Rumah {{ $houseData->house_number }}</h1>

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
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('rumah.index') }}"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Rumah</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('rumah.show', $houseData->id) }}"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ $houseData->house_number }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2 dark:text-gray-400">Penghuni</span>
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
                                src="{{ asset('storage/' . $residentData->identity_photo) }}"
                                alt="Foto Identitas {{ $residentData->name }}"
                                onerror="this.onerror=null;this.src='https://placehold.co/600x400/EBF4FF/7F9CF5?text=Gambar+Tidak+Tersedia';">
                        </button>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $residentData->name }}</h2>
                    <p class="text-sm text-gray-500">Penghuni di Rumah {{ $residentData->house }}</p>
                    {{-- button untuk edit status penghuni menjadi tidak menghuni lagi --}}
                    <div class="">
                        {{-- Tombol untuk menandai sudah keluar, hanya muncul jika belum ada tanggal keluar --}}
                        @if (!$residentData->houseResidents[0]->date_of_exit)
                            <div class="w-full mt-6">
                                <button @click="checkoutModalOpen = true" type="button"
                                    class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-orange-700 transition-colors bg-orange-100 border border-transparent rounded-md shadow-sm gap-x-2 hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" x2="9" y1="12" y2="12"></line>
                                    </svg>
                                    Tandai Sudah Keluar
                                </button>
                            </div>
                        @endif
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
                            <dd class="mt-1 text-base text-gray-900">{{ $residentData->phone_number }}</dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Status Pernikahan</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                {{ $residentData->married_status ? 'Menikah' : 'Belum Menikah' }}</dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Status Tinggal</dt>
                            <dd class="mt-1">
                                @if ($residentData->status == 'tetap')
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
                                @if ($residentData->houseResidents[0]->date_of_exit)
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
                                {{ \Carbon\Carbon::parse($residentData->houseResidents[0]->date_of_entry)->isoFormat('D MMMM YYYY') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Keluar</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                @if ($residentData->houseResidents[0]->date_of_exit)
                                    {{ \Carbon\Carbon::parse($residentData->houseResidents[0]->date_of_exi)->isoFormat('D MMMM YYYY') }}
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
                <img src="{{ asset('storage/' . $residentData->identity_photo) }}" alt="Foto Identitas {{ $residentData->name }}"
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
        {{-- MODAL KONFIRMASI CHECKOUT --}}
        <div x-show="checkoutModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <div @click="checkoutModalOpen = false" class="fixed inset-0 z-0 bg-black/50"></div>
            <div class="z-10 w-full max-w-md p-6 mx-auto bg-white rounded-lg shadow-lg" @click.stop>
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.546-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <h3 class="mt-5 text-lg font-semibold text-gray-900">Konfirmasi Status Keluar</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Anda yakin ingin menandai **{{ $residentData->name }}** sebagai sudah keluar? Tanggal keluar akan
                        diatur ke
                        hari ini.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <button @click="checkoutModalOpen = false" type="button"
                        class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Batal
                    </button>
                    <button @click="$refs.checkoutForm.submit()" type="button"
                        class="w-full px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Ya, Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    
        {{-- Form Checkout yang Sebenarnya (Tersembunyi) --}}
        {{-- Pastikan Anda memiliki route dengan nama 'resident.checkout' --}}
        <form x-ref="checkoutForm" action="{{ route('rumah.show-penghuni-checkout', ['house' =>$houseData->id, 'resident' => $residentData->id]) }}" method="POST" class="hidden">
            @csrf
            @method('PATCH')
        </form>
    </div>


@endsection
