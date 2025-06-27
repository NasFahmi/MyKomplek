<?php

namespace App\Providers;

use App\Interface\UserInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class); //Setiap kali php butuh UserInterface, berikan UserRepository, karena UserRepository implementasi UserInterface
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
