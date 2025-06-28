@extends('layout.dashboard')
@section('title', 'Pembayaran')
@section('content')

    <div class="bg-white rounded-lg shadow p-7">
        <div class="flex items-center justify-between">
            <h1 class="mb-6 text-xl font-semibold">Pembayaran</h1>


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

                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="text-sm font-medium text-gray-500 ms-1 md:ms-2 dark:text-gray-400">Pembayaran</span>
                        </div>
                    </li>
                </ol>
            </nav>

        </div>
        <hr class="mb-6">
        {{-- card iuran --}}
        @php
            // Data contoh, ganti dengan data dari controller Anda
            // Daftar palet warna yang aman dan mudah dibaca
            $colorPalettes = [
                ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
                ['bg' => 'bg-pink-100', 'text' => 'text-pink-800'],
                ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800'],
                ['bg' => 'bg-teal-100', 'text' => 'text-teal-800'],
            ];
        @endphp
        <div class="mb-8">
            <h3 class="mb-4 text-lg font-semibold text-gray-700">Daftar Iuran Warga</h3>
            <div class="flex pb-4 -m-2 space-x-4 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @foreach ($fee as $due)
                    @php
                        // FIX: Pilih warna secara berurutan dan berulang dari palet
                        // menggunakan operator modulo (%) pada index loop.
                        $color = $colorPalettes[$loop->index % count($colorPalettes)];
                    @endphp
                    <a href="{{ route('pembayaran.fee-type.show', $due->id) }}"
                        class="flex-shrink-0 w-64 p-6 transition-transform duration-200 transform rounded-lg shadow-md hover:-translate-y-1 {{ $color['bg'] }}">
                        <div class="flex flex-col h-full">
                            <h4 class="text-lg font-bold {{ $color['text'] }}">{{ $due->name }}</h4>
                            <p class="mt-auto mb-1 text-3xl font-extrabold tracking-tight {{ $color['text'] }}">
                                Rp {{ number_format($due->amount, 0, ',', '.') }}
                            </p>
                            <p>{{ $due->is_active ? 'Aktif' : 'Tidak Aktif' }}</p>
                        </div>
                    </a>
                @endforeach
                {{-- Card untuk Tambah Iuran Baru --}}
                <a href="{{ route('pembayaran.fee-type.create') }}"
                    class="flex flex-col items-center justify-center flex-shrink-0 w-64 p-6 transition-colors duration-200 border-2 border-dashed rounded-lg border-gray-300/80 hover:bg-gray-50 hover:border-blue-500">
                    <div class="flex items-center justify-center w-16 h-16 text-gray-400 bg-gray-100 rounded-full">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="12" x2="12" y1="5" y2="19"></line>
                            <line x1="5" x2="19" y1="12" y2="12"></line>
                        </svg>
                    </div>
                    <p class="mt-4 text-sm font-semibold text-gray-500">Tambah Iuran Baru</p>
                </a>
            </div>
        </div>

        <div class="flex flex-col">
            <div
                data-hs-datatable='{
    "pageLength": 10,
    "pagingOptions": {
      "pageBtnClasses": "min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:bg-neutral-700 dark:hover:bg-neutral-700"
    },
    "selecting": true,
    "rowSelectingOptions": {
      "selectAllSelector": "#hs-table-search-checkbox-all"
    },
    "language": {
      "zeroRecords": "<div class=\"py-10 px-5 flex flex-col justify-center items-center text-center\"><svg class=\"shrink-0 size-6 text-gray-500 dark:text-neutral-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><circle cx=\"11\" cy=\"11\" r=\"8\"/><path d=\"m21 21-4.3-4.3\"/></svg><div class=\"max-w-sm mx-auto\"><p class=\"mt-2 text-sm text-gray-600 dark:text-neutral-400\">No search results</p></div></div>"
    }
  }'>
                <div class="flex items-center justify-between py-3">
                    <div class="relative w-full max-w-xs">
                        <label for="hs-table-input-search" class="sr-only">Search</label>
                        <input type="text" name="hs-table-search" id="hs-table-input-search"
                            class="py-1.5 sm:py-2 px-3 ps-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Search for items" data-hs-datatable-search="">
                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <svg class="text-gray-400 size-4 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                    </div>

                    <a href="{{ route('pembayaran.create') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-1">
                        + Tambah Pembayaran
                    </a>

                </div>

                <div class="overflow-x-auto min-h-130">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full">
                                <thead class="border-gray-200 border-y dark:border-neutral-700">
                                    <tr>

                                        <th scope="col" class="py-1 font-normal group text-start focus:outline-hidden">
                                            <div
                                                class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:text-neutral-500 dark:hover:border-neutral-700">
                                                Name
                                                <svg class="size-3.5 ms-1 -me-0.5 text-gray-400 dark:text-neutral-500"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500"
                                                        d="m7 15 5 5 5-5"></path>
                                                    <path
                                                        class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500"
                                                        d="m7 9 5-5 5 5"></path>
                                                </svg>
                                            </div>
                                        </th>

                                        <th scope="col" class="py-1 font-normal group text-start focus:outline-hidden">
                                            <div
                                                class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:text-neutral-500 dark:hover:border-neutral-700">
                                                Nomor Rumah
                                                <svg class="size-3.5 ms-1 -me-0.5 text-gray-400 dark:text-neutral-500"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500"
                                                        d="m7 15 5 5 5-5"></path>
                                                    <path
                                                        class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500"
                                                        d="m7 9 5-5 5 5"></path>
                                                </svg>
                                            </div>
                                        </th>

                                        <th scope="col" class="py-1 font-normal group text-start focus:outline-hidden">
                                            <div
                                                class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:text-neutral-500 dark:hover:border-neutral-700">
                                                Kode Pembayaran
                                                <svg class="size-3.5 ms-1 -me-0.5 text-gray-400 dark:text-neutral-500"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500"
                                                        d="m7 15 5 5 5-5"></path>
                                                    <path
                                                        class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500"
                                                        d="m7 9 5-5 5 5"></path>
                                                </svg>
                                            </div>
                                        </th>

                                        <th scope="col" class="py-1 font-normal group text-start focus:outline-hidden">
                                            <div
                                                class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:text-neutral-500 dark:hover:border-neutral-700">
                                                Tanggal Pembayaran
                                                <svg class="size-3.5 ms-1 -me-0.5 text-gray-400 dark:text-neutral-500"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500"
                                                        d="m7 15 5 5 5-5"></path>
                                                    <path
                                                        class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500"
                                                        d="m7 9 5-5 5 5"></path>
                                                </svg>
                                            </div>
                                        </th>
                                        <th scope="col" class="py-1 font-normal group text-start focus:outline-hidden">
                                            <div
                                                class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:text-neutral-500 dark:hover:border-neutral-700">
                                                Total
                                                <svg class="size-3.5 ms-1 -me-0.5 text-gray-400 dark:text-neutral-500"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        class="hs-datatable-ordering-desc:text-blue-600 dark:hs-datatable-ordering-desc:text-blue-500"
                                                        d="m7 15 5 5 5-5"></path>
                                                    <path
                                                        class="hs-datatable-ordering-asc:text-blue-600 dark:hs-datatable-ordering-asc:text-blue-500"
                                                        d="m7 9 5-5 5 5"></path>
                                                </svg>
                                            </div>
                                        </th>

                                        <th scope="col"
                                            class="px-3 py-2 text-sm font-normal text-gray-500 text-end --exclude-from-ordering dark:text-neutral-500">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    @foreach ($payment as $item)
                                        <tr>
                                            {{-- nama --}}
                                            <td
                                                class="p-3 text-sm font-medium text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                {{ $item->resident->name }}
                                            </td>
                                            {{-- nomor rumah --}}
                                            <td class="p-3 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                {{ $item->resident->currentHouse->house->house_number }}
                                            </td>
                                            {{-- kode Pembayaran --}}
                                            <td class="p-3 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                {{ $item->code }}
                                            </td>
                                            {{-- tanggal Pembayaran --}}
                                            <td class="p-3 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                {{ \Carbon\Carbon::parse($item->payment_date)->format('d-m-Y') }}
                                            </td>
                                            {{-- Total Pembayaran --}}
                                            <td class="p-3 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                
                                                Rp {{ number_format($item->paymentDetail->sum('amount'), 0, ',', '.') }}
                                                {{-- Rp {{ number_format($item->paymentDetails   , 0, ',', '.') }} --}}
                                            </td>
                                            <td class="p-3 text-sm font-medium whitespace-nowrap text-end">
                                                <a href="{{route('pembayaran.show', $item->id)}}"
                                                    class="inline-flex items-center text-sm font-semibold text-blue-600 border border-transparent rounded-lg gap-x-2 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">Detail</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="hidden px-4 py-1" data-hs-datatable-paging="">
                    <nav class="flex items-center space-x-1">
                        <button type="button"
                            class="p-2.5 min-w-10 inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                            data-hs-datatable-paging-prev="">
                            <span aria-hidden="true">«</span>
                            <span class="sr-only">Previous</span>
                        </button>
                        <div class="flex items-center space-x-1 [&>.active]:bg-gray-100 dark:[&>.active]:bg-neutral-700"
                            data-hs-datatable-paging-pages=""></div>
                        <button type="button"
                            class="p-2.5 min-w-10 inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                            data-hs-datatable-paging-next="">
                            <span class="sr-only">Next</span>
                            <span aria-hidden="true">»</span>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection
