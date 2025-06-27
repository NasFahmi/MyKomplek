<?php

namespace App\Services;

use App\Interface\ResidentInterface;
use Illuminate\Database\Eloquent\Collection;


class ResidentService
{
    protected ResidentInterface $residentRepository;

    public function __construct(ResidentInterface $residentRepository)
    {
        $this->residentRepository = $residentRepository;
    }
    public function getAllResident(): Collection
    {
        return $this->residentRepository->getAll();
    }

}