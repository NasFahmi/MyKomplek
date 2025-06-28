@extends('layout.dashboard')
{{-- Asumsi Anda mengirimkan variabel $expense dari controller --}}
@section('title', 'Detail Pengeluaran')
@section('content')

    <div x-data="{ deleteModalOpen: false }" class="bg-white rounded-lg shadow p-7">
        {{-- Header dan Breadcrumb --}}
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold">Detail Pengeluaran</h1>
                <p class="mt-1 text-sm text-gray-500">Rincian untuk pengeluaran: {{ $expense->expense_type }}</p>
            </div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" fill="none" viewBox="0 0 6 10" stroke="currentColor"
                                stroke-width="2">
                                <path d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('pengeluaran.index') }}"
                                class="text-sm font-medium text-gray-700 hover:text-blue-600">Pengeluaran</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" fill="none" viewBox="0 0 6 10" stroke="currentColor"
                                stroke-width="2">
                                <path d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500">Detail</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="mb-8">

        {{-- MAIN CONTENT --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- Kolom Kiri: Ringkasan & Aksi --}}
            <div class="lg:col-span-1">
                <div class="flex flex-col items-center p-6 text-center border rounded-lg bg-gray-50">
                    {{-- Ikon Kategori (Contoh dinamis) --}}
                    <div class="flex items-center justify-center w-20 h-20 text-blue-600 bg-blue-100 rounded-full">
                        @switch($expense->category)
                            @case('Gaji')
                                <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12,12A5,5,0,0,0,7,7,5,5,0,0,0,2,12a5,5,0,0,0,5,5,5,5,0,0,0,5-5m0,2a3,3,0,0,1-3-3,3,3,0,0,1,3-3,3,3,0,0,1,3,3,3,3,0,0,1-3,3M22,12a5,5,0,0,0-5-5,5,5,0,0,0-5,5,5,5,0,0,0,5,5,5,5,0,0,0,5-5m0,2a3,3,0,0,1-3-3,3,3,0,0,1,3-3,3,3,0,0,1,3,3,3,3,0,0,1-3,3Z" />
                                </svg>
                            @break

                            @case('Listrik')
                                <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12,2A7,7,0,0,0,5,9c0,2.38,1.19,4.47,3,5.74V17a1,1,0,0,0,1,1h6a1,1,0,0,0,1-1V14.74c1.81-1.27,3-3.36,3-5.74A7,7,0,0,0,12,2Z" />
                                </svg>
                            @break

                            @default
                                <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14,10H19.5L14,2V8H9.5L15,16V10M5,10V22H19V20H7V10H5Z" />
                                </svg>
                        @endswitch
                    </div>

                    <p class="mt-4 text-sm font-semibold text-gray-600">{{ $expense->expense_type }}</p>
                    <p class="mt-1 text-4xl font-bold tracking-tight text-gray-900">Rp
                        {{ number_format($expense->amount, 0, ',', '.') }}</p>
                    <p class="mt-1 text-sm text-gray-500">Dicatat pada
                        {{ \Carbon\Carbon::parse($expense->date)->isoFormat('D MMMM YYYY') }}</p>
                </div>
                <div class="flex items-center mt-4 space-x-3">
                    <a href="{{ route('pengeluaran.edit', $expense->id) }}"
                        class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 border border-transparent rounded-md shadow-sm gap-x-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                        </svg>
                        Edit
                    </a>
                    <button @click="deleteModalOpen = true" type="button"
                        class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-red-700 transition-colors bg-red-100 border border-transparent rounded-md shadow-sm gap-x-2 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M3 6h18" />
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        </svg>
                        Hapus
                    </button>
                </div>
            </div>

            {{-- Kolom Kanan: Rincian --}}
            <div class="lg:col-span-2">
                <div class="p-6 border rounded-lg bg-gray-50">
                    <h3 class="pb-3 mb-4 text-lg font-semibold text-gray-900 border-b">Rincian Pengeluaran</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $expense->category }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $expense->payment_method }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                            <dd class="mt-1 text-base prose-sm text-gray-900 max-w-none">
                                {{ $expense->description ?? 'Tidak ada deskripsi.' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        {{-- MODAL KONFIRMASI HAPUS --}}
        <div x-show="deleteModalOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="display: none;">
            <div @click="deleteModalOpen = false" class="fixed inset-0 bg-black/50"></div>
            <div class="relative z-50 w-full max-w-md p-6 mx-auto bg-white rounded-lg shadow-lg"
                @click.away="deleteModalOpen = false">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <h3 class="mt-5 text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Anda yakin ingin menghapus data pengeluaran ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <button @click="deleteModalOpen = false" type="button"
                        class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Batal
                    </button>
                    <button @click="$refs.deleteForm.submit()" type="button"
                        class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>

        <form x-ref="deleteForm" action="{{ route('pengeluaran.destroy', $expense->id) }}" method="POST"
            class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
