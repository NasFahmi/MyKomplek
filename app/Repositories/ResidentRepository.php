<?php
namespace App\Repositories;

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
		return Resident::create($data);
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
		}
	}
}