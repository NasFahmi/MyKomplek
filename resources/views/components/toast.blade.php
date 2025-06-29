@php
    $type = session('success') ? 'success' : (session('error') ? 'error' : null);
    $message = session('success') ?? session('error');

    $styles = [
        'success' => [
            'bg' => 'bg-green-100 dark:bg-green-800',
            'text' => 'text-green-500 dark:text-green-200',
            'icon' => '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" /></svg>',
            'sr_text' => 'Check icon'
        ],
        'error' => [
            'bg' => 'bg-red-100 dark:bg-red-800',
            'text' => 'text-red-500 dark:text-red-200',
            'icon' => '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>',
            'sr_text' => 'Error icon'
        ],
    ];
@endphp

@if ($type && $message)
    <div id="toast-{{ $type }}"
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 5000)" {{-- Toast akan hilang setelah 5 detik --}}
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        class="fixed z-50 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg top-5 right-5 dark:text-gray-400 dark:bg-gray-800"
        role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 {{ $styles[$type]['text'] }} {{ $styles[$type]['bg'] }} rounded-lg">
            {!! $styles[$type]['icon'] !!} {{-- Menggunakan {!! !!} karena berisi HTML --}}
            <span class="sr-only">{{ $styles[$type]['sr_text'] }}</span>
        </div>

        <div class="text-sm font-normal ms-3">{{ $message }}</div>

        <button type="button" @click="show = false"
            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
@endif