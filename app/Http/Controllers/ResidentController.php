<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Http\Requests\StoreResidentRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Services\HouseService;
use App\Services\ResidentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResidentController extends Controller
{
    protected ResidentService $ResidentService;
    protected HouseService $HouseService;

    public function __construct(ResidentService $ResidentService, HouseService $HouseService)
    {
        $this->ResidentService = $ResidentService;
        $this->HouseService = $HouseService;

    }

    public function index(Request $request)
    {
        $resident = $this->ResidentService->getAllResident();
        // $resident = Resident::paginate(100000);
        return view('pages.dashboard.warga.index', compact('resident'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $house = $this->HouseService->getAllHouse();
        // dd($house);
        return view('pages.dashboard.warga.create', compact('house'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResidentRequest $request)
    {
        $data = $request->validated();
        // dd($data['house']);
        // 2. Handle file upload untuk 'identity_photo'
        if ($request->hasFile('identity_photo')) {
            // Simpan file di 'storage/app/public/identity_photos'
            // dan dapatkan path-nya untuk disimpan di database.
            $path = $request->file('identity_photo')->store('identity_photos', 'public');
            $data['identity_photo'] = $path;
        }
        try {
            $houseId = $data['house'];
            $this->ResidentService->createResidentForHouse($houseId, $data);
            return redirect()->route('warga.index')->with('success', 'Berhasil Menambahkan Penghuni Rumah.');

        } catch (\Throwable $th) {
            Log::error('Create resident error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menambahkan penghuni.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Resident $resident)
    {
        $resident = $this->ResidentService->getResident($resident);
        return view('pages.dashboard.warga.show', compact('resident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resident $resident)
    {
        $house = $this->HouseService->getAllHouse();
        $resident = $this->ResidentService->getResident($resident);
        return view('pages.dashboard.warga.edit', compact('resident', 'house'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResidentRequest $request, Resident $resident)
    {
        try {
            $data = $request->validated();
            $this->ResidentService->updateResident($data, $resident->id);
            return redirect()->route('warga.show', $resident->id)->with('success', 'Berhasil Update warga Rumah.');
        } catch (\Throwable $th) {
            Log::error('Create resident error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat update warga.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resident $resident)
    {
        try {
            $this->ResidentService->deleteResident($resident->id);
            return redirect()->route('warga.index')->with('success', 'Berhasil Menghapus warga Rumah.');

        } catch (\Throwable $th) {
            Log::error('Create resident error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menambahkan warga.');
        }
    }
    public function checkout($id)
    {
        // resident Id

        try {
            $resident = $this->ResidentService->residentCheckout($id);
            return redirect()->route('warga.show', $id)->with('success', 'Berhasil Checkout Warga');
        } catch (\Throwable $th) {
            Log::error('Create resident error', ['error' => $th->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menambahkan penghuni.');
        }

    }
}
