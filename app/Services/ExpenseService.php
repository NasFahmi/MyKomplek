<?php
namespace App\Services;

use App\Interface\ExpenseInterface;


class ExpenseService
{
    protected ExpenseInterface $expenseInterface;

    public function __construct(ExpenseInterface $expenseInterface)
    {
        $this->expenseInterface = $expenseInterface;
    }
    public function getExpense()
    {
        return $this->expenseInterface->getAll();
    }
    public function getExpenseById($id)
    {
        return $this->expenseInterface->get($id);
    }
    public function deleteExpense($id)
    {
        return $this->expenseInterface->delete($id);
    }
    public function createExpense(array $data){
        return $this->expenseInterface->create($data);
    }
    public function updateExpense(array $data, $id){
        return $this->expenseInterface->update($data, $id);
    }
}