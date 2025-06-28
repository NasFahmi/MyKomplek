<?php

namespace App\Repositories;

use App\Interface\ExpenseInterface;
use App\Models\Expense;

class ExpenseRepository implements ExpenseInterface
{

    public function create(array $data): \Illuminate\Database\Eloquent\Model|null
    {
        // TODO: Implement create() method.
        return Expense::create($data);
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
        // TODO: Implement update() method.
        return Expense::find($id)->update($data);
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