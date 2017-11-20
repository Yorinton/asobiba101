<?php

namespace Asobiba\Domain\Models\Factory;

use Asobiba\Domain\Models\User\Customer;
use Asobiba\Domain\Models\User\CustomerEmail;
use Asobiba\Domain\Models\User\CustomerId;
use Asobiba\Domain\Models\User\CustomerName;
use Illuminate\Http\Request;

class CustomerFactory
{
    public function createFromRequest(CustomerId $customerId,Request $req):Customer
    {
        return new Customer(
            $customerId,
            new CustomerName($req->name),
            new CustomerEmail($req->email)
        );
    }
}