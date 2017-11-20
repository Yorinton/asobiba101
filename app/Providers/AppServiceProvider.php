<?php

namespace App\Providers;

use Asobiba\Domain\Models\Notification\ReservationNotificationInterface;
use Asobiba\Domain\Models\Repositories\Reservation\CustomerRepositoryInterface;
use Asobiba\Domain\Models\Repositories\Reservation\ReservationRepositoryInterface;
use Asobiba\Infrastructure\Repositories\EloquentCustomerRepository;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Notification\MailReservationNotification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ReservationRepositoryInterface::class,
            EloquentReservationRepository::class
        );
        $this->app->bind(
            CustomerRepositoryInterface::class,
            EloquentCustomerRepository::class
        );
        $this->app->bind(
          ReservationNotificationInterface::class,
          MailReservationNotification::class
        );
    }
}
