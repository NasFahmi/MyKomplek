@extends('layout.dashboard')
@section('title', 'Tambah Pembayaran')

@section('content')
    {{-- 
        Wrapper utama dengan state manager Alpine.js.
        Data dari controller ($houses dan $feeTypes) di-inject langsung ke dalam state.
    --}}
    <div x-data="paymentForm({ houses: {{ $houses->toJson() }}, feeTypes: {{ $feeTypes->toJson() }} })" class="bg-white rounded-lg shadow p-7">
        <div class="flex flex-col items-start justify-between gap-4 mb-6 sm:flex-row sm:items-center">
            <h1 class="text-xl font-semibold">Tambah Pembayaran</h1>
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
                            <a href="{{ route('pembayaran.index') }}"
                                class="text-sm font-medium text-gray-700 ms-1 hover:text-blue-600 md:ms-2">Pembayaran</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500 ms-1 md:ms-2">Tambah</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="mb-6">

        <form action="{{ route('pembayaran.store') }}" method="post">
            @csrf

            {{-- Bagian 1: Pilih Rumah --}}
            <div class="mb-8">
                <label class="block mb-4 text-lg font-semibold text-gray-700">1. Pilih Rumah</label>
                <div class="flex pb-4 -m-2 space-x-4 overflow-x-auto scrollbar-hide">
                    <template x-for="house in houses" :key="house.id">
                        <button @click="selectHouse(house.id)" type="button"
                            class="flex-shrink-0 w-64 p-5 text-left transition-all duration-200 border-2 rounded-lg shadow-sm"
                            :class="{
                                'border-blue-500 ring-2 ring-blue-200 bg-blue-50': selectedHouseId === house
                                    .id,
                                'bg-white hover:border-gray-300': selectedHouseId !== house.id
                            }">
                            <div class="flex flex-col h-full">
                                <p class="text-lg font-bold text-gray-800" x-text="house.house_number"></p>
                                <p class="mt-1 text-sm text-gray-500" x-text="house.address"></p>
                            </div>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="house_id" x-model="selectedHouseId">
                @error('house_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Bagian 2: Pilih Penghuni, Periode, dan Status (Muncul setelah rumah dipilih) --}}
            <div x-show="selectedHouseId" x-transition class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                <div>
                    <label for="resident_id" class="block mb-2 text-base font-semibold text-gray-700">2. Pilih
                        Penghuni</label>
                    <select id="resident_id" name="resident_id" x-model="selectedResidentId"
                        class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm pe-9 focus:border-blue-500 focus:ring-blue-500"
                        required>
                        <option value="" disabled>-- Pilih seorang penghuni --</option>
                        <template x-for="residentData in residentsOfSelectedHouse" :key="residentData.resident.id">
                            <option :value="residentData.resident.id" x-text="residentData.resident.name"></option>
                        </template>
                    </select>
                    @error('resident_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <label class="block text-sm font-semibold text-gray-600">Periode Pembayaran</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex gap-2">
                            <select x-model="startMonth" class="w-1/2 px-2 py-2 border rounded">
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}">
                                        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</option>
                                @endforeach
                            </select>
                            <input x-model.number="startYear" type="number" min="2020"
                                class="w-1/2 px-2 py-2 border rounded" placeholder="Tahun awal">
                        </div>
                        <div class="flex gap-2">
                            <select x-model="endMonth" class="w-1/2 px-2 py-2 border rounded">
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}">
                                        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</option>
                                @endforeach
                            </select>
                            <input x-model.number="endYear" type="number" min="2020"
                                class="w-1/2 px-2 py-2 border rounded" placeholder="Tahun akhir">
                        </div>
                    </div>
                    <input type="hidden" name="start_month" :value="startMonth">
                    <input type="hidden" name="start_year" :value="startYear">
                    <input type="hidden" name="end_month" :value="endMonth">
                    <input type="hidden" name="end_year" :value="endYear">

                    <input type="hidden" name="total_months" :value="getTotalMonths()">


                    <label class="block mt-4 text-sm font-semibold text-gray-600">Status Pembayaran</label>
                    <select id="status" name="status"
                        class="w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                        <option value="lunas">Lunas</option>
                        <option value="belum_lunas">Belum Lunas</option>
                    </select>
                </div>

            </div>

            {{-- Bagian 3: Pilih Iuran & Durasi (Muncul setelah penghuni dipilih) --}}
            <div x-show="selectedHouseId" x-transition class="mb-8">
                <label class="block mb-4 text-lg font-semibold text-gray-700">3. Pilih Iuran yang Dibayar</label>
                <div class="space-y-3">
                    <template x-for="fee in feeTypes" :key="fee.id">
                        <div class="flex items-center gap-4 p-4 border rounded-lg"
                            :class="{ 'bg-blue-50/50 border-blue-200': isFeeSelected(fee.id) }">
                            <input :id="'fee-' + fee.id" type="checkbox" @click="toggleFee(fee.id, fee.amount)"
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label :for="'fee-' + fee.id" class="flex-grow text-sm font-medium text-gray-700"
                                x-text="fee.name"></label>
                            <div x-show="isFeeSelected(fee.id)" x-transition class="grid grid-cols-2 gap-2">
                                <div class="flex items-center gap-2">
                                    <label class="text-sm text-gray-500">Mulai:</label>
                                    <select x-model.number="selectedFees[fee.id].start_month"
                                        class="px-2 py-1 text-sm border rounded">
                                        <template x-for="m in 12" :key="m">
                                            <option :value="m" x-text="monthName(m)"></option>
                                        </template>
                                    </select>
                                    <input type="number" x-model.number="selectedFees[fee.id].start_year" min="2020"
                                        class="w-20 px-2 py-1 text-sm border rounded">
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="text-sm text-gray-500">Akhir:</label>
                                    <select x-model.number="selectedFees[fee.id].end_month"
                                        class="px-2 py-1 text-sm border rounded">
                                        <template x-for="m in 12" :key="m">
                                            <option :value="m" x-text="monthName(m)"></option>
                                        </template>
                                    </select>
                                    <input type="number" x-model.number="selectedFees[fee.id].end_year" min="2020"
                                        class="w-20 px-2 py-1 text-sm border rounded">
                                </div>
                            </div>

                            <div class="w-32 text-right">
                                <span class="font-semibold text-gray-800"
                                    x-text="'Rp ' + formatCurrency(fee.amount)"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Bagian 4: Ringkasan Pembayaran (Muncul setelah iuran dipilih) --}}
            <div x-show="Object.keys(selectedFees).length > 0" x-transition class="mb-8">
                <label class="block mb-4 text-lg font-semibold text-gray-700">4. Ringkasan Pembayaran</label>
                <div class="p-6 border rounded-lg bg-gray-50">
                    <ul class="space-y-2">
                        <template x-for="feeId in Object.keys(selectedFees)" :key="feeId">
                            <li class="flex justify-between text-sm">
                                <div>
                                    <span x-text="getFeeName(feeId)"></span>
                                    <span class="text-gray-500" x-text="' x ' + getTotalMonths() + ' bulan'"></span>
                                </div>
                                <span class="font-medium" x-text="'Rp ' + formatCurrency(getFeeSubtotal(feeId))"></span>
                            </li>

                        </template>
                    </ul>
                    <div class="flex items-center justify-between pt-4 mt-4 border-t-2 border-dashed">
                        <div class="">
                            <p class="text-lg font-bold text-gray-800">Total</p>
                            <p class="mt-2 text-sm text-gray-600" x-show="getTotalMonths() > 0">
                                Durasi: <strong x-text="getTotalMonths()"></strong> bulan
                            </p>

                            <p class="mt-2 text-sm text-gray-600" x-show="getTotalYears() > 0">
                                Durasi: <strong x-text="getTotalYears()"></strong> tahun
                            </p>
                        </div>
                        <p class="text-2xl font-bold text-blue-600" x-text="'Rp ' + formatCurrency(totalPayment)"></p>
                    </div>
                </div>
            </div>

            {{-- Hidden inputs untuk mengirim data terpilih ke controller --}}
            <template x-for="feeId in Object.keys(selectedFees)" :key="feeId">
                <div>
                    <input type="hidden" :name="`fees[${feeId}][duration]`" :value="selectedFees[feeId].duration">
                    <input type="hidden" :name="`fees[${feeId}][unit]`" :value="selectedFees[feeId].unit">
                </div>
            </template>



            <div class="flex justify-end mt-8 gap-x-2">
                <a href="{{ route('pembayaran.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 align-middle transition-all bg-white border rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-semibold text-white transition-all bg-blue-500 border border-transparent rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Simpan Pembayaran
                </button>
            </div>
        </form>
    </div>
