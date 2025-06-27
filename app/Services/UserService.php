<?php

namespace App\Services;

use App\Interface\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Session;



class UserService
{
    protected UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $credentials): bool
    {
        $authenticated = $this->userRepository->login($credentials);

        if ($authenticated) {
            Session::regenerate(); // untuk keamanan session
        }

        return $authenticated;
    }

    public function updateUserPassword(string $newPassword): bool
    {
        $username = auth()->user()->username;
        // Panggil repository untuk melakukan update
        return $this->userRepository->updatePassword($username, $newPassword);
    }

    public function logout(): void
    {
        $this->userRepository->logout();
    }

}
