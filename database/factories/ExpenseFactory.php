<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
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
            'description' => $this->faker->sentence(),
            'amount' => $this->faker->numberBetween(10000, 1000000),
            'date' => $this->faker->dateTimeThisYear(),
            'expense_type' => $this->faker->randomElement(['Gaji Security', 'Perbaikan Jalan', 'Listrik']),//tipe pengeluaran, Mendeskripsikan apa yang dibeli seperti security_salary, road_repair, electricity
            'category' => $this->faker->randomElement([
                'Rutin',
                'Darurat',
                'Administrasi',
            ]),
            'payment_method' => $this->faker->randomElement([
                'Tunai',
                'Transfer',
            ]),
        ];
    }
}
