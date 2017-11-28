<?php

namespace Tests\Feature\Reservation;

use Asobiba\Domain\Models\Factory\ReservationFactory;
use Asobiba\Domain\Models\Notification\ReservationNotificationInterface;
use Asobiba\Domain\Models\Repositories\Reservation\CustomerRepositoryInterface;
use Asobiba\Domain\Models\Repositories\Reservation\ReservationRepositoryInterface;
use Infrastructure\Notification\MailReservationNotification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

class NotifyTest extends TestCase
{
    use RefreshDatabase;

    public function prepare()
    {
        DB::table('reservation_seqs')->insert(["nextval" => 0]);
        DB::table('customer_seqs')->insert(["nextval" => 0]);
    }

    public function finish()
    {
        //要修正
        DB::delete('delete from customer_seqs');
        DB::delete('delete from reservation_seqs');
        DB::delete('delete from customers');
        DB::statement("alter table options auto_increment = 1");

    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNotifyToCustomerWithQuestion()
    {
        $this->prepare();

        $req = reqToArray(makeCorrectRequest());

        //Notificationの生成
        $notification = $this->app->make(ReservationNotificationInterface::class);

        //一意な識別子の生成
        $customerRepo = $this->app->make(CustomerRepositoryInterface::class);
        $reservationRepo = $this->app->make(ReservationRepositoryInterface::class);
        $customerId = $customerRepo->nextIdentity();
        $reservationId = $reservationRepo->nextIdentity();

        //Reservationエンティティの生成
        $factory = $this->app->make(ReservationFactory::class);
        $reservation = $factory->createFromRequest($customerId,$reservationId,$req);

        $notification->notifyToCustomer($reservation);

        $this->assertTrue(true);

        $this->finish();
    }

    public function testNotifyToCustomerWithoutQuestion()
    {
        $this->prepare();

        $req = reqToArray(makeRequestWithoutQuestion());

        //Notificationの生成
        $notification = $this->app->make(ReservationNotificationInterface::class);

        //一意な識別子の生成
        $customerRepo = $this->app->make(CustomerRepositoryInterface::class);
        $reservationRepo = $this->app->make(ReservationRepositoryInterface::class);
        $customerId = $customerRepo->nextIdentity();
        $reservationId = $reservationRepo->nextIdentity();

        //Reservationエンティティの生成
        $factory = $this->app->make(ReservationFactory::class);
        $reservation = $factory->createFromRequest($customerId,$reservationId,$req);

        $notification->notifyToCustomer($reservation);

        $this->assertTrue(true);

        $this->finish();
    }
}
