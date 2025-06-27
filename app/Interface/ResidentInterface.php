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
    
}