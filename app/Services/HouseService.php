<?php

namespace App\Services;
use App\Interface\HouseInterface;
use App\Models\House;
use Illuminate\Database\Eloquent\Collection;

class HouseService
{
    protected HouseInterface $houseRepository;

    public function __construct(HouseInterface $houseRepository)
    {
        $this->houseRepository = $houseRepository;
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
    public function createResidentByHouse(array $data, string $id): ?House
    {
        return $this->houseRepository->createResidentByHouse($data, $id);
    }
}