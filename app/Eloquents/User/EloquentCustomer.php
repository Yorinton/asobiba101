<?php

namespace App\Eloquents\User;

use App\Eloquents\Reservation\EloquentReservation;
use Illuminate\Database\Eloquent\Model;

class EloquentCustomer extends Model
{
    protected $table = 'customers';

    public function reservation()
    {
        return $this->hasOne(EloquentReservation::class,'customer_id');
    }
}
