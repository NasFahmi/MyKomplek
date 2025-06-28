<?php

namespace App\Services;
use App\Interface\HouseInterface;
use App\Interface\ResidentInterface;
use App\Models\House;
use App\Models\Resident;
use Illuminate\Database\Eloquent\Collection;

class HouseService
{
    protected HouseInterface $houseRepository;
    protected ResidentInterface $residentRepository;

    public function __construct(HouseInterface $houseRepository, ResidentInterface $residentRepository)
    {
        $this->houseRepository = $houseRepository;
        $this->residentRepository = $residentRepository;
    }
    public function getAllHouse(): Collection
    {
        return $this->houseRepository->getAll();
    }
    public function getHouse(House $house): ?House
    {
        return $this->houseRepository->get($house->id);
    }
    public function getHouseById(string $id): ?House
    {
        return $this->houseRepository->get($id);
    }
    public function createHouse(array $data): ?House
    {
        return $this->houseRepository->create($data);
    }
    public function updateHouse(array $data, string $id): ?House
    {
        return $this->houseRepository->update($data, $id);
    }
    public function deleteHouse($id): void
    {
        $this->houseRepository->delete($id);
    }
    public function createResidentForHouse(House $house, array $data): ?Resident
    {
        // Panggil repository untuk berinteraksi dengan database
        return $this->houseRepository->createResidentForHouse($house, $data);
    }
    public function getResidentById($id){
        return $this->residentRepository->get($id);
    }
    public function residentCheckout($id){
        return $this->residentRepository->residentCheckout($id);
    }
   
}