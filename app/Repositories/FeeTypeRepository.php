<?php

namespace App\Repositories;

use App\Interface\FeeTypeInterface;
use App\Models\FeeType;
use App\Models\PaymentDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FeeTypeRepository implements FeeTypeInterface
{
    public function create(array $data): \Illuminate\Database\Eloquent\Model|null
    {
        // Nonaktifkan fee lama dengan nama sama
        FeeType::where('name', $data['name'])
            ->update(['is_active' => false]);



        FeeType::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'effective_date' => Carbon::createFromFormat('m/d/Y', $data['effective_date'])->format('Y-m-d'),
            'is_active' => true
        ]);

        return FeeType::where('name', $data['name'])->first();

    }

    public function delete($id): void
    {
        $feeType = FeeType::find($id);
        $feeType->update(['is_active' => false]);
    }

    public function find($id): \Illuminate\Database\Eloquent\Model|null
    {
        // TODO: Implement find() method.
        return FeeType::find($id);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        // TODO: Implement getAll() method.
        return FeeType::all();
    }

    public function get(string $id): \Illuminate\Database\Eloquent\Model|null
    {
        // TODO: Implement get() method.
        return FeeType::find($id);
    }

    public function update(array $data, $id): ?\Illuminate\Database\Eloquent\Model
    {
        $feeType = FeeType::find($id);
        DB::transaction(function () use ($feeType, $data) {
            // Nonaktifkan versi lama
            $feeType->update(['is_active' => false]);

            // Buat versi baru
            FeeType::create([
                'name' => $feeType->name,
                'description' => $feeType->description,
                'amount' => $data['amount'],
                'effective_date' => Carbon::createFromFormat('m/d/Y', $data['effective_date'])->format('Y-m-d'),
                'is_active' => true
            ]);
        });
        return FeeType::where('name', $data['name'])->first();
    }

    public function getAllActiveFeeType(): \Illuminate\Database\Eloquent\Collection
    {
        return FeeType::where('is_active', 1)->get();
    }

}