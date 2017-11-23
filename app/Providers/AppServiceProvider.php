<?php

namespace App\Providers;

use Asobiba\Application\Service\AcceptanceReservationService;
use Asobiba\Domain\Models\Factory\CustomerFactory;
use Asobiba\Domain\Models\Factory\ReservationFactory;
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
        $this->app->bind(AcceptanceReservationService::class,function(){
                return new AcceptanceReservationService(
                    $this->app->make(CustomerRepositoryInterface::class),
                    $this->app->make(ReservationRepositoryInterface::class),
                    $this->app->make(ReservationNotificationInterface::class)
                );
            }
        );
        $this->app->bind(ReservationFactory::class,function(){
            return new ReservationFactory(
                new CustomerFactory()
            );
        });
    }
}
