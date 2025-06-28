@extends('layout.dashboard')
@section('title', 'Detail Iuran ' . $feeType->name)
@section('content')

    <div x-data="{ deleteModalOpen: false }" class="bg-white rounded-lg shadow p-7">
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <h1 class="text-xl font-semibold">Detail Iuran: {{ $feeType->name }}</h1>

            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
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
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('pembayaran.index') }}"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2">Pembayaran</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Detail</span>
                        </div>
                    </li>
                </ol>
            </nav>

        </div>
        <hr class="mb-6">

        {{-- ====================================================== --}}
        {{-- MAIN CONTENT --}}
        {{-- ====================================================== --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- Kolom Kiri: Informasi Iuran --}}
            <div class="lg:col-span-1">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Informasi Iuran</h2>
                <div class="p-6 border rounded-lg bg-gray-50">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Iuran</dt>
                            <dd class="mt-1 text-xl font-bold text-gray-900">{{ $feeType->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nominal</dt>
                            <dd class="mt-1 text-3xl font-extrabold tracking-tight text-blue-600">Rp
                                {{ number_format($feeType->amount, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                            <dd class="mt-1 text-base text-gray-700">{{ $feeType->description ?? 'Tidak ada deskripsi.' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Berlaku</dt>
                            <dd class="mt-1 text-base text-gray-700">
                                {{ \Carbon\Carbon::parse($feeType->effective_date)->format('d-m-Y') }}

                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @if ($feeType->is_active)
                                    <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
                {{-- Tombol Aksi --}}
                <div class="flex items-center mt-4 space-x-3">
                    <a href="{{ route('pembayaran.fee-type.edit', $feeType->id) }}"
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

            {{-- Kolom Kanan: Riwayat Pembayaran --}}
            <div class="lg:col-span-2">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Riwayat Pembayaran</h2>
                <div class="relative overflow-x-auto border rounded-lg shadow-sm">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama Pembayar</th>
                                <th scope="col" class="px-6 py-3">Tanggal Bayar</th>
                                <th scope="col" class="px-6 py-3 text-right">Jumlah</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- FIX: Menggunakan @forelse dan looping pada relasi yang benar --}}
                            @forelse ($feeType->paymentDetails as $detail)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{-- Asumsi relasi: PaymentDetail -> Payment -> Resident --}}
                                        {{ $detail->payment->resident->name ?? 'N/A' }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($detail->payment->payment_date)->isoFormat('D MMMM YYYY') }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-right text-gray-800">
                                        {{-- FIX: Menghapus kurung kurawal ganda --}}
                                        Rp {{ number_format($detail->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                            {{ ucfirst($detail->payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                {{-- FIX: Menampilkan pesan jika tidak ada data --}}
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-500">
                                        Belum ada riwayat pembayaran untuk iuran ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                    <h3 class="mt-5 text-lg font-semibold text-gray-900">Konfirmasi Hapus Iuran</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Anda yakin ingin menghapus iuran <strong>{{ $feeType->name }}</strong>? Tindakan ini akan menghapus
                        semua data terkait dan tidak dapat dibatalkan.
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

        {{-- Form Delete yang Sebenarnya (Tersembunyi) --}}
        <form x-ref="deleteForm" action="{{ route('pembayaran.fee-type.destroy', $feeType->id) }}" method="POST"
            class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
