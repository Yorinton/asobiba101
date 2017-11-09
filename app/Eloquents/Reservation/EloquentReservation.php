<?php

namespace App\Eloquents\Reservation;

use App\Eloquents\User\EloquentCustomer;
use Illuminate\Database\Eloquent\Model;

class EloquentReservation extends Model
{

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'reservations';

    public function customer()
    {
        return $this->belongsTo(EloquentCustomer::class);
    }

    public function options()
    {
    	return $this->hasMany(EloquentOption::class,'reservation_id');
    }

}