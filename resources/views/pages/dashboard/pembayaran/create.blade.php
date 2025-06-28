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
                <div class="">

                    <label class="block mb-2 text-sm font-semibold text-gray-600">Status Pembayaran</label>
                    <select id="status" name="status"
                        class="w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                        <option value="lunas">Lunas</option>
                        <option value="belum_lunas">Belum Lunas</option>
                    </select>
                </div>

            </div>

            {{-- Pilih Iuran --}}
            <div x-show="selectedHouseId" x-transition class="mb-8">
                <label class="block mb-4 text-lg font-semibold text-gray-700">3. Pilih Iuran yang Dibayar</label>
                <div class="space-y-3">
                    <template x-for="fee in feeTypes" :key="fee.id">
                        <div class="flex flex-col gap-2 p-4 border rounded-lg"
                            :class="{ 'bg-blue-50/50 border-blue-200': isFeeSelected(fee.id) }">
                            <div class="flex items-center gap-4">
                                <input :id="'fee-' + fee.id" type="checkbox" @click="toggleFee(fee.id, fee.amount)"
                                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label :for="'fee-' + fee.id" class="flex-grow text-sm font-medium text-gray-700"
                                    x-text="fee.name"></label>
                                <div class="w-32 text-right">
                                    <span class="font-semibold text-gray-800" x-text="formatCurrency(fee.amount)"></span>
                                </div>
                            </div>

                            <div x-show="isFeeSelected(fee.id)" x-transition
                                class="grid grid-cols-1 gap-2 mt-2 md:grid-cols-2">
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
                        </div>
                    </template>
                </div>
            </div>

            {{-- Ringkasan Pembayaran --}}
            <div x-show="Object.keys(selectedFees).length > 0" x-transition class="mb-8">
                <label class="block mb-4 text-lg font-semibold text-gray-700">4. Ringkasan Pembayaran</label>
                <div class="p-6 border rounded-lg bg-gray-50">
                    <ul class="space-y-2">
                        <template x-for="feeId in Object.keys(selectedFees)" :key="feeId">
                            <li class="flex justify-between text-sm">
                                <div>
                                    <span x-text="getFeeName(feeId)"></span>
                                    <span class="text-gray-500">
                                        x <span x-text="getFeeDuration(feeId)"></span> bulan
                                    </span>
                                </div>
                                <span class="font-medium" x-text="formatCurrency(getFeeSubtotal(feeId))"></span>
                            </li>
                        </template>
                    </ul>
                    <div class="flex items-center justify-between pt-4 mt-4 border-t-2 border-dashed">
                        <p class="text-lg font-bold text-gray-800">Total</p>
                        <p class="text-2xl font-bold text-blue-600" x-text="formatCurrency(totalPayment)"></p>
                    </div>
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
          @enderror">{{ old('description') }}</textarea>
                {{-- Blok untuk menampilkan pesan error --}}
                @error('description')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>

            {{-- Hidden Inputs --}}
            <template x-for="feeId in Object.keys(selectedFees)" :key="feeId">
                <div>
                    <input type="hidden" :name="`fees[${feeId}][start_month]`" :value="selectedFees[feeId].start_month">
                    <input type="hidden" :name="`fees[${feeId}][start_year]`" :value="selectedFees[feeId].start_year">
                    <input type="hidden" :name="`fees[${feeId}][end_month]`" :value="selectedFees[feeId].end_month">
                    <input type="hidden" :name="`fees[${feeId}][end_year]`" :value="selectedFees[feeId].end_year">
                    <input type="hidden" :name="`fees[${feeId}][amount]`" :value="selectedFees[feeId].amount">

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
            houses,
            feeTypes,
            selectedHouseId: null,
            selectedResidentId: null,
            selectedFees: {},

            selectHouse(houseId) {
                if (this.selectedHouseId === houseId) return;
                this.selectedHouseId = houseId;
                this.selectedResidentId = null;
                this.selectedFees = {};
                this.$nextTick(() => {
                    document.querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = false);
                });
            },

            toggleFee(feeId, feeAmount) {
                // console.log(feeId);
                // console.log(this.isFeeSelected(feeId));
                // console.log(start_month)
                // console.log(start_year)
                // console.log(end_month)
                // console.log(end_year)

                if (this.isFeeSelected(feeId)) {
                    delete this.selectedFees[feeId];
                } else {
                    const now = new Date();
                    this.selectedFees[feeId] = {
                        start_month: now.getMonth() + 1,
                        start_year: now.getFullYear(),
                        end_month: now.getMonth() + 1,
                        end_year: now.getFullYear(),
                        amount: feeAmount
                    };
                }
            },

            isFeeSelected(feeId) {
                return !!this.selectedFees[feeId];
            },

            getFeeName(feeId) {
                const fee = this.feeTypes.find(f => f.id == feeId);
                return fee ? fee.name : '';
            },

            getFeeDuration(feeId) {
                const fee = this.selectedFees[feeId];
                const start = new Date(fee.start_year, fee.start_month - 1);
                const end = new Date(fee.end_year, fee.end_month - 1);
                // Hitung durasi dalam bulan
                return (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth()) + 1;
            },

            getFeeSubtotal(feeId) {
                const fee = this.selectedFees[feeId];
                // Pastikan fee.amount ada sebelum menghitung subtotal
                return this.getFeeDuration(feeId) * (fee.amount || 0);
            },

            get totalPayment() {
                return Object.keys(this.selectedFees).reduce((sum, id) => sum + this.getFeeSubtotal(id), 0);
            },


            monthName(m) {
                return new Date(0, m - 1).toLocaleString('id-ID', {
                    month: 'long'
                });
            },

            get residentsOfSelectedHouse() {
                if (!this.selectedHouseId) return [];
                const house = this.houses.find(h => h.id === this.selectedHouseId);
                if (house?.house_residents?.length) {
                    return house.house_residents.filter(hr => hr.date_of_exit === null);
                }
                if (house?.current_resident?.date_of_exit === null) {
                    return [house.current_resident];
                }
                return [];
            },

            formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                }).format(amount || 0);
            },

        }
    }
</script>
