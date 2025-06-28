<?php

namespace App\Repositories;
use App\Interface\PaymentInterface;
use App\Models\Payment;
class PaymentRepository implements PaymentInterface{

	public function create(array $data): \Illuminate\Database\Eloquent\Model|null
	{
		// TODO: Implement create() method.
		return Payment::create($data);
	}

	public function find($id): \Illuminate\Database\Eloquent\Model|null
	{
		// TODO: Implement find() method.
		return Payment::find($id);
	}

	public function getAll(): \Illuminate\Database\Eloquent\Collection
	{
		// TODO: Implement getAll() method.
		return Payment::all();
	}

	public function update(array $data, $id): \Illuminate\Database\Eloquent\Model|null
	{
		// TODO: Implement update() method.
		return Payment::find($id)->update($data);
	}

	public function delete($id): void
	{
		// TODO: Implement delete() method.
        Payment::find($id)->delete();
	}

	public function get(string $id): \Illuminate\Database\Eloquent\Model|null
	{
		// TODO: Implement get() method.
        return Payment::find($id);
	}

}