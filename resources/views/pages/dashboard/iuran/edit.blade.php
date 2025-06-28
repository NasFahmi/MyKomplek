@extends('layout.dashboard')
{{-- Memperbaiki cara menampilkan title --}}
@section('title', 'Edit Iuran')
@section('content')

    <div class="bg-white rounded-lg shadow p-7">
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <h1 class="text-xl font-semibold">Edit Iuran</h1>

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
                            <a href="{{ route('pembayaran.fee-type.show', $feeType->id) }}"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Iuran</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2 dark:text-gray-400">Edit</span>
                        </div>
                    </li>
                </ol>
            </nav>

        </div>
        <hr class="mb-6">

        {{-- ====================================================== --}}
        {{-- MAIN CONTENT --}}
        {{-- ====================================================== --}}
        <form action="{{ route('pembayaran.fee-type.update', $feeType->id) }}" method="post">
            @method('PUT')
            @csrf
            {{-- Nama Lengkap --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div class="mb-4">
                    <label for="feeType_name" class="block mb-2 text-sm font-medium text-gray-900">
                        Nama Iuran
                    </label>
                    <input type="text" id="feeType_name" name="name" value="{{ $feeType->name }}"
                        placeholder="Nama Iuran"
                        class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5
                          @error('name')
                              border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500
                          @else
                              border-gray-300 focus:ring-blue-500 focus:border-blue-500
                          @enderror"
                        required>
                    {{-- Blok untuk menampilkan pesan error --}}
                    @error('name')
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium">Oops!</span> {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Alamat Lengkap --}}
                <div class="mb-4">
                    <label for="amound" class="block mb-2 text-sm font-medium text-gray-900">
                        Nominal
                    </label>
                    <input type="number" id="amound" name="amount" value="{{ $feeType->amount }}"
                        placeholder="Nominal Iuran"
                        class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5
                          @error('amount')
                              border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500
                          @else
                              border-gray-300 focus:ring-blue-500 focus:border-blue-500
                          @enderror"
                        required>
                    {{-- Blok untuk menampilkan pesan error --}}
                    @error('amount')
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium">Oops!</span> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                {{-- Status  --}}
                <div>
                    <label for="status" class="block mb-2 text-sm font-medium ">Status Iuran</label>
                    <label for="hs-basic-usage" class="relative flex items-center p-3 border border-gray-200 rounded-lg">

                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="hs-basic-usage" name="is_active"
                            @if (old('status', $feeType->is_active)) checked @endif
                            class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500"
                            value="1">
                        <span class="text-sm text-gray-500 ms-3 dark:text-gray-400">Aktif</span>
                    </label>
                </div>

                {{-- tanggal berlaku --}}

                <div class="">
                    <label for="effective_date" class="block mb-2 text-sm font-medium">Tanggal Berlaku</label>

                    <div class="relative w-full">
                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>  
                        <input id="datepicker-autohide" datepicker datepicker-autohide type="text" name="effective_date"
                            value="{{ old('effective_date', $feeType->effective_date ? \Carbon\Carbon::parse($feeType->effective_date)->format('m/d/Y') : '') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select date">


                    </div>

                    @error('effective_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>


            {{-- deskripsi --}}
            <div class="mt-4">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">
                    Deskripsi
                </label>
                <textarea id="description" name="description" placeholder="Masukkan deskripsi" rows="4"
                    class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5
          @error('description')
              border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500
          @else
              border-gray-300 focus:ring-blue-500 focus:border-blue-500
          @enderror">{{ $feeType->description }}</textarea>
                {{-- Blok untuk menampilkan pesan error --}}
                @error('description')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>
            <div class="">
                {{-- Tombol Aksi --}}
                <div class="flex justify-end mt-8 gap-x-2">
                    <a href="{{ route('rumah.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 align-middle transition-all bg-white border rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-semibold text-white transition-all bg-blue-500 border border-transparent rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Simpan Penghuni
                    </button>
                </div>
            </div>
        </form>


    </div>
@endsection
