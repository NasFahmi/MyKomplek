<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Services\FeeTypeService;
use App\Services\HouseService;
use App\Services\PaymentService;

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
        // dd($fee);
        return view('pages.dashboard.pembayaran.index', compact('fee'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $feeTypes = $this->feeTypeService->getAllFeeType();
        $houses = $this->paymentService->getActiveHouseResident();
        // dd($houses);
        return view('pages.dashboard.pembayaran.create', compact('houses','feeTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment = $this->paymentService->getPaymentById($payment->id);
        return view('pages.dashboard.pembayaran.show', compact('payment'));
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
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
