<?php
namespace App\Interface;

use App\Interface\Base\CreateInterface;
use App\Interface\Base\DeleteInterface;
use App\Interface\Base\FindInterface;
use App\Interface\Base\GetAllInterface;
use App\Interface\Base\GetInterface;
use App\Interface\Base\UpdateInterface;
use App\Models\House;
use App\Models\HouseResident;
use App\Models\Resident;
use Illuminate\Database\Eloquent\Collection;

interface HouseInterface extends CreateInterface, FindInterface, GetAllInterface, UpdateInterface, DeleteInterface, GetInterface
{
     public function createResidentForHouse(House $house, array $data): ?Resident;
      public function houseActiveResident(): Collection;
}