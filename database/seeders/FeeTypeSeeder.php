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
        $now = now();

        // Data dasar
        $feeTypes = [
            [
                'id' => Str::uuid(),
                'name' => 'Iuran Satpam',
                'description' => 'Iuran bulanan untuk gaji satpam',
                'amount' => 100000,
                'is_active' => true,
                'effective_date' => $now->copy()->subYear(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Iuran Kebersihan',
                'description' => 'Iuran bulanan untuk kebersihan lingkungan',
                'amount' => 15000,
                'is_active' => true,
                'effective_date' => $now->copy()->subYear(),
            ]
        ];

        // Versi lama untuk simulasi perubahan harga
        $oldSecurityFee = [
            'id' => Str::uuid(),
            'name' => 'Iuran Satpam',
            'description' => 'Iuran bulanan untuk gaji satpam (harga lama)',
            'amount' => 80000,
            'is_active' => false,
            'effective_date' => $now->copy()->subYears(2),
        ];

        $oldCleaningFee = [
            'id' => Str::uuid(),
            'name' => 'Iuran Kebersihan',
            'description' => 'Iuran bulanan untuk kebersihan (harga lama)',
            'amount' => 10000,
            'is_active' => false,
            'effective_date' => $now->copy()->subYears(2),
        ];

        FeeType::insert(array_merge($feeTypes, [$oldSecurityFee, $oldCleaningFee]));
    }
}
