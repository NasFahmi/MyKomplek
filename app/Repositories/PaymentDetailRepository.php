<?php
namespace App\Repositories;

use App\Interface\PaymentDetailInterface;
use App\Models\PaymentDetail;
class PaymentDetailRepository implements PaymentDetailInterface
{

    public function create(array $data): \Illuminate\Database\Eloquent\Model|null
    {
        // TODO: Implement create() method.
        return PaymentDetail::create($data);
    }

    public function find($id): \Illuminate\Database\Eloquent\Model|null
    {
        // TODO: Implement find() method.
        return PaymentDetail::find($id);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        // TODO: Implement getAll() method.
        return PaymentDetail::all();
    }

    public function update(array $data, $id): \Illuminate\Database\Eloquent\Model|null
    {
        // TODO: Implement update() method.
        return PaymentDetail::find($id)->update($data);
    }

    public function delete($id): void
    {
        // TODO: Implement delete() method.
        PaymentDetail::find($id)->delete();
    }

    public function get(string $id): \Illuminate\Database\Eloquent\Model|null
    {
        // TODO: Implement get() method.
        return PaymentDetail::find($id);
    }
}