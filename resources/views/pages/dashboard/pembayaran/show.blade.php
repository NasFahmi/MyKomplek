@extends('layout.dashboard')
@section('title', 'Detail Pembayaran')

@section('content')
    <div class="bg-white rounded-lg shadow p-7">
        {{-- Header dan Breadcrumb --}}
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold">Detail Pembayaran</h1>
                <p class="mt-1 text-sm text-gray-500">Invoice #{{ $payment->code ?? $payment->id }}</p>
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
                            <svg class="w-3 h-3 mx-1 text-gray-400" fill="none" viewBox="0 0 6 10">
                                <path d="m1 9 4-4-4-4" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <a href="{{ route('pembayaran.index') }}"
                                class="text-sm font-medium text-gray-700 hover:text-blue-600">Pembayaran</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" fill="none" viewBox="0 0 6 10">
                                <path d="m1 9 4-4-4-4" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500">Detail</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="mb-6">

        {{-- MAIN CONTENT --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- Kolom Kiri: Informasi Utama --}}
            <div class="lg:col-span-1">
                <div class="p-6 border rounded-lg bg-gray-50">
                    <div class="flex items-center justify-between pb-4 border-b">
                        <h2 class="text-lg font-semibold text-gray-900">Faktur</h2>
                        <span
                            class="px-3 py-1 text-xs font-medium rounded-full {{ $payment->status == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $payment->status == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                        </span>
                    </div>
                    <dl class="mt-4 space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dibayar oleh</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900">{{ $payment->resident->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Untuk Rumah</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $payment->house->house_number }}</dd>
                            <dd class="text-sm text-gray-600">{{ $payment->house->address }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Pembayaran</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                {{ \Carbon\Carbon::parse($payment->payment_date)->isoFormat('dddd, D MMMM YYYY') }}
                            </dd>
                        </div>
                    </dl>
                </div>
                @if ($payment->status == 'belum_lunas')
                    <form action="{{ route('pembayaran.update', $payment) }}" method="post">
                        @csrf
                        @method('PATCH')

                        <button submit
                            class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-green-400 border border-gray-300 rounded-md shadow-sm gap-x-2 hover:bg-green-500">
                            Tandai Sudah Lunas
                        </button>
                    </form>
                @endif
            </div>

            {{-- Kolom Kanan: Rincian Iuran --}}
            <div class="lg:col-span-2">
                <div class="p-6 border rounded-lg bg-gray-50">
                    <h3 class="pb-3 mb-4 text-lg font-semibold text-gray-900 border-b">Rincian Pembayaran</h3>
                    <div class="flow-root">
                        <ul class="-my-4 divide-y divide-gray-200">
                            @foreach ($groupedDetails as $group)
                                <li class="py-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-base font-semibold text-gray-800">
                                                {{ $group['name'] }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Lunas hingga:
                                                {{ \Carbon\Carbon::create(null, $group['last_month'], 1)->translatedFormat('F') }}
                                                {{ $group['last_year'] }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-base font-bold text-blue-600">
                                                Rp {{ number_format($group['total'], 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Grand Total --}}
                    <div class="flex items-center justify-between pt-4 mt-6 border-t-2 border-dashed">
                        <p class="text-lg font-bold text-gray-900">Total Pembayaran</p>
                        <p class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
