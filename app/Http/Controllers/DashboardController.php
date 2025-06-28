<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\FeeType;
use App\Models\House;
use App\Models\Payment;
use App\Models\Resident;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Data Rumah
        $totalHouses = House::count();
        $occupiedHouses = House::where('status', true)->count();

        // Data Warga
        $totalResidents = Resident::count();
        $permanentResidents = Resident::where('status', 'tetap')->count();

        // Data Pembayaran
        $currentMonthPayments = Payment::whereYear('payment_date', now()->year)
            ->whereMonth('payment_date', now()->month)
            ->where('status', 'lunas')
            ->get();

        // Data Keuangan
        $totalIncome = Payment::where('status', 'lunas')
            ->with('paymentDetail')
            ->get()
            ->sum(function ($payment) {
                return $payment->paymentDetail->sum('amount');
            });

        $totalExpense = Expense::sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Iuran Aktif
        $activeFees = FeeType::where('is_active', true)
            ->orderBy('effective_date', 'desc')
            ->limit(3)
            ->get();

        // Pembayaran Terakhir
        $recentPayments = Payment::with(['resident', 'house', 'paymentDetail'])
            ->orderBy('payment_date', 'desc')
            ->limit(5)
            ->get();

        // Pengeluaran Terakhir
        $recentExpenses = Expense::orderBy('date', 'desc')
            ->limit(5)
            ->get();

        // Data Grafik
        $months = $request->input('months', 6);
        $chartData = $this->getChartData($months);

        return view('pages.dashboard.index', array_merge([
            'totalHouses' => $totalHouses,
            'occupiedHouses' => $occupiedHouses,
            'totalResidents' => $totalResidents,
            'permanentResidents' => $permanentResidents,
            'currentMonthPayments' => $currentMonthPayments,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'activeFees' => $activeFees,
            'recentPayments' => $recentPayments,
            'recentExpenses' => $recentExpenses,
        ], $chartData));
    }

    protected function getChartData($months)
    {
        $endDate = now();
        $startDate = now()->subMonths($months - 1)->startOfMonth();

        $labels = [];
        $incomeData = [];
        $expenseData = [];

        for ($date = $startDate; $date <= $endDate; $date->addMonth()) {
            $monthYear = $date->format('M Y');
            $labels[] = $monthYear;

            // Pemasukan
            $income = Payment::whereYear('payment_date', $date->year)
                ->whereMonth('payment_date', $date->month)
                ->where('status', 'lunas')
                ->with('paymentDetail')
                ->get()
                ->sum(function ($payment) {
                    return $payment->paymentDetail->sum('amount');
                });
            $incomeData[] = $income;

            // Pengeluaran
            $expense = Expense::whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->sum('amount');
            $expenseData[] = $expense;
        }

        return [
            'chartLabels' => $labels,
            'chartIncomeData' => $incomeData,
            'chartExpenseData' => $expenseData,
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
