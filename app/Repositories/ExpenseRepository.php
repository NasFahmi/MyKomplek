<?php

namespace App\Repositories;

use App\Interface\ExpenseInterface;
use App\Models\Expense;
use Illuminate\Support\Carbon;

class ExpenseRepository implements ExpenseInterface
{

    public function create(array $data): \Illuminate\Database\Eloquent\Model|null
    {
        // TODO: Implement create() method.
        return Expense::create([
            'expense_type' => $data['expense_type'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'category' => $data['category'],
            'payment_method' => $data['payment_method'],
            'date' => Carbon::createFromFormat('m/d/Y', $data['date'])->format('Y-m-d'),

        ]);
    }

    public function find($id): \Illuminate\Database\Eloquent\Model|null
    {
        // TODO: Implement find() method.
        return Expense::find($id);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        // TODO: Implement getAll() method.
        return Expense::all();
    }

    public function update(array $data, $id): \Illuminate\Database\Eloquent\Model|null
    {
        $expense = Expense::find($id);
        $expense->update([
            'expense_type' => $data['expense_type'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'category' => $data['category'],
            'payment_method' => $data['payment_method'],
            'date' => Carbon::createFromFormat('m/d/Y', $data['date'])->format('Y-m-d'),
        ]);
        return $expense;

    }

    public function delete($id): void
    {
        // TODO: Implement delete() method.
        Expense::find($id)->delete();
    }

    public function get(string $id): \Illuminate\Database\Eloquent\Model|null
    {
        // TODO: Implement get() method.
        return Expense::find($id);
    }
}