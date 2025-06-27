<?php
namespace App\Repositories;

use App\Interface\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserRepository implements UserInterface
{
    public function login(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    public function updatePassword(string $username, string $newPassword): bool
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return false;
        }

        // Hash password baru sebelum disimpan
        $user->password = Hash::make($newPassword);
        return $user->save();
    }

    public function logout(): void
    {
        Auth::logout();
    }
}