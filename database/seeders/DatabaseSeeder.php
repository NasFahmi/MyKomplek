<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\FeeType;
use App\Models\House;
use App\Models\HouseResident;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Resident;
use App\Models\User;
use Database\Factories\HouseActiveFactory;
use Database\Factories\HouseNonActiveFactory;
use Database\Factories\ResidentActiveFactory;
use Database\Factories\ResidentNonActiveFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // 1. Create Admin User
        User::factory()->create([
            'name' => 'Pak RT',
            'email' => 'test@gmail.com',
            'username' => 'pakrt',
            'password' => bcrypt('password'),
        ]);

        // 2. Seed Fee Types (with historical versions)
        $this->call(FeeTypeSeeder::class);
        $feeTypes = FeeType::all();

        // 3. Seed Expenses
        Expense::factory()->count(5)->create();

        // 4. Seed Houses - aktif dan non aktif
        $houseActive = House::factory()->activeHouse()->count(5)->create();
        $houseNonActive = House::factory()->nonActiveHouse()->count(5)->create();

        // 5. Seed Residents - aktif dan non aktif
        $residentActive = Resident::factory()->activeResident()->count(10)->create();
        $residentNonActive = Resident::factory()->nonActiveResident()->count(10)->create();

        // 6. Assign Active Residents to Active Houses
        foreach ($houseActive as $index => $house) {
            // Ambil resident aktif yang belum memiliki rumah
            $resident = $residentActive->filter(function ($r) {
                return !$r->houseResidents()->exists();
            })->first();

            if (!$resident) {
                break;
            }

            $houseResident = HouseResident::create([
                'house_id' => $house->id,
                'resident_id' => $resident->id,
                'date_of_entry' => Carbon::now()->subMonths(rand(3, 12)),
                'date_of_exit' => null, // masih aktif
            ]);

            // Update status resident sesuai dengan house
            $resident->update(['resident_status' => $house->status]);

            // 7. Create Payment + 2 bulan PaymentDetail per fee type
            $payment = Payment::create([
                'code' => Str::random(5),
                'house_id' => $house->id,
                'resident_id' => $resident->id,
                'payment_date' => now()->subDays(rand(1, 30)),
                'status' => 'lunas',
            ]);

            foreach ($feeTypes as $feeType) {
                for ($i = 0; $i < 2; $i++) {
                    PaymentDetail::create([
                        'payment_id' => $payment->id,
                        'fee_type_id' => $feeType->id,
                        'month' => now()->subMonths($i)->month,
                        'year' => now()->subMonths($i)->year,
                        'amount' => $feeType->amount,
                    ]);
                }
            }
        }

        // 8. Assign NonActive Residents to NonActive Houses
        foreach ($houseNonActive as $index => $house) {
            // Ambil resident non-aktif yang belum memiliki rumah
            $resident = $residentNonActive->filter(function ($r) {
                return !$r->houseResidents()->exists();
            })->first();

            if (!$resident) {
                break;
            }

            $houseResident = HouseResident::create([
                'house_id' => $house->id,
                'resident_id' => $resident->id,
                'date_of_entry' => Carbon::now()->subMonths(rand(6, 12)),
                'date_of_exit' => Carbon::now(), // sudah tidak tinggal
            ]);

            // Update status resident sesuai dengan house
            $resident->update(['resident_status' => $house->status]);
        }

        // 9. Handle remaining residents (jika ada)
        $remainingActiveResidents = $residentActive->filter(function ($r) {
            return !$r->houseResidents()->exists();
        });

        $remainingNonActiveResidents = $residentNonActive->filter(function ($r) {
            return !$r->houseResidents()->exists();
        });

        // Assign remaining active residents to random active houses
        foreach ($remainingActiveResidents as $resident) {
            $house = $houseActive->random();

            HouseResident::create([
                'house_id' => $house->id,
                'resident_id' => $resident->id,
                'date_of_entry' => Carbon::now()->subMonths(rand(3, 12)),
                'date_of_exit' => null,
            ]);

            $resident->update(['resident_status' => $house->status]);
        }

        // Assign remaining non-active residents to random non-active houses
        foreach ($remainingNonActiveResidents as $resident) {
            $house = $houseNonActive->random();

            HouseResident::create([
                'house_id' => $house->id,
                'resident_id' => $resident->id,
                'date_of_entry' => Carbon::now()->subMonths(rand(6, 12)),
                'date_of_exit' => Carbon::now(),
            ]);

            $resident->update(['resident_status' => $house->status]);
        }
    }
}