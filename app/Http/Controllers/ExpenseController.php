<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\ExpenseService;
use App\Models\Expense;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use Illuminate\Http\Request;
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
    public function report(Request $request)
    {
        // Ambil tahun dari request atau gunakan tahun sekarang
        $year = $request->input('year', date('Y'));
        $selectedMonth = $request->input('month', null);

        // Hitung data pemasukan bulanan
        $monthlyIncome = $this->calculateMonthlyIncome($year);
        
        // Hitung data pengeluaran bulanan
        $monthlyExpense = $this->calculateMonthlyExpense($year);
        // dd($monthlyExpense);

        // Hitung total
        $totalIncome = array_sum($monthlyIncome);
        $totalExpense = array_sum($monthlyExpense);

        // Ambil data detail
        $incomes = $this->getIncomeData($year, $selectedMonth); //paginate
        // dd($incomes);
        $expenses = $this->getExpenseData($year, $selectedMonth);

        return view('pages.dashboard.pengeluaran.report', [
            'year' => $year,
            'selectedMonth' => $selectedMonth,
            'monthlyIncome' => $monthlyIncome,
            'monthlyExpense' => $monthlyExpense,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'incomes' => $incomes,
            'expenses' => $expenses
        ]);
    }

    protected function calculateMonthlyIncome($year)
    {
        $data = Payment::selectRaw('MONTH(payment_date) as month, SUM(payment_details.amount) as total')
            ->whereYear('payment_date', $year)
            ->where('status', 'lunas')
            ->join('payment_details', 'payments.id', '=', 'payment_details.payment_id')
            ->groupByRaw('MONTH(payment_date)')
            ->pluck('total', 'month')
            ->toArray();


        $monthlyIncome = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyIncome[$i] = $data[$i] ?? 0;
        }

        return $monthlyIncome;
    }

    protected function calculateMonthlyExpense($year)
    {
        $data = Expense::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyExpense = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyExpense[$i] = $data[$i] ?? 0;
        }

        return $monthlyExpense;
    }

    protected function getIncomeData($year, $month = null)
    {
        $query = Payment::with(['resident', 'house', 'paymentDetail.feeType'])
            ->whereYear('payment_date', $year)
            ->where('status', 'lunas');

        if ($month) {
            $query->whereMonth('payment_date', $month);
        }

        return $query->orderBy('payment_date', 'desc')->paginate(10);
    }

    protected function getExpenseData($year, $month = null)
    {
        $query = Expense::whereYear('date', $year);

        if ($month) {
            $query->whereMonth('date', $month);
        }

        return $query->orderBy('date', 'desc')->paginate(10);
    }


}
