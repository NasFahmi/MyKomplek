<?php
namespace App\Repositories;

use App\Models\HouseResident;
use App\Models\Resident;
use App\Interface\ResidentInterface;

class ResidentRepository implements ResidentInterface
{
	public function get(string $id): \Illuminate\Database\Eloquent\Model|null
	{
		// TODO: Implement get() method.
		return Resident::find($id);
	}

	public function find($id): \Illuminate\Database\Eloquent\Model|null
	{
		// TODO: Implement find() method.
		return Resident::find($id);
	}

	public function getAll(): \Illuminate\Database\Eloquent\Collection
	{
		// TODO: Implement getAll() method.
		return Resident::all();
	}

	public function getPaginate($paginate): \Illuminate\Contracts\Pagination\LengthAwarePaginator
	{
		// TODO: Implement getAll() method.
		return Resident::paginate($paginate);
	}

	public function create(array $data): \Illuminate\Database\Eloquent\Model|null
	{
		// TODO: Implement create() method.
		// create resident
		return Resident::create($data);
	}
	public function createWithHouse(string $houseId, array $data): Resident|null
	{
		// TODO: Implement create() method.
		// create resident
		$resident = Resident::create($data);
		// create resident house
		HouseResident::create([
			'house_id' => $houseId,
			'resident_id' => $resident->id,
			'date_of_entry' => now(),
		]);
		return $resident;
	}

	public function update(array $data, $id): \Illuminate\Database\Eloquent\Model|null
	{
		// TODO: Implement update() method.
		$resident = Resident::find($id);
		if ($resident) {
			$resident->update($data);
		}
		return $resident;
	}

	public function delete($id): void
	{
		// TODO: Implement delete() method.
		$resident = Resident::find($id);
		if ($resident) {
			$resident->delete();
			// delete ResidentHouse
			// HouseResident::where('resident_id', $id)->delete();
		}
	}
	public function residentCheckout($id): Resident
	{
		// 1. Update data di tabel residents (ini sudah benar)
		$resident = Resident::find($id);
		$resident->update([
			'resident_status' => 0,
		]);

		// 2. Cari record pivot HouseResident yang sesuai
		$houseResident = HouseResident::where('resident_id', $id)
			->whereNull('date_of_exit') // Pastikan hanya mengupdate yang masih aktif
			->first();

		// 3. Update melalui instance model agar Observer terpicu
		if ($houseResident) {
			$houseResident->update(['date_of_exit' => now()]);
		}

		return $resident;
	}
	public function getHistoryResident(){
		return Resident::where('resident_status', 0)->get();
	}
}
