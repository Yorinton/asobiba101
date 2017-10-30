<?php

namespace App\Eloquents\Reservation;

use Illuminate\Database\Eloquent\Model;

class EloquentOption extends Model
{
    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'options';

    public function reservation()
    {
        return $this->belongsTo(EloquentReservation::class);
    }

}