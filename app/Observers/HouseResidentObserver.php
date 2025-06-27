<?php

namespace App\Observers;

use App\Models\HouseResident;

class HouseResidentObserver
{
    /**
     * Handle the HouseResident "created" event.
     * Dipanggil setelah penghuni baru berhasil dibuat.
     */
    public function created(HouseResident $houseResident): void
    {
        $this->updateHouseStatus($houseResident);
    }

    /**
     * Handle the HouseResident "updated" event.
     * Dipanggil setelah data hunian diperbarui (misal: tanggal keluar diisi).
     */
    public function updated(HouseResident $houseResident): void
    {
        // Hanya jalankan jika ada perubahan signifikan seperti tanggal keluar
        if ($houseResident->isDirty('date_of_exit')) {
            $this->updateHouseStatus($houseResident);
        }
    }

    /**
     * Handle the HouseResident "deleted" event.
     * Dipanggil setelah data hunian dihapus.
     */
    public function deleted(HouseResident $houseResident): void
    {
        $this->updateHouseStatus($houseResident);
    }

    /**
     * Metode utama untuk memeriksa dan memperbarui status rumah.
     *
     * @param HouseResident $houseResident
     * @return void
     */
    protected function updateHouseStatus(HouseResident $houseResident): void
    {
        // Ambil data rumah yang terkait dengan hunian ini
        $house = $houseResident->house;

        // Jika rumah tidak ditemukan, hentikan proses
        if (!$house) {
            return;
        }

        // LOGIKA INTI:
        // Cek apakah ada setidaknya SATU penghuni aktif di rumah ini.
        // Penghuni aktif adalah:
        // 1. houseResidents.date_of_exit adalah NULL
        // 2. DAN relasi residents.status adalah 1 (true)
        $hasActiveResidents = $house->houseResidents()
            ->whereNull('date_of_exit')
            ->whereHas('resident', function ($query) {
                $query->where('status', true); // atau ->where('status', 1)
            })
            ->exists();

        // Update status rumah berdasarkan hasil pengecekan
        // Jika $hasActiveResidents adalah true, maka $house->status menjadi true.
        // Jika false, maka $house->status menjadi false.
        $house->status = $hasActiveResidents;
        $house->save();
    }
}