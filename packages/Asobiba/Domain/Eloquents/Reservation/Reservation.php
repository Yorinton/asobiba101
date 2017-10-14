<?php

namespace Asobiba\Domain\Eloquents\Reservation;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function options()
    {
    	return $this->hasMany(Option::class);
    }

}