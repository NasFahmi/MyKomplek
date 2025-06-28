<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResidentHouseRequest;
use App\Models\House;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Services\FeeTypeService;
use App\Services\HouseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\View;

class HouseController extends Controller
{
    protected HouseService $houseService;
    protected FeeTypeService $feeTypeService;

    public function __construct(HouseService $houseService, FeeTypeService $feeTypeService)
    {
        $this->houseService = $houseService;
        $this->feeTypeService = $feeTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $houses = $this->houseService->getAllHouse();
        return view('pages.dashboard.rumah.index', compact('houses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.rumah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHouseRequest $request)
    {
        // validate
        $data = $request->validated();
        Log::info($data);
        try {
            $this->houseService->createHouse($data);
            return redirect()->route('rumah.index')->with('success', 'Rumah berhasil ditambahkan.');
        } catch (\Throwable $th) {
            Log::error('create error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat create rumah.');
            // throw $th;
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        $house = $this->houseService->getHouse($house);
        $history = $this->houseService->getHouse($house);

        $paymentDetails = $house->payment()->paginate(10);
        // dd($house->houseResidents->whereNull('date_of_exit'));
        return view('pages.dashboard.rumah.show', compact('house', 'history','paymentDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        $house = $this->houseService->getHouse($house);
        return view('pages.dashboard.rumah.edit', compact('house'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHouseRequest $request, House $house)
    {
        // validate
        $data = $request->validated();
        // dd($data);
        try {
            $this->houseService->updateHouse($data, $house->id);
            return redirect()->route('rumah.show', $house->id)->with('success', 'Rumah berhasil diupdate.');
        } catch (\Throwable $th) {
            Log::error('update error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat update rumah.');
            // throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        try {
            $this->houseService->deleteHouse($house->id);
            return redirect()->route('rumah.index')->with('success', 'Rumah berhasil dihapus');
        } catch (\Throwable $th) {
            Log::error('delete error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat delete rumah.');
        }
    }

    public function createResident($id)
    {
        $house = $this->houseService->getHouseById($id);
        return view('pages.dashboard.rumah.create_resident', compact('house'));
    }
    public function storeResident(StoreResidentHouseRequest $request, House $house)
    {
        // / 1. Ambil data yang sudah divalidasi
        $data = $request->validated();

        // 2. Handle file upload untuk 'identity_photo'
        if ($request->hasFile('identity_photo')) {
            // Simpan file di 'storage/app/public/identity_photos'
            // dan dapatkan path-nya untuk disimpan di database.
            $path = $request->file('identity_photo')->store('identity_photos', 'public');
            $data['identity_photo'] = $path;
        }

        try {
            // 3. Panggil method yang benar di service untuk MEMBUAT PENGHUNI, bukan rumah
            $this->houseService->createResidentForHouse($house, $data);

            return redirect()->route('rumah.show', $house->id)->with('success', 'Berhasil Menambahkan Penghuni Rumah.');
        } catch (\Throwable $th) {
            Log::error('Create resident error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menambahkan penghuni.');
        }
    }
    public function showResident($house, $resident)
    {
        // dd($resident);
        $houseData = $this->houseService->getHouseById($house);
        $residentData = $this->houseService->getResidentById($resident);
        // dd($residentData);
        return view('pages.dashboard.rumah.resident_show', compact('houseData', 'residentData'));
    }
    public function checkoutResident($house, $resident)
    {
        try {
            $resident = $this->houseService->residentCheckout($resident);
            return redirect()->route('rumah.show', $house)->with('success', 'Berhasil Checkout Warga');
        } catch (\Throwable $th) {
            Log::error('Create resident error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menambahkan penghuni.');
        }
    }
}
