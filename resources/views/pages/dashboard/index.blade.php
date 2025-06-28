@extends('layout.dashboard')

@section('title', 'Dashboard Admin RT')

@section('content')
    <div class="container px-4 mx-auto">
        {{-- Header --}}
        <div class="flex flex-col items-start justify-between mb-8 md:flex-row md:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin RT</h1>
                <p class="text-gray-600">Ringkasan data perumahan dan keuangan</p>
            </div>
        </div>

        {{-- Statistik Utama --}}
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
            {{-- Jumlah Rumah --}}
            <div class="p-6 bg-white border-l-4 border-blue-500 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Rumah</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalHouses }}</h3>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                </div>
                <div class="flex mt-4 space-x-4">
                    <div class="flex-1">
                        <p class="text-xs text-gray-500">Dihuni</p>
                        <p class="text-lg font-semibold text-green-600">{{ $occupiedHouses }}</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-500">Kosong</p>
                        <p class="text-lg font-semibold text-gray-600">{{ $totalHouses - $occupiedHouses }}</p>
                    </div>
                </div>
            </div>

            {{-- Jumlah Warga --}}
            <div class="p-6 bg-white border-l-4 border-green-500 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Warga</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalResidents }}</h3>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex mt-4 space-x-4">
                    <div class="flex-1">
                        <p class="text-xs text-gray-500">Tetap</p>
                        <p class="text-lg font-semibold text-blue-600">{{ $permanentResidents }}</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-500">Kontrak</p>
                        <p class="text-lg font-semibold text-purple-600">{{ $totalResidents - $permanentResidents }}</p>
                    </div>
                </div>
            </div>

            {{-- Status Pembayaran Bulan Ini --}}
            <div class="p-6 bg-white border-l-4 border-yellow-500 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pembayaran Bulan Ini</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $currentMonthPayments->count() }}/{{ $totalHouses }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ now()->format('F Y') }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        @if ($totalHouses > 0)
                            <div class="bg-yellow-500 h-2.5 rounded-full"
                                style="width: {{ ($currentMonthPayments->count() / $totalHouses) * 100 }}%"></div>
                        @endif
                    </div>
                    <div class="flex justify-between mt-1 text-xs text-gray-500">
                        <span>{{ $currentMonthPayments->count() }} Lunas</span>
                        <span>{{ $totalHouses - $currentMonthPayments->count() }} Belum</span>
                    </div>
                </div>
            </div>

            {{-- Saldo Keuangan --}}
            <div class="p-6 bg-white border-l-4 border-purple-500 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Saldo Keuangan</p>
                        <h3 class="text-2xl font-bold {{ $balance >= 0 ? 'text-purple-600' : 'text-red-600' }}">Rp
                            {{ number_format($balance, 0, ',', '.') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">Per {{ now()->format('d M Y') }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex mt-4 space-x-4">
                    <div class="flex-1">
                        <p class="text-xs text-gray-500">Pemasukan</p>
                        <p class="text-sm font-semibold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-500">Pengeluaran</p>
                        <p class="text-sm font-semibold text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dua Kolom Bawah --}}
        <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
            {{-- Daftar Iuran Aktif --}}
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Iuran Aktif</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($activeFees as $fee)
                        <div class="px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $fee->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $fee->description }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">Rp
                                        {{ number_format($fee->amount, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">Berlaku sejak
                                        {{ \Carbon\Carbon::parse($fee->effective_date)->format('d-m-Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="px-6 py-3 text-right bg-gray-50">
                    <a href="{{ route('pembayaran.index') }}"
                        class="text-sm font-medium text-blue-600 hover:text-blue-500">Lihat Semua →</a>
                </div>
            </div>

            {{-- Pembayaran Terakhir --}}
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Pembayaran Terakhir</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($recentPayments as $payment)
                        <div class="px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $payment->resident->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $payment->house->house_number }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">Rp
                                        {{ number_format($payment->paymentDetail->sum('amount'), 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">{{ $payment->payment_date->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="px-6 py-3 text-right bg-gray-50">
                    <a href="{{ route('pembayaran.index') }}"
                        class="text-sm font-medium text-blue-600 hover:text-blue-500">Lihat Semua →</a>
                </div>
            </div>
        </div>

        {{-- Grafik Pemasukan vs Pengeluaran --}}
        <div class="p-6 mb-8 bg-white rounded-lg shadow">
            <div class="flex flex-col items-start justify-between mb-6 sm:flex-row sm:items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Pemasukan vs Pengeluaran</h3>
                    <p class="text-sm text-gray-500">Perbandingan 6 bulan terakhir</p>
                </div>
                <div class="mt-2 sm:mt-0">
                    <select id="chartRange"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="6" {{ request('months', 6) == 6 ? 'selected' : '' }}>6 Bulan Terakhir</option>
                        <option value="12" {{ request('months', 6) == 12 ? 'selected' : '' }}>1 Tahun Terakhir
                        </option>

                    </select>
                </div>
            </div>
            <div class="h-64">
                <canvas id="incomeExpenseChart"></canvas>
            </div>
        </div>

        {{-- Pengeluaran Terakhir --}}
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Pengeluaran Terakhir</h3>
                    <a href="{{ route('pengeluaran.create') }}"
                        class="inline-flex items-center px-3 py-1 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                        Tambah Pengeluaran
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
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
                                Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($recentExpenses as $expense)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}

                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                    {{ ucfirst(str_replace('_', ' ', $expense->expense_type)) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $expense->category === 'routine'
                                    ? 'bg-green-100 text-green-800'
                                    : ($expense->category === 'emergency'
                                        ? 'bg-red-100 text-red-800'
                                        : 'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($expense->category) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                    Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ Str::limit($expense->description, 50) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 text-right bg-gray-50">
                <a href="{{ route('pembayaran.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-500">Lihat Semua →</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Grafik Pemasukan vs Pengeluaran
            const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                            label: 'Pemasukan',
                            data: @json($chartIncomeData),
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Pengeluaran',
                            data: @json($chartExpenseData),
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
                        }
                    }
                }
            });

            // Filter grafik
            document.getElementById('chartRange').addEventListener('change', function() {
                const months = this.value;
                console.log('Filter bulan diganti ke:', months); // Debugging
                const url = new URL(window.location.href);
                url.searchParams.set('months', months);
                window.location.href = url.toString();
            });

        });
    </script>
@endsection
