<?php

namespace App\Interface\Base;

use Illuminate\Database\Eloquent\Model;

interface FindInterface
{
    public function find($id): ?Model;
}