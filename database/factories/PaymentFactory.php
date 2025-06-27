<?php

namespace Database\Factories;

use App\Enum\PaymentStatus;
use App\Models\House;
use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'resident_id' => Resident::inRandomOrder()->first()->id,
            'house_id' => House::inRandomOrder()->first()->id,
            'payment_date' => $this->faker->date(),
            'month' => $this->faker->numberBetween(1, 12),
            'year' => 2025,
            'status' => PaymentStatus::Lunas->value,
            'description' => $this->faker->sentence(),
        ];
    }
}
