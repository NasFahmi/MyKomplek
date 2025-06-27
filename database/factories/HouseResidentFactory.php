<?php

namespace Database\Factories;

use App\Models\House;
use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HouseResident>
 */
class HouseResidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $entryDate = $this->faker->dateTimeBetween('-2 years', 'now');
        $exitDate = $this->faker->optional()->dateTimeBetween($entryDate, 'now');

        return [
            'id' => Str::uuid(),
            'house_id' => House::inRandomOrder()->first()->id,
            'resident_id' => Resident::inRandomOrder()->first()->id,
            'date_of_entry' => $entryDate,
            'date_of_exit' => $exitDate,
        ];
    }
}
