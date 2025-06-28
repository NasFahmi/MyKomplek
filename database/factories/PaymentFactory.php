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
        $year = $this->faker->numberBetween(2023, 2025);
        $month = $this->faker->numberBetween(1, 12);

        return [
            'id' => Str::uuid(),
            'code'=> Str::random(5),
            'resident_id' => Resident::inRandomOrder()->first()?->id ?? Resident::factory(),
            'house_id' => House::inRandomOrder()->first()?->id ?? House::factory(),
            'payment_date' => now()->setYear($year)->setMonth($month),
            'month' => $month,
            'year' => $year,
            'status' => $this->faker->randomElement(PaymentStatus::cases())->value,
            'description' => $this->faker->sentence(),
        ];
    }
}
