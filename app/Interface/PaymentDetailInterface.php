<?php
namespace App\Interface;

use App\Interface\Base\CreateInterface;
use App\Interface\Base\DeleteInterface;
use App\Interface\Base\FindInterface;
use App\Interface\Base\GetAllInterface;
use App\Interface\Base\GetInterface;
use App\Interface\Base\UpdateInterface;
interface PaymentDetailInterface extends
    CreateInterface,
    DeleteInterface,
    FindInterface,
    GetAllInterface,
    GetInterface,
    UpdateInterface
{
}