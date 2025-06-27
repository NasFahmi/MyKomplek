<?php
namespace App\Interface\Base;
use Illuminate\Database\Eloquent\Model;
interface UpdateInterface
{
    public function update(array $data, $id): ?Model;
}