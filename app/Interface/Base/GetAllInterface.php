<?php
namespace App\Interface\Base;
use Illuminate\Database\Eloquent\Collection;
interface GetAllInterface
{
    public function getAll(): Collection;
}