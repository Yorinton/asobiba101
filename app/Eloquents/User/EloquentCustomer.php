<?php

namespace App\Eloquents\User;

use Illuminate\Database\Eloquent\Model;

class EloquentCustomer extends Model
{
    protected $table = 'customers';

    public function reservation()
    {

    }
}
