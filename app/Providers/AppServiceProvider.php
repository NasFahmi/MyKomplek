<?php

namespace App\Providers;

use App\Interface\ExpenseInterface;
use App\Interface\FeeTypeInterface;
use App\Interface\PaymentDetailInterface;
use App\Repositories\ExpenseRepository;
use App\Repositories\FeeTypeRepository;
use App\Interface\HouseInterface;
use App\Interface\PaymentInterface;
use App\Interface\ResidentInterface;
use App\Interface\UserInterface;
use App\Models\HouseResident;
use App\Observers\HouseResidentObserver;
use App\Repositories\HouseRepository;
use App\Repositories\PaymentDetailRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ResidentRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <--- PASTIKAN INI DI-IMPORT

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class); //Setiap kali php butuh UserInterface, berikan UserRepository, karena UserRepository implementasi UserInterface
        $this->app->bind(HouseInterface::class, HouseRepository::class);
        $this->app->bind(ResidentInterface::class,ResidentRepository::class );
        $this->app->bind(PaymentInterface::class, PaymentRepository::class);
        $this->app->bind(FeeTypeInterface::class, FeeTypeRepository::class);
        $this->app->bind(PaymentDetailInterface::class, PaymentDetailRepository::class);
        $this->app->bind(ExpenseInterface::class, ExpenseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind(); // <--- TAMBAHKAN BARIS INI
        HouseResident::observe(HouseResidentObserver::class);
    }
}
