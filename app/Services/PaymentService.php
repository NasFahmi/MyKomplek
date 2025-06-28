<?php

namespace App\Services;

use App\Interface\FeeTypeInterface;
use App\Interface\HouseInterface;
use App\Interface\PaymentInterface;
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
    public function getActiveHouseResident() : Collection {
        return $this->houseRepository->houseActiveResident();
    }

}