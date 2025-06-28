<?php
namespace App\Interface;

class ExpenseService{
    protected ExpenseInterface $expenseInterface;

    public function __construct(ExpenseInterface $expenseInterface){
        $this->expenseInterface = $expenseInterface;
    }
}