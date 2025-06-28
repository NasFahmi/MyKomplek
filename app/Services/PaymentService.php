<?php

namespace App\Services;

use App\Interface\FeeTypeInterface;
use App\Interface\HouseInterface;
use App\Interface\PaymentInterface;
use App\Models\House;
use Illuminate\Database\Eloquent\Collection;

class PaymentService
{
    protected PaymentInterface $paymentRepository;
    protected FeeTypeInterface $feeTypeRepository;
    protected HouseInterface $houseRepository;

    public function __construct(PaymentInterface $paymentRepository, FeeTypeInterface $feeTypeRepository, HouseInterface $houseRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->feeTypeRepository = $feeTypeRepository;
        $this->houseRepository = $houseRepository;
    }
    public function getAllFeeType()
    {
        return $this->feeTypeRepository->getAllActiveFeeType();
    }
    public function getPaymentById($id)
    {
        return $this->paymentRepository->get($id);
    }
    public function getActiveHouseResident(): Collection
    {
        return $this->houseRepository->houseActiveResident();
    }
    public function createPayment(array $data)
    {
        return $this->paymentRepository->create($data);
    }
    public function getAllPayment(): Collection
    {
        return $this->paymentRepository->getAll();
    }
    public function getPaymentByFeeType($id)
    {
        return $this->paymentRepository->paymentByFeeType($id);
    }
    public function updatePayment($id)
    {
        return $this->paymentRepository->updateStatus($id);
    }

    public function getPaymentsForHouse(House $house, int $perPage = 10)
    {
        return $house->payment()->paginate($perPage); // Pastikan menggunakan () untuk memanggil query builder
    }


}