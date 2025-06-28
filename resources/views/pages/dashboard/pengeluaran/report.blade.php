@extends('layout.dashboard')
@section('title', 'Laporan Keuangan')

@push('styles')
    {{-- Tambahkan style jika diperlukan, misalnya untuk kustomisasi chart --}}
@endpush

@section('content')
    {{-- 
        Asumsi data yang dikirim dari controller:
        $reportData = [
            'year' => 2025,
            'yearly_income' => 15000000,
            'yearly_expense' => 8500000,
            'yearly_balance' => 6500000,
            'monthly_data' => [
                ['month' => 'Jan', 'income' => 1200000, 'expense' => 700000],
                // ... data 11 bulan lainnya
            ],
            'all_transactions' => [
                // Koleksi dari semua transaksi (pemasukan & pengeluaran) untuk tahun tersebut
                // Setiap transaksi harus memiliki 'date', 'type', 'description', 'amount'
            ]
        ];
        $availableYears = [2025, 2024, 2023];
    --}}
    <div x-data="financialReport({ reportData: {{ json_encode($reportData) }}, availableYears: {{ json_encode($availableYears) }} })" class="bg-white rounded-lg shadow p-7">
        {{-- Header dan Breadcrumb --}}
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold">Laporan Keuangan Tahunan</h1>
                <p class="mt-1 text-sm text-gray-500">Analisis pemasukan dan pengeluaran komplek.</p>
            </div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">Dashboard</a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" fill="none" viewBox="0 0 6 10" stroke="currentColor" stroke-width="2"><path d="m1 9 4-4-4-4" /></svg>
                            <span class="text-sm font-medium text-gray-500">Laporan Keuangan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="mb-8">

        {{-- Filter Tahun --}}
        <div class="flex items-center justify-end mb-6">
            <label for="year_filter" class="text-sm font-medium text-gray-600 me-3">Tampilkan Tahun:</label>
            <select x-model="selectedYear" @change="fetchReportData()" id="year_filter" name="year_filter" class="w-full max-w-xs px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-9 focus:border-blue-500 focus:ring-blue-500">
                <template x-for="year in availableYears" :key="year">
                    <option :value="year" x-text="year"></option>
                </template>
            </select>
        </div>

        {{-- 1. Report Summary --}}
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
            {{-- Total Pemasukan --}}
            <div class="p-5 border rounded-lg bg-green-50">
                <p class="text-sm font-medium text-green-700">Total Pemasukan</p>
                <p class="mt-1 text-3xl font-bold text-green-800" x-text="'Rp ' + formatCurrency(reportData.yearly_income)"></p>
            </div>
            {{-- Total Pengeluaran --}}
            <div class="p-5 border rounded-lg bg-red-50">
                <p class="text-sm font-medium text-red-700">Total Pengeluaran</p>
                <p class="mt-1 text-3xl font-bold text-red-800" x-text="'Rp ' + formatCurrency(reportData.yearly_expense)"></p>
            </div>
            {{-- Saldo Akhir --}}
            <div class="p-5 border rounded-lg bg-blue-50">
                <p class="text-sm font-medium text-blue-700">Saldo Akhir Tahun</p>
                <p class="mt-1 text-3xl font-bold text-blue-800" x-text="'Rp ' + formatCurrency(reportData.yearly_balance)"></p>
            </div>
        </div>

        {{-- Grafik Perbandingan --}}
        <div class="p-6 mb-8 border rounded-lg">
             <h3 class="mb-4 text-lg font-semibold text-gray-800" x-text="`Grafik Keuangan Tahun ${selectedYear}`"></h3>
            <div class="h-80">
                <canvas x-ref="financeChart"></canvas>
            </div>
        </div>

        {{-- 2. Detail Transaksi --}}
        <div class="p-6 border rounded-lg">
            <div class="flex flex-col items-start justify-between gap-3 mb-4 sm:flex-row sm:items-center">
                <h3 class="text-lg font-semibold text-gray-800">
                    <span x-text="`Detail Transaksi - ${selectedMonthName}`"></span>
                </h3>
                <button x-show="selectedMonthIndex !== null" @click="resetMonthSelection()" type="button" class="inline-flex items-center px-3 py-1 text-sm font-medium text-gray-600 bg-gray-100 rounded-full hover:bg-gray-200">
                    Tampilkan Semua Tahun
                </button>
            </div>

            <div class="grid grid-cols-1 gap-8 mt-6 lg:grid-cols-2">
                {{-- Tabel Pemasukan --}}
                <div>
                    <h4 class="mb-3 font-semibold text-green-700">Pemasukan</h4>
                    <div class="overflow-hidden border rounded-md">
                        <table class="min-w-full divide-y divide-gray-200">
                             <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase">Keterangan</th>
                                    <th class="px-4 py-2 text-xs font-medium text-right text-gray-500 uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-if="filteredIncome.length === 0">
                                    <tr><td colspan="3" class="px-4 py-4 text-sm text-center text-gray-500">Tidak ada data pemasukan.</td></tr>
                                </template>
                                <template x-for="trx in filteredIncome" :key="trx.id">
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-600 whitespace-nowrap" x-text="formatDate(trx.date)"></td>
                                        <td class="px-4 py-2 text-sm text-gray-800" x-text="trx.description"></td>
                                        <td class="px-4 py-2 text-sm font-medium text-right text-gray-800" x-text="'Rp ' + formatCurrency(trx.amount)"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Tabel Pengeluaran --}}
                <div>
                    <h4 class="mb-3 font-semibold text-red-700">Pengeluaran</h4>
                    <div class="overflow-hidden border rounded-md">
                        <table class="min-w-full divide-y divide-gray-200">
                             <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-2 text-xs font-medium text-left text-gray-500 uppercase">Keterangan</th>
                                    <th class="px-4 py-2 text-xs font-medium text-right text-gray-500 uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-if="filteredExpense.length === 0">
                                    <tr><td colspan="3" class="px-4 py-4 text-sm text-center text-gray-500">Tidak ada data pengeluaran.</td></tr>
                                </template>
                                <template x-for="trx in filteredExpense" :key="trx.id">
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-600 whitespace-nowrap" x-text="formatDate(trx.date)"></td>
                                        <td class="px-4 py-2 text-sm text-gray-800" x-text="trx.description"></td>
                                        <td class="px-4 py-2 text-sm font-medium text-right text-gray-800" x-text="'Rp ' + formatCurrency(trx.amount)"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- Memuat Chart.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function financialReport({ reportData, availableYears }) {
        return {
            // Data
            reportData: reportData,
            availableYears: availableYears,
            chart: null,
            
            // State
            selectedYear: reportData.year,
            selectedMonthIndex: null,

            init() {
                this.renderChart();
                // Watch for changes in reportData to re-render the chart
                this.$watch('reportData', () => this.renderChart());
            },

            // Logika untuk merender chart
            renderChart() {
                if (this.chart) {
                    this.chart.destroy();
                }
                const ctx = this.$refs.financeChart.getContext('2d');
                this.chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: this.reportData.monthly_data.map(d => d.month),
                        datasets: [
                            {
                                label: 'Pemasukan',
                                data: this.reportData.monthly_data.map(d => d.income),
                                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Pengeluaran',
                                data: this.reportData.monthly_data.map(d => d.expense),
                                backgroundColor: 'rgba(239, 68, 68, 0.5)',
                                borderColor: 'rgba(239, 68, 68, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true }
                        },
                        onClick: (event, elements) => {
                            if (elements.length > 0) {
                                this.selectedMonthIndex = elements[0].index;
                            }
                        }
                    }
                });
            },

            // Computed Properties (Getters)
            get selectedMonthName() {
                if (this.selectedMonthIndex === null) {
                    return `Keseluruhan Tahun ${this.selectedYear}`;
                }
                return this.reportData.monthly_data[this.selectedMonthIndex].month_full_name || 'Bulan Terpilih';
            },

            get filteredIncome() {
                const transactions = this.reportData.all_transactions.filter(t => t.type === 'income');
                if (this.selectedMonthIndex === null) {
                    return transactions;
                }
                return transactions.filter(t => (new Date(t.date)).getMonth() === this.selectedMonthIndex);
            },

            get filteredExpense() {
                const transactions = this.reportData.all_transactions.filter(t => t.type === 'expense');
                if (this.selectedMonthIndex === null) {
                    return transactions;
                }
                return transactions.filter(t => (new Date(t.date)).getMonth() === this.selectedMonthIndex);
            },

            // Actions
            resetMonthSelection() {
                this.selectedMonthIndex = null;
            },

            async fetchReportData() {
                // Simulasi fetch data baru ketika tahun diganti
                // Di aplikasi nyata, ini akan menjadi request ke server
                console.log(`Fetching data for year ${this.selectedYear}...`);
                try {
                    // Ganti URL ini dengan endpoint Anda
                    const response = await fetch(`/api/reports/financial?year=${this.selectedYear}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const newData = await response.json();
                    this.reportData = newData; // Update data, chart akan otomatis re-render
                } catch (error) {
                    console.error('Failed to fetch report data:', error);
                    // Tambahkan notifikasi error untuk pengguna di sini
                }
            },

            // Helpers
            formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID').format(amount || 0);
            },
            formatDate(dateString) {
                return new Date(dateString).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            }
        }
    }
</script>