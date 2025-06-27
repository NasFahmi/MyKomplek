<?php

namespace App\Services;

use App\Interface\ResidentInterface;
use App\Models\Resident;
use Illuminate\Database\Eloquent\Collection;


class ResidentService
{
    protected ResidentInterface $residentRepository;

    public function __construct(ResidentInterface $residentRepository)
    {
        $this->residentRepository = $residentRepository;
    }
    public function getAllResident(): Collection
    {
        return $this->residentRepository->getAll();
    }
    public function getResident(Resident $resident) : Resident {
        return $this->residentRepository->get($resident->id);
    }
    public function getResidentById($id)
    {
        return $this->residentRepository->get($id);
    }
    public function residentCheckout($id)
    {
        return $this->residentCheckout($id);
    }
    public function createResidentForHouse(string $houseId, array $data)
    {
        return $this->residentRepository->createWithHouse($houseId, $data);
    }
    public function deleteResident($id)
    {
        return $this->residentRepository->delete($id);
    }
    public function updateResident(array $data,string $id){
        return $this->residentRepository->update($data, $id);
    }

}