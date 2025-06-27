<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Http\Requests\StoreResidentRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Services\ResidentService;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    protected ResidentService $ResidentService;

    public function __construct(ResidentService $ResidentService)
    {
        $this->ResidentService = $ResidentService;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResidentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Resident $resident)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resident $resident)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResidentRequest $request, Resident $resident)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resident $resident)
    {
        //
    }
}
