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
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

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
        $expense = Expense::factory()->count(10)->create();
        

        // 3. Create Houses and Residents
        // $houses = House::factory()->count(10)->create();
        // $residents = Resident::factory()->count(20)->create(); // Increased to 20 to ensure enough residents

        // // 4. Assign Residents to Houses (with some houses having multiple residents over time)
        // foreach ($houses as $index => $house) {
        //     // Current resident - use modulo to ensure we don't exceed array bounds
        //     $currentResident = $residents[$index % count($residents)];
            
        //     HouseResident::factory()->create([
        //         'house_id' => $house->id,
        //         'resident_id' => $currentResident->id,
        //         'date_of_entry' => now()->subMonths(rand(3, 12)),
        //         'date_of_exit' => null,
        //     ]);

        //     // For some houses, add previous residents
        //     if ($index % 3 === 0) {
        //         // Use different resident - ensure index is valid
        //         $prevResidentIndex = ($index + 10) % count($residents);
        //         $prevResident = $residents[$prevResidentIndex];

        //         HouseResident::factory()->create([
        //             'house_id' => $house->id,
        //             'resident_id' => $prevResident->id,
        //             'date_of_entry' => now()->subMonths(rand(15, 24)),
        //             'date_of_exit' => now()->subMonths(rand(5, 10)),
        //         ]);
        //     }
        // }

        // // 5. Create Payments with historical fee amounts
        // foreach ($residents as $resident) {
        //     $houseResidents = HouseResident::where('resident_id', $resident->id)->get();
            
        //     foreach ($houseResidents as $houseResident) {
        //         // Create payments for each month of occupancy
        //         $entryDate = Carbon::parse($houseResident->date_of_entry);
        //         $exitDate = $houseResident->date_of_exit ? Carbon::parse($houseResident->date_of_exit) : now();
        //         $months = $entryDate->diffInMonths($exitDate);

        //         // Limit to max 12 months for seeding
        //         $monthsToSeed = min($months, 12);
                
        //         for ($i = 0; $i < $monthsToSeed; $i++) {
        //             $paymentDate = $exitDate->copy()->subMonths($monthsToSeed - $i - 1);
                    
        //             // Determine which fee version to use based on payment date
        //             $payment = Payment::factory()->create([
        //                 'resident_id' => $resident->id,
        //                 'house_id' => $houseResident->house_id,
        //                 'payment_date' => $paymentDate,
        //                 'month' => $paymentDate->month,
        //                 'year' => $paymentDate->year,
        //                 'status' => rand(0, 1) ? 'lunas' : 'belum_lunas',
        //             ]);

        //             foreach ($feeTypes as $feeType) {
        //                 $applicableFee = FeeType::where('name', $feeType->name)
        //                     ->where('effective_date', '<=', $paymentDate)
        //                     ->orderBy('effective_date', 'desc')
        //                     ->first();

        //                 if ($applicableFee) {
        //                     PaymentDetail::factory()->create([
        //                         'payment_id' => $payment->id,
        //                         'fee_type_id' => $applicableFee->id,
        //                         'amount' => $applicableFee->amount,
        //                         'original_amount' => $applicableFee->amount,
        //                         'fee_name' => $applicableFee->name,
        //                     ]);
        //                 }
        //             }
        //         }
        //     }
        // }
    }
}