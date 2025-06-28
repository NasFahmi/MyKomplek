@extends('layout.dashboard')
{{-- Memperbaiki cara menampilkan title --}}
@section('title', 'Tambah Warga')
@section('content')

    <div class="bg-white rounded-lg shadow p-7">
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <h1 class="text-xl font-semibold">Tambah Warga</h1>

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
                            <a href="{{ route('warga.index') }}"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Warga</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2 dark:text-gray-400">Tambah</span>
                        </div>
                    </li>
                </ol>
            </nav>

        </div>
        <hr class="mb-6">

        {{-- ====================================================== --}}
        {{-- MAIN CONTENT --}}
        {{-- ====================================================== --}}
        {{-- MAIN CONTENT - FORM --}}
        <form action="{{ route('warga.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

                {{-- Kolom Kiri --}}
                <div class="space-y-6">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                            required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor Telepon --}}
                    <div>
                        <label for="phone_number" class="block mb-2 text-sm font-medium">Nomor Telepon</label>
                        <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('phone_number') border-red-500 @enderror"
                            required>
                        @error('phone_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Penghuni --}}
                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium">Status Penghuni</label>
                        <select id="status" name="status"
                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-9 focus:border-blue-500 focus:ring-blue-500">
                            <option value="tetap" {{ old('status') == 'tetap' ? 'selected' : '' }}>Tetap</option>
                            <option value="kontrak" {{ old('status') == 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                        </select>
                    </div>

                    {{-- Status Menikah --}}
                    <div>
                        <label class="block mb-2 text-sm font-medium">Status Menikah</label>
                        <label for="married_status-checkbox"
                            class="relative flex items-center p-3 border border-gray-200 rounded-lg">
                            {{-- FIX: Hidden input untuk memastikan nilai '0' terkirim jika tidak dicentang --}}
                            <input type="hidden" name="married_status" value="0">
                            <input type="checkbox" id="married_status-checkbox" name="married_status"
                                class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500"
                                value="1" @if (old('married_status')) checked @endif>
                            <span class="text-sm text-gray-500 ms-3">Sudah Menikah</span>
                        </label>
                    </div>
                </div>

                {{-- Kolom Kanan: File Upload --}}
                <div class="space-y-2">
                    <label for="identity_photo" class="block text-sm font-medium">Foto Identitas (KTP/SIM)</label>
                    {{-- FIX: Menggunakan implementasi file upload yang lebih andal dengan preview --}}
                    <div id="image-preview-container">
                        <label for="identity_photo_input"
                            class="relative flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div id="placeholder" class="absolute flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-center text-gray-500"><span class="font-semibold">Klik untuk
                                        unggah</span> atau seret</p>
                                <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
                            </div>
                            <img id="image-preview" src="" alt="Pratinjau Gambar"
                                class="hidden object-contain w-full h-full p-2 rounded-lg" />
                        </label>
                        {{-- Ini adalah input yang sebenarnya, yang akan mengirim file ke server --}}
                        <input id="identity_photo_input" name="identity_photo" type="file" class="hidden"
                            accept="image/*" />
                    </div>
                    @error('identity_photo')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8">
                <label for="house" class="block mb-2 text-sm font-medium">Rumah Penghuni</label>
                <select id="house" name="house"
                    class="block w-full rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach ($house as $item)
                        <option value="{{ $item->id }}" {{ old('house') == $item->id ? 'selected' : '' }}>
                            {{ $item->house_number }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end mt-8 gap-x-2">
                <a href="{{ route('warga.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 align-middle transition-all bg-white border rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-semibold text-white transition-all bg-blue-500 border border-transparent rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Simpan Penghuni
                </button>
            </div>
        </form>


    </div>


    {{-- Skrip untuk menangani pratinjau gambar (image preview) --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script>
        new TomSelect("#house", {
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const identityPhotoInput = document.getElementById('identity_photo_input');
            const imagePreview = document.getElementById('image-preview');
            const placeholder = document.getElementById('placeholder');

            identityPhotoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

@endsection