@endsection

<script>
    function paymentForm({
        houses = [],
        feeTypes = []
    } = {}) {
        return {
            // Data dari Controller
            houses: houses,
            feeTypes: feeTypes,

            // State
            selectedHouseId: null,
            selectedResidentId: null,
            selectedFees: {}, // Objek: { fee_id: { duration: 1, unit: 'months', amount: 150000 } }

            startMonth: new Date().getMonth() + 1,
            startYear: new Date().getFullYear(),
            endMonth: new Date().getMonth() + 1,
            endYear: new Date().getFullYear(),
            // Method card rumah
            selectHouse(houseId) {
                if (this.selectedHouseId === houseId) return;
                this.selectedHouseId = houseId;

                // Reset pilihan berikutnya
                this.selectedResidentId = null;
                this.selectedFees = {};
                // Optional paksa reset semua checkbox (kalau masih error)
                this.$nextTick(() => {
                    document.querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = false);
                });
            },


            // Method untuk menambah/menghapus iuran
            toggleFee(feeId, feeAmount) {
                if (this.isFeeSelected(feeId)) {
                    delete this.selectedFees[feeId];
                } else {
                    this.selectedFees[feeId] = {
                        duration: 1,
                        unit: 'months',
                        amount: feeAmount
                    };
                }
            },

            // --- Computed Properties (Getters) ---

            // Cek apakah sebuah iuran sudah dipilih
            isFeeSelected(feeId) {
                return this.selectedFees.hasOwnProperty(feeId);
            },

            // Mendapatkan daftar penghuni dari rumah yang dipilih
            get residentsOfSelectedHouse() {
                if (!this.selectedHouseId) return [];
                const house = this.houses.find(h => h.id === this.selectedHouseId);
                // Menangani jika relasi adalah 'house_residents' (array)
                if (house && Array.isArray(house.house_residents)) {
                    return house.house_residents.filter(hr => hr.date_of_exit === null);
                }
                // Menangani jika relasi adalah 'current_resident' (objek tunggal)
                if (house && house.current_resident && typeof house.current_resident === 'object') {
                    if (house.current_resident.date_of_exit === null) {
                        return [house.current_resident]; // Kembalikan sebagai array dengan satu item
                    }
                }
                return [];
            },

            // Menghitung subtotal untuk satu iuran
            getFeeSubtotal(feeId) {
                const fee = this.selectedFees[feeId];
                if (!fee) return 0;
                const months = this.getTotalMonths();
                return fee.amount * months;
            },

            getTotalMonths() {
                const start = new Date(this.startYear, this.startMonth - 1);
                const end = new Date(this.endYear, this.endMonth - 1);
                const months = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth()) + 1;
                return months > 0 ? months : 0;
            },


            // Menghitung total pembayaran dari semua iuran yang dipilih
            get totalPayment() {
                return Object.keys(this.selectedFees).reduce((total, feeId) => {
                    return total + this.getFeeSubtotal(feeId);
                }, 0);
            },

            // --- Helper Functions ---

            // Mendapatkan nama iuran berdasarkan ID
            getFeeName(feeId) {
                const fee = this.feeTypes.find(f => f.id == feeId);
                return fee ? fee.name : '';
            },

            // Memformat angka menjadi format mata uang Rupiah
            formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID').format(amount || 0);
            }


        }
    }
</script>
