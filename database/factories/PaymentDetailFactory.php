<?php

namespace Database\Factories;

use App\Models\FeeType;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentDetail>
 */
class PaymentDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $feeType = FeeType::inRandomOrder()->first() ?? FeeType::factory();

        return [
            'id' => Str::uuid(),
            'payment_id' => Payment::inRandomOrder()->first()?->id ?? Payment::factory(),
            'fee_type_id' => $feeType->id,
            'amount' => $feeType->amount,
            'original_amount' => $feeType->amount, // Simpan nilai asli
            'fee_name' => $feeType->name, // Backup nama
        ];
    }
}
