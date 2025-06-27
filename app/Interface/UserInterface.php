<?php

namespace App\Interface;

use App\Interface\Base\CreateInterface;
use App\Interface\Base\DeleteInterface;
use App\Interface\Base\FindInterface;
use App\Interface\Base\GetAllInterface;
use App\Interface\Base\UpdateInterface;

interface UserInterface
{
    public function login(array $credentials): bool;
    public function updatePassword(string $username, string $newPassword): bool;
    public function logout(): void;

}