<?php

namespace Tests\Feature\Reservation;

use App\Eloquents\Reservation\EloquentOption;
use App\Eloquents\Reservation\EloquentReservation;
use App\Eloquents\User\EloquentCustomer;
use Asobiba\Application\Service\AcceptanceReservationService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    private $eloqReservation;
    private $eloqCustomer;
    private $eloqOption;

    public function prepare()
    {
        DB::table('reservation_seqs')->insert(["nextval" => 0]);
        $this->eloqReservation = $this->app->make(EloquentReservation::class);
        $this->eloqCustomer = $this->app->make(EloquentCustomer::class);
        $this->eloqOption = $this->app->make(EloquentOption::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testReserve()
    {
        $this->prepare();

        $request = makeCorrectRequest();

        AcceptanceReservationService::reserve($request);

        $this->assertEquals('【非商用】基本プラン(平日)',$this->eloqReservation->where('id',1)->first()->plan);
        $this->assertEquals(1,$this->eloqReservation->where('id',1)->first()->id);
        $this->assertEquals(1,$this->eloqReservation->where('id',1)->first()->customer_id);
        $this->assertEquals('Contact',$this->eloqReservation->where('id',1)->first()->status);
        $this->assertEquals('テストユーザー',$this->eloqCustomer->where('id',1)->first()->name);
        $this->assertEquals('ゴミ処理',$this->eloqOption->where('id',1)->first()->option);
        $this->assertEquals(1500,$this->eloqOption->where('id',1)->first()->price);

    }
}
