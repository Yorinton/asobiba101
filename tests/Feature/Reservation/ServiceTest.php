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
    }

    public function finish()
    {
        //要修正
        DB::delete('delete from customers');
        DB::statement("alter table customers auto_increment = 1");
        DB::statement("alter table options auto_increment = 1");

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

        $this->assertDatabaseHas('reservations', [
            'plan' => '【非商用】基本プラン(平日)',
            'id' => 1,
            'customer_id' => 1,
            'status' => 'Contact',
            'price' => 19500,
            'date' => '2017-11-26',
            'number' => 10
        ]);

        $this->assertDatabaseHas('customers', [
            'name' => 'テストユーザー',
            'email' => 'sansan106700@gmail.com'
        ]);

        $options = ['ゴミ処理' => 1500, 'カセットコンロ' => 1500, '宿泊(1〜3名様)' => 6000];
        foreach ($options as $option => $price) {
            $this->assertDatabaseHas('options', [
                'option' => $option,
                'price' => $price
            ]);
        }

        $this->finish();
    }

}
