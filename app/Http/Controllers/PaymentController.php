<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Services\FeeTypeService;
use App\Services\HouseService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;
    protected HouseService $houseService;
    protected FeeTypeService $feeTypeService;

    public function __construct(PaymentService $paymentService, HouseService $houseService, FeeTypeService $feeTypeService)
    {
        $this->paymentService = $paymentService;
        $this->houseService = $houseService;
        $this->feeTypeService = $feeTypeService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fee = $this->paymentService->getAllFeeType();
        $payment = $this->paymentService->getAllPayment();
        // dd($payment);
        return view('pages.dashboard.pembayaran.index', compact('fee', 'payment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $feeTypes = $this->feeTypeService->getAllFeeType();
        $houses = $this->paymentService->getActiveHouseResident();
        // dd($houses);
        return view('pages.dashboard.pembayaran.create', compact('houses', 'feeTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        try {
            $this->paymentService->createPayment($data);
            return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dibuat.');
        } catch (\Throwable $th) {
            Log::error('create error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat Buat Pembayaran.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        // Ambil data pembayaran beserta detail per jenis iuran
        $paymentWithFees = $this->paymentService->getPaymentByFeeType($payment->id);
        // dd($paymentWithFees);    

        // Kirim semua data yang diperlukan ke view
        return view('pages.dashboard.pembayaran.show', [
            'payment' => $paymentWithFees['payment'],
            'groupedDetails' => $paymentWithFees['groupedDetails'],
            'grandTotal' => $paymentWithFees['grandTotal']
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $payment = $this->paymentService->getPaymentById($payment->id);
        return view('pages.dashboard.pembayaran.show', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, $payment)
    {
        try {
            $this->paymentService->updatePayment($payment);
            return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diupdate.');
        } catch (\Throwable $th) {
            Log::error('update error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat update Pembayaran.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
