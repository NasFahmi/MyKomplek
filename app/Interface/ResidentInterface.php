<?php
namespace App\Interface;

use App\Interface\Base\CreateInterface;
use App\Interface\Base\DeleteInterface;
use App\Interface\Base\FindInterface;
use App\Interface\Base\GetAllInterface;
use App\Interface\Base\GetInterface;
use App\Interface\Base\GetPaginateInterface;
use App\Interface\Base\UpdateInterface;
use App\Models\Resident;

interface ResidentInterface extends GetInterface, FindInterface, GetAllInterface, CreateInterface, UpdateInterface, DeleteInterface, GetPaginateInterface {
    public function residentCheckout($id):Resident;
    // Override the inherited create method with a compatible signature
    // If you need a custom method with houseId, use a different name
    public function createWithHouse(string $houseId, array $data): Resident|null;
}