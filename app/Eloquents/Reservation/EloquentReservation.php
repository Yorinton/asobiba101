<?php

namespace App\Eloquents\Reservation;

use Illuminate\Database\Eloquent\Model;

class EloquentReservation extends Model
{

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'reservations';

    public function options()
    {
    	return $this->hasMany(EloquentOption::class);
    }

}