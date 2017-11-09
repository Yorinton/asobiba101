<?php

namespace App\Providers;

use App\Eloquents\Reservation\EloquentOption;
use App\Eloquents\Reservation\EloquentReservation;
use App\Eloquents\User\EloquentCustomer;
use Illuminate\Support\ServiceProvider;

class EloquentServiceProvider extends ServiceProvider
{

    /**
     * @var bool
     * 遅延ロードフラグ
     */

    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentCustomer::class,function($app){
            return new EloquentCustomer;
        });
        $this->app->bind(EloquentReservation::class,function($app){
           return new EloquentReservation;
        });
        $this->app->bind(EloquentOption::class,function($app){
            return new EloquentOption;
        });
    }
}
