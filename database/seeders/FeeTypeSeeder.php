<?php

namespace Database\Seeders;

use App\Models\FeeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeeType::insert([
            [
                'id' => Str::uuid(),
                'name' => 'Iuran Satpam',
                'description' => 'Iuran bulanan untuk gaji satpam',
                'amount' => 100000,
                'is_active' => true,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Iuran Kebersihan',
                'description' => 'Iuran bulanan untuk kebersihan lingkungan',
                'amount' => 15000,
                'is_active' => true,
            ]
        ]);
    }
}
