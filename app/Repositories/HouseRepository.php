<?php

namespace App\Repositories;

use App\Interface\HouseInterface;
use App\Models\House;
use App\Models\HouseResident;
use App\Models\Resident;
use Illuminate\Database\Eloquent\Collection;
use App\Interface\Base\Model;

class HouseRepository implements HouseInterface
{
    public function get(string $id): ?House
    {
        return House::find($id);
    }
    public function create(array $data): House|null
    {
        // Implement the create logic here
        return House::create($data);
    }

    public function find($id): House|null
    {
        // Implement the find logic here
        return House::find($id);
    }

    public function getAll(): Collection
    {
        // Implement the getAll logic here
        // If $id is not needed, you can ignore it or use it as a filter
        return House::all();
    }

    public function update(array $data, $id): House|null
    {
        // Implement the update logic here
        $house = House::find($id);
        if ($house) {
            $house->update($data);
        }
        return $house;
    }

    public function delete($id): void
    {
        // Implement the delete logic here
        $house = House::find($id);
        if ($house) {
            $house->delete();
        }
    }
    public function createResidentForHouse(House $house, array $data): Resident
    {
        // make new resident
        $resident = Resident::create($data);
        
        HouseResident::create([
            'house_id' => $house->id,
            'resident_id' => $resident->id,
            'date_of_entry' => now(),
        ]);
        // ketika sudah memiliki penghuni maka status house akan menjadi aktif
        House::find($house->id)->update(['status' => 1]);
        // dd($houseResident);
        return $resident;
    }
}