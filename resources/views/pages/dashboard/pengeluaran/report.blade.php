@extends('layout.dashboard')

@section('title', 'Laporan Keuangan RT')

@section('content')
    <div class="bg-white rounded-lg shadow p-7">
        {{-- Header dan Breadcrumb --}}
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold">Laporan Keuangan RT</h1>
                <p class="text-sm text-gray-500">Perbandingan pemasukan dan pengeluaran per bulan</p>
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
                                class="text-sm font-medium text-gray-700 hover:text-blue-600">Keuangan</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" fill="none" viewBox="0 0 6 10" stroke="currentColor"
                                stroke-width="2">
                                <path d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500">Laporan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="mb-8">

        {{-- Filter Tahun --}}
        <div class="p-4 mb-8 rounded-lg bg-gray-50">
            <form id="yearFilterForm" method="GET" class="flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                <div class="w-full sm:w-auto">
                    <label for="year" class="block mb-1 text-sm font-medium text-gray-700">Pilih Tahun</label>
                    <select name="year" id="year"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach (range(date('Y') - 2, date('Y')) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full sm:w-auto">
                    <label for="month" class="block mb-1 text-sm font-medium text-gray-700">Pilih Bulan
                        (Opsional)</label>
                    <select name="month" id="month"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Semua Bulan</option>
                        @foreach (range(1, 12) as $m)
                            <option value="{{ $m }}"
                                {{ isset($selectedMonth) && $selectedMonth == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end justify-end h-fit md:h-16">
                    <button type="submit"
                        class="px-4 py-2 mt-6 text-white bg-blue-600 rounded-md sm:mt-0 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>

        {{-- Summary Card --}}
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
            <div class="p-4 border border-green-100 rounded-lg bg-green-50">
                <h3 class="text-sm font-medium text-green-800">Total Pemasukan</h3>
                <p class="mt-1 text-2xl font-semibold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                <p class="mt-1 text-sm text-green-600">{{ $year }}</p>
            </div>
            <div class="p-4 border border-red-100 rounded-lg bg-red-50">
                <h3 class="text-sm font-medium text-red-800">Total Pengeluaran</h3>
                <p class="mt-1 text-2xl font-semibold text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                <p class="mt-1 text-sm text-red-600">{{ $year }}</p>
            </div>
            <div class="p-4 border border-blue-100 rounded-lg bg-blue-50">
                <h3 class="text-sm font-medium text-blue-800">Saldo</h3>
                <p
                    class="mt-1 text-2xl font-semibold {{ $totalIncome - $totalExpense >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                    Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}
                </p>
                <p class="mt-1 text-sm text-blue-600">{{ $year }}</p>
            </div>
        </div>

        {{-- Grafik Perbandingan --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900">Grafik Perbandingan Bulanan</h2>
                <div class="flex items-center space-x-2">
                    <span class="flex items-center text-sm">
                        <span class="w-3 h-3 mr-1 bg-blue-500 rounded-full"></span>
                        Pemasukan
                    </span>
                    <span class="flex items-center text-sm">
                        <span class="w-3 h-3 mr-1 bg-red-500 rounded-full"></span>
                        Pengeluaran
                    </span>
                </div>
            </div>
            <div class="p-4 bg-white border border-gray-200 rounded-lg">
                <canvas id="comparisonChart" height="300"></canvas>
            </div>
        </div>

        {{-- Detail Transaksi --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900">
                    @if (isset($selectedMonth))
                        Detail Transaksi Bulan {{ DateTime::createFromFormat('!m', $selectedMonth)->format('F') }}
                        {{ $year }}
                    @else
                        Detail Transaksi Tahun {{ $year }}
                    @endif
                </h2>
                <button id="exportBtn" class="px-3 py-1 text-sm bg-gray-100 rounded-md hover:bg-gray-200">
                    Export Excel
                </button>
            </div>

            {{-- Tabs --}}
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px" id="transactionTabs" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="income-tab" data-tabs-target="#income"
                            type="button" role="tab" aria-controls="income" aria-selected="true">Pemasukan</button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                            id="expense-tab" data-tabs-target="#expense" type="button" role="tab"
                            aria-controls="expense" aria-selected="false">Pengeluaran</button>
                    </li>
                </ul>
            </div>

            <div id="transactionTabsContent">
                {{-- Tab Pemasukan --}}
                <div class="hidden p-4 rounded-lg bg-gray-50" id="income" role="tabpanel"
                    aria-labelledby="income-tab">
                    @if ($incomes->isEmpty())
                        <p class="py-4 text-center text-gray-500">Tidak ada data pemasukan</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Tanggal</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Rumah</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Penghuni</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Jenis</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Jumlah</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($incomes as $income)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{-- {{ $income->payment_date->format('d/m/Y') }} --}}
                                                {{ \Carbon\Carbon::parse($income->payment_date)->format('d-m-Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                {{ $income->house->house_number }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                {{ $income->resident->name }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                @foreach ($income->paymentDetail->unique('feeType.name') as $detail)
                                                    {{ $detail->feeType->name }}<br>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                Rp {{ number_format($income->paymentDetail->sum('amount'), 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $income->status === 'lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($income->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $incomes->links() }}
                        </div>
                    @endif
                </div>

                {{-- Tab Pengeluaran --}}
                <div class="hidden p-4 rounded-lg bg-gray-50" id="expense" role="tabpanel"
                    aria-labelledby="expense-tab">
                    @if ($expenses->isEmpty())
                        <p class="py-4 text-center text-gray-500">Tidak ada data pengeluaran</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Tanggal</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Jenis</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Kategori</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Jumlah</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Metode</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($expenses as $expense)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}

                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                {{ ucfirst(str_replace('_', ' ', $expense->expense_type)) }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ ucfirst($expense->category) }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ ucfirst($expense->payment_method) }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $expense->description }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $expenses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi tabs
            const tabs = document.querySelectorAll('[data-tabs-target]');
            const tabContents = document.querySelectorAll('[role="tabpanel"]');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = document.querySelector(tab.dataset.tabsTarget);

                    // Sembunyikan semua konten tab
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Tampilkan konten tab yang dipilih
                    target.classList.remove('hidden');

                    // Update styling tab aktif
                    tabs.forEach(t => {
                        t.classList.remove('border-blue-600', 'text-blue-600');
                        t.classList.add('border-transparent', 'hover:text-gray-600',
                            'hover:border-gray-300');
                    });

                    tab.classList.add('border-blue-600', 'text-blue-600');
                    tab.classList.remove('border-transparent', 'hover:text-gray-600',
                        'hover:border-gray-300');
                });
            });

            // Aktifkan tab pertama secara default
            if (tabs.length > 0) {
                tabs[0].click();
            }

            // Grafik Perbandingan
            const ctx = document.getElementById('comparisonChart').getContext('2d');
            const comparisonChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov',
                        'Des'
                    ],
                    datasets: [{
                            label: 'Pemasukan',
                            data: @json(array_values($monthlyIncome)),
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Pengeluaran',
                            data: @json(array_values($monthlyExpense)),
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += 'Rp ' + context.raw.toLocaleString();
                                    return label;
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                        }
                    },
                    onClick: function(evt, elements) {
                        if (elements.length > 0) {
                            const clickedElement = elements[0];
                            const monthIndex = clickedElement.index + 1;
                            const year = document.getElementById('year').value;

                            // Redirect ke laporan bulan yang diklik
                            window.location.href = `?year=${year}&month=${monthIndex}`;
                        }
                    }
                }
            });

            // Export Excel
            document.getElementById('exportBtn').addEventListener('click', function() {
                const year = document.getElementById('year').value;
                const month = document.getElementById('month').value;

                let url = `/reports/export?year=${year}`;
                if (month) {
                    url += `&month=${month}`;
                }

                window.location.href = url;
            });
        });
    </script>
@endsection
