<?php

namespace Database\Factories;

use App\Enum\ResidentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resident>
 */
class ResidentFactory extends Factory
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
            'name' => $this->faker->name(),
            'identity_photo' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement(ResidentStatus::cases())->value,
            'phone_number' => $this->faker->phoneNumber(),
            'married_status' => $this->faker->boolean(),
            'resident_status' => $this->faker->boolean(),
        ];
    }
    public function activeResident(){
        return $this->state([
            'resident_status' => true,
        ]);
    }
    public function nonActiveResident(){
        return $this->state([
            'resident_status' => false,
        ]);
    }
}
