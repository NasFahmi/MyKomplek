@extends('layout.dashboard')
@section('title', 'Edit Pengeluaran')

@section('content')
    <div class="bg-white rounded-lg shadow p-7">
        {{-- Header dan Breadcrumb --}}
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <h1 class="text-xl font-semibold">Edit Pengeluaran {{ $expense->expense_type }}</h1>
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
                            <a href="{{ route('pengeluaran.index') }}"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2">Pengeluaran</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('pengeluaran.show', ['expense' => $expense->id]) }}"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2">{{ $expense->expense_type }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="mb-6">

        {{-- MAIN CONTENT - FORM --}}
        <form action="{{ route('pengeluaran.update', ['expense' => $expense->id]) }}" method="POST">
            @csrf
            @method('patch')
            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    {{-- FIX: Jenis Pengeluaran diubah menjadi input teks --}}
                    <div>
                        <label for="expense_type_name" class="block mb-2 text-sm font-medium">Jenis Pengeluaran</label>
                        <input type="text" id="expense_type_name" name="expense_type"
                            value="{{ $expense->expense_type }}" placeholder="Contoh: Gaji Satpam"
                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('expense_type') border-red-500 @enderror"
                            required>
                        @error('expense_type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jumlah/Nominal --}}
                    <div>
                        <label for="amount" class="block mb-2 text-sm font-medium">Jumlah</label>
                        <input type="number" id="amount" name="amount" value="{{ $expense->amount }}"
                            placeholder="Contoh: 500000"
                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                        @error('amount')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- FIX: Kategori diubah menjadi input teks --}}
                    <div>
                        <label for="category" class="block mb-2 text-sm font-medium">Kategori</label>
                        <input type="text" id="category" name="category" value="{{ $expense->category }}"
                            placeholder="Contoh: Operasional"
                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category') border-red-500 @enderror"
                            required>
                        @error('category')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div>
                        <label for="payment_method" class="block mb-2 text-sm font-medium">Metode Pembayaran</label>
                        <select id="payment_method" name="payment_method"
                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-9 focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option selected disabled value="">Pilih metode</option>
                            <option value="Tunai" {{ $expense->payment_method == 'Tunai' ? 'selected' : '' }}>Tunai
                            </option>
                            <option value="Transfer Bank"
                                {{ $expense->payment_method == 'Transfer Bank' ? 'selected' : '' }}>
                                Transfer Bank</option>
                        </select>
                        @error('payment_method')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="md:col-span-2">
                        <label for="date" class="block mb-2 text-sm font-medium">Tanggal Pengeluaran</label>

                        <div class="relative w-full">
                            <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-autohide" datepicker datepicker-autohide type="text" name="date"
                                value="{{ old('effective_date', $expense->date ? \Carbon\Carbon::parse($expense->date)->format('m/d/Y') : '') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Select date">
                        </div>

                        @error('date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="md:col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium">Deskripsi (Opsional)</label>
                        <textarea id="description" name="description" rows="4"
                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Masukkan catatan atau deskripsi tambahan...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $expense->description }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end mt-8 gap-x-2">
                    <a href="{{ route('pengeluaran.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 align-middle transition-all bg-white border rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-semibold text-white transition-all bg-blue-500 border border-transparent rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Simpan Pengeluaran
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
