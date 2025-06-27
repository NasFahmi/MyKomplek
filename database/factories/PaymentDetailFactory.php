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
        return [
            'id' => Str::uuid(),
            'payment_id' => Payment::inRandomOrder()->first()->id,
            'fee_type_id' => FeeType::inRandomOrder()->first()->id,
            'amount' => function (array $attr) {
                return FeeType::find($attr['fee_type_id'])->amount;
            }
        ];
    }
}
