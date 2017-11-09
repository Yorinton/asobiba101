<?php

namespace Tests\Feature\Reservation;

use App\Eloquents\Reservation\EloquentOption;
use App\Eloquents\Reservation\EloquentReservation;
use App\Eloquents\User\EloquentCustomer;
use Asobiba\Domain\Models\User\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use DB;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function repository()
    {
        DB::table('reservation_seqs')->insert(["nextval" => 0]);
        return new EloquentReservationRepository;
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddReservationToDB()
    {

        $request = makeCorrectRequest();

        $customer = new Customer($request->name, $request->email);
        $id = $this->repository()->nextIdentity();
        $reservation = createReservation($id, $request);
        $this->repository()->add($customer, $reservation);//DBに保存

        $eloquentReservation = $this->app->make(EloquentReservation::class);
        $eloquentCustomer = $this->app->make(EloquentCustomer::class);
        $eloquentOption = $this->app->make(EloquentOption::class);

        $this->assertEquals('【非商用】基本プラン(平日)', $eloquentReservation->where('id', 1)->first()->plan);
        $this->assertEquals(1, $eloquentReservation->where('id', 1)->first()->id);
        $this->assertEquals(1, $eloquentReservation->where('id', 1)->first()->customer_id);
        $this->assertEquals('Contact', $eloquentReservation->where('id', 1)->first()->status);
        $this->assertEquals('テストユーザー', $eloquentCustomer->where('id', 1)->first()->name);
        $this->assertEquals('ゴミ処理', $eloquentOption->where('id', 1)->first()->option);
        $this->assertEquals(1500, $eloquentOption->where('id', 1)->first()->price);


    }
}
