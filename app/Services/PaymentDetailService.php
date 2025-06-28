<?php

namespace App\Services;

use App\Interface\PaymentDetailInterface;
class PaymentDetailService {
    protected PaymentDetailInterface $paymentReposutitory;

    public function __construct(PaymentDetailInterface $paymentReposutitory)
    {
        $this->paymentReposutitory = $paymentReposutitory;
    }
}