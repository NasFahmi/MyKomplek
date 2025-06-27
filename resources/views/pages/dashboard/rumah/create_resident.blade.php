@extends('layout.dashboard')
@section('title', 'Tambah Penghuni')
@section('content')

    <div class="bg-white rounded-lg shadow p-7">
        {{-- Header dan Breadcrumb --}}
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <h1 class="text-xl font-semibold">Tambah Penghuni untuk Rumah {{ $house->house_number }}</h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="#"
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
                            <a href="{{ route('rumah.index') }}"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2">Rumah</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>

                            <a href="{{ route('rumah.show', $house->id) }}"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2">{{ $house->house_number }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Tambah Penghuni</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="mb-6">

        {{-- ====================================================== --}}
        {{-- MAIN CONTENT - FORM --}}
        {{-- ====================================================== --}}
        <form action="{{ route('rumah.store-penghuni', $house->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                {{-- Kolom Kiri --}}
                <div class="space-y-6">
                    {{-- Nama Lengkap --}}
                    <div class="mb-4">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                            Nama Lengkap
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Nama Penghuni"
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


                    {{-- nomor telepon --}}
                    <div class="mb-4">
                        <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900">
                            Nomor Telepon
                        </label>
                        <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                            placeholder="Nama Penghuni"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5
                  @error('phone_number')
                      border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500
                  @else
                      border-gray-300 focus:ring-blue-500 focus:border-blue-500
                  @enderror"
                            required>
                        {{-- Blok untuk menampilkan pesan error --}}
                        @error('phone_number')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">Oops!</span> {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Status Penghuni --}}
                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium dark:text-white">Status Penghuni</label>
                        <select id="status" name="status"
                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-9 focus:border-blue-500 focus:ring-blue-500">
                            <option value="tetap" {{ old('status') == 'tetap' ? 'selected' : '' }}>Tetap</option>

                            {{-- 
            Lakukan hal yang sama untuk nilai 'kontrak'.
        --}}
                            <option value="kontrak" {{ old('status') == 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                        </select>
                    </div>

                    {{-- Status Menikah --}}
                    <div>
                        <label for="married_status" class="block mb-2 text-sm font-medium dark:text-white">Status Menikah</label>
                        <label for="hs-basic-usage"
                            class="relative flex items-center p-3 border border-gray-200 rounded-lg">
                            <input type="checkbox" id="hs-basic-usage" name="married_status"
                                class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500"
                                value="1">
                            <span class="text-sm text-gray-500 ms-3 dark:text-gray-400">Sudah Menikah</span>
                        </label>
                    </div>
                </div>

                <div class="">
                    <label for="married_status" class="block mb-1 text-sm font-medium dark:text-white">KTP/SIM </label>
                    <div
                        data-hs-file-upload='{
  "url": "/upload",
  "extensions": {
    "default": {
      "class": "shrink-0 size-5"
    },
    "xls": {
      "class": "shrink-0 size-5"
    },
    "zip": {
      "class": "shrink-0 size-5"
    },
    "csv": {
      "icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4\"/><path d=\"M14 2v4a2 2 0 0 0 2 2h4\"/><path d=\"m5 12-3 3 3 3\"/><path d=\"m9 18 3-3-3-3\"/></svg>",
      "class": "shrink-0 size-5"
    }
  }
}'>
                        <template data-hs-file-upload-preview="">
                            <div class="p-3 bg-white border border-gray-300 border-solid rounded-xl ">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-x-3">
                                        <span
                                            class="flex items-center justify-center text-gray-500 border border-gray-200 rounded-lg size-10"
                                            data-hs-file-upload-file-icon="">
                                            <img class="hidden rounded-lg" data-dz-thumbnail="">
                                        </span>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800 ">
                                                <span class="inline-block truncate align-bottom max-w-75"
                                                    data-hs-file-upload-file-name=""></span>.<span
                                                    data-hs-file-upload-file-ext=""></span>
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-neutral-500"
                                                data-hs-file-upload-file-size=""></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-x-2">
                                        <button type="button"
                                            class="text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 dark:text-neutral-500 dark:hover:text-neutral-200 dark:focus:text-neutral-200"
                                            data-hs-file-upload-remove="">
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M3 6h18"></path>
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                <line x1="10" x2="10" y1="11" y2="17">
                                                </line>
                                                <line x1="14" x2="14" y1="11" y2="17">
                                                </line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex items-center gap-x-3 whitespace-nowrap">
                                    <div class="flex w-full h-2 overflow-hidden bg-gray-200 rounded-full dark:bg-neutral-700"
                                        role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                        data-hs-file-upload-progress-bar="">
                                        <div class="flex flex-col justify-center overflow-hidden text-xs text-center text-white transition-all duration-500 bg-blue-600 rounded-full whitespace-nowrap hs-file-upload-complete:bg-green-500"
                                            style="width: 0" data-hs-file-upload-progress-bar-pane=""></div>
                                    </div>
                                    <div class="w-10 text-end">
                                        <span class="text-sm text-gray-800 dark:text-white">
                                            <span data-hs-file-upload-progress-bar-value="">0</span>%
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="flex justify-center p-12 bg-white border border-gray-300 border-dashed cursor-pointer rounded-xl dark:bg-neutral-800 dark:border-neutral-600"
                            data-hs-file-upload-trigger="">
                            <div class="text-center">
                                <span class="inline-flex items-center justify-center size-16">
                                    <svg class="w-16 h-auto shrink-0" width="71" height="51" viewBox="0 0 71 51"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.55172 8.74547L17.7131 6.88524V40.7377L12.8018 41.7717C9.51306 42.464 6.29705 40.3203 5.67081 37.0184L1.64319 15.7818C1.01599 12.4748 3.23148 9.29884 6.55172 8.74547Z"
                                            stroke="#2563EB" stroke-width="2"></path>
                                        <path
                                            d="M64.4483 8.74547L53.2869 6.88524V40.7377L58.1982 41.7717C61.4869 42.464 64.703 40.3203 65.3292 37.0184L69.3568 15.7818C69.984 12.4748 67.7685 9.29884 64.4483 8.74547Z"
                                            stroke="#2563EB" stroke-width="2"></path>
                                        <g filter="url(#filter1)">
                                            <rect x="17.5656" y="1" width="35.8689" height="42.7541" rx="5"
                                                stroke="#2563EB" stroke-width="2" shape-rendering="crispEdges"></rect>
                                        </g>
                                        <path
                                            d="M39.4826 33.0893C40.2331 33.9529 41.5385 34.0028 42.3537 33.2426L42.5099 33.0796L47.7453 26.976L53.4347 33.0981V38.7544C53.4346 41.5156 51.1959 43.7542 48.4347 43.7544H22.5656C19.8043 43.7544 17.5657 41.5157 17.5656 38.7544V35.2934L29.9728 22.145L39.4826 33.0893Z"
                                            class="fill-blue-50 dark:fill-blue-900/50" fill="currentColor"
                                            stroke="#2563EB" stroke-width="2"></path>
                                        <circle cx="40.0902" cy="14.3443" r="4.16393"
                                            class="fill-blue-50 dark:fill-blue-900/50" fill="currentColor"
                                            stroke="#2563EB" stroke-width="2"></circle>
                                        <defs>
                                            <filter id="filter1" x="13.5656" y="0" width="43.8689" height="50.7541"
                                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                                <feColorMatrix in="SourceAlpha" type="matrix"
                                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha">
                                                </feColorMatrix>
                                                <feOffset dy="3"></feOffset>
                                                <feGaussianBlur stdDeviation="1.5"></feGaussianBlur>
                                                <feComposite in2="hardAlpha" operator="out"></feComposite>
                                                <feColorMatrix type="matrix"
                                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0"></feColorMatrix>
                                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1">
                                                </feBlend>
                                                <feBlend mode="normal" in="SourceGraphic" in2="effect1"
                                                    result="shape"></feBlend>
                                            </filter>
                                        </defs>
                                    </svg>
                                </span>

                                <div class="flex flex-wrap justify-center mt-4 text-gray-600 text-sm/6">
                                    <span class="font-medium text-gray-800 pe-1 dark:text-neutral-200">
                                        Drop your file here or
                                    </span>
                                    <span
                                        class="font-semibold text-blue-600 bg-white rounded-lg hover:text-blue-700 decoration-2 hover:underline focus-within:outline-hidden focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2 dark:bg-neutral-800 dark:text-blue-500 dark:hover:text-blue-600">browse</span>
                                </div>

                                <p class="mt-1 text-xs text-gray-400 dark:text-neutral-400">
                                    Pick a file up to 2MB.
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 space-y-2 empty:mt-0" data-hs-file-upload-previews=""></div>
                    </div>
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end mt-8 gap-x-2">
                <a href="{{ route('rumah.show', $house->id) }}"
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const identityPhotoInput = document.getElementById('identity_photo');
            const imagePreview = document.getElementById('image-preview');
            const placeholder = document.getElementById('placeholder');

            identityPhotoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Tampilkan gambar preview
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        // Sembunyikan placeholder
                        placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
