<?php

namespace App\Services;

use App\Interface\FeeTypeInterface;
use Illuminate\Database\Eloquent\Collection;

class FeeTypeService
{
    protected FeeTypeInterface $feeTypeRepository;

    public function __construct(FeeTypeInterface $feeTypeRepository)
    {
        $this->feeTypeRepository = $feeTypeRepository;
    }
    public function getAllFeeType() : Collection{
        return $this->feeTypeRepository->getAllActiveFeeType();
    }
    public function getFeeType($id)
    {
        return $this->feeTypeRepository->get($id);
    }
    public function createFeeType(array $data)
    {
        return $this->feeTypeRepository->create($data);
    }
    public function updateFeeType(array $data, $id)
    {
        return $this->feeTypeRepository->update($data, $id);
    }
    public function deleteFeeType($id)
    {
        return $this->feeTypeRepository->delete($id);
    }
}