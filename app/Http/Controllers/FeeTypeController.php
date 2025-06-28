<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use App\Http\Requests\StoreFeeTypeRequest;
use App\Http\Requests\UpdateFeeTypeRequest;
use App\Services\FeeTypeService;
use Illuminate\Support\Facades\Log;

class FeeTypeController extends Controller
{
    protected FeeTypeService $feeTypeService;

    public function __construct(FeeTypeService $feeTypeService)
    {
        $this->feeTypeService = $feeTypeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.iuran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeTypeRequest $request)
    {
        $data = $request->validated();
        try {
            $this->feeTypeService->createFeeType($data);
            return redirect()->route('pembayaran.index')->with('success', 'Iuran berhasil ditambahkan.');
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Create error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat create iuran.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FeeType $feeType)
    {
        // Ambil ulang FeeType lengkap dengan data relasi jika perlu
        $feeType = $this->feeTypeService->getFeeType($feeType->id);

        // Ambil relasi PaymentDetails dengan Pagination
        $paymentDetails = $feeType->paymentDetails()
            ->with('payment.resident')
            ->latest()
            ->paginate(10);
        return view('pages.dashboard.iuran.show', compact('feeType','paymentDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeeType $feeType)
    {
        $feeType = $this->feeTypeService->getFeeType($feeType->id);
        return view('pages.dashboard.iuran.edit', compact('feeType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeTypeRequest $request, FeeType $feeType)
    {
        $data = $request->validated();
        try {
            $this->feeTypeService->updateFeeType($data, $feeType->id);
            return redirect()->route('pembayaran.index')->with('success', 'Iuran berhasil ditambahkan.');
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('update error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat update iuran.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeeType $feeType)
    {
        try {
            $this->feeTypeService->deleteFeeType($feeType->id);
            return redirect()->route('pembayaran.fee-type.show', $feeType->id)->with('success', 'Iuran berhasil dinonaktifkan.');
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('delete error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat delete iuran.');
        }
    }
}
