<?php

namespace Database\Seeders;

use App\Models\FeeType;
use App\Models\House;
use App\Models\HouseResident;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Resident;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Pak RT',
            'email' => 'test@gmail.com',
            'username'=>'pakrt',
            'password' => bcrypt('password'),
        ]);
        // Jenis Iuran
        $this->call(FeeTypeSeeder::class);
        // Buat 5 rumah dan 5 penghuni
        $residents = Resident::factory()->count(5)->create();
        $houses = House::factory()->count(5)->create();
        $feeTypes = FeeType::all();

        // Buat hubungan house <-> resident
        foreach ($houses as $index => $house) {
            $resident = $residents[$index];

            HouseResident::factory()->create([
                'house_id' => $house->id,
                'resident_id' => $resident->id,
                'date_of_entry' => now()->subMonths(rand(3, 12)),
                'date_of_exit' => null, // aktif
            ]);

            // Buat 2 bulan pembayaran untuk masing-masing penghuni
            for ($i = 0; $i < 2; $i++) {
                $month = now()->subMonths($i)->month;
                $year = now()->subMonths($i)->year;

                $payment = Payment::factory()->create([
                    'resident_id' => $resident->id,
                    'house_id' => $house->id,
                    'month' => $month,
                    'year' => $year,
                ]);

                foreach ($feeTypes as $fee) {
                    PaymentDetail::factory()->create([
                        'payment_id' => $payment->id,
                        'fee_type_id' => $fee->id,
                        'amount' => $fee->amount,
                    ]);
                }
            }
        }

    }
}
