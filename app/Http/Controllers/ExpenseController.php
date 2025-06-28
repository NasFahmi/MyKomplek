<?php

namespace App\Http\Controllers;

use App\Services\ExpenseService;
use App\Models\Expense;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{

    protected ExpenseService $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expense = $this->expenseService->getExpense();
        // dd($expense);
        return view('pages.dashboard.pengeluaran.index', compact('expense'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.pengeluaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        $date = $request->validated();
        try {
            $this->expenseService->createExpense($date);
            return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dibuat.');
        } catch (\Throwable $th) {
            Log::error('create error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat create pengeluaran.');

        }
        // $expense = $this->expenseService->createExpense($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $expense = $this->expenseService->getExpenseById($expense->id);
        return view('pages.dashboard.pengeluaran.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $expense = $this->expenseService->getExpenseById($expense->id);
        return view('pages.dashboard.pengeluaran.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $data = $request->validated();
        try {
            $this->expenseService->updateExpense($data, $expense->id);
            return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil diupdate.');
        } catch (\Throwable $th) {
            Log::error('update error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat update pengeluaran.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        try {
            $this->expenseService->deleteExpense($expense->id);
            return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus.');
        } catch (\Throwable $th) {
            Log::error('delete error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat delete pengeluaran.');
        }
    }
    public function report()
    {
        return view('pages.dashboard.pengeluaran.report');
    }
}
