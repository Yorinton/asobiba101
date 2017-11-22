<?php

namespace Asobiba\Infrastructure\Repositories;

use App\Eloquents\Reservation\EloquentReservation;
use App\Eloquents\Reservation\EloquentOption;
use App\Eloquents\User\EloquentCustomer;
use Asobiba\Domain\Models\Factory\CustomerFactory;
use Asobiba\Domain\Models\Repositories\Reservation\CustomerRepositoryInterface;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\User\Customer;
use Asobiba\Domain\Models\User\CustomerId;
use DB;
use Illuminate\Http\Request;


class EloquentCustomerRepository implements CustomerRepositoryInterface
{

    private $factory;
    private $sequence_table_name = 'customer_seqs';

    public function __construct(CustomerFactory $factory)
    {
        $this->factory = $factory;
    }


    public function nextIdentity(): CustomerId
    {
        DB::table($this->sequence_table_name)->update(["nextval" => DB::raw("LAST_INSERT_ID(nextval + 1)")]);
        $customerId = DB::table($this->sequence_table_name)->selectRaw("LAST_INSERT_ID() as id")->first()->id;

        return new CustomerId($customerId);
    }

    public function new(Request $req): Customer
    {
        $customerId = $this->nextIdentity();
        return $this->factory->createFromRequest($customerId,$req);
    }
    /**
     * @param Reservation $reservation
     */
    public function persist(Customer $customer)
    {
        DB::beginTransaction();
        try {
            //Customerの永続化
            $eloquentCustomer = new EloquentCustomer();
            $eloquentCustomer->id = $customer->getId()->getId();
            $eloquentCustomer->name = $customer->getName()->getName();
            $eloquentCustomer->email = $customer->getEmail()->getEmail();
            $eloquentCustomer->save();

            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();
            dd($e->getMessage());
        }
    }


}
