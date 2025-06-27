<?php
namespace App\Interface\Base;
use Illuminate\Database\Eloquent\Model;
interface GetInterface
{
    public function get(string $id): ?Model;
}