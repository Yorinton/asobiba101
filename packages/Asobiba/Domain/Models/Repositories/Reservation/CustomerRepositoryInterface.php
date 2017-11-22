<?php

namespace Asobiba\Domain\Models\Repositories\Reservation;

use Asobiba\Domain\Models\User\Customer;
use Asobiba\Domain\Models\User\CustomerId;
use Illuminate\Http\Request;

interface CustomerRepositoryInterface
{
    public function nextIdentity();

    public function new(Request $req);

    public function persist(Customer $customer);

}
