<?php

namespace Tests\Feature\Reservation;

use Asobiba\Application\Service\AcceptanceReservationService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

class ServiceTest extends TestCase
{
    use RefreshDatabase;


    public function prepare()
    {
        DB::table('reservation_seqs')->insert(["nextval" => 0]);
    }

    public function finish()
    {
        //要修正
        DB::delete('delete from reservation_seqs');
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

        //１つ目の予約
        $request = reqToArray(makeCorrectRequest());

        $service = $this->app->make(AcceptanceReservationService::class);
        $service->reserve($request);

        $this->assertDatabaseHas('reservations', [
            'plan' => '【非商用】基本プラン(平日)',
            'id' => 1,
            'name' => 'テストユーザー',
            'email' => 'sansan106700@gmail.com',
            'status' => 'Contact',
            'price' => 19500,
            'date' => '2017-11-26',
            'number' => 10
        ]);


        $options = ['ゴミ処理' => 1500, 'カセットコンロ' => 1500, '宿泊(1〜3名様)' => 6000];
        foreach ($options as $option => $price) {
            $this->assertDatabaseHas('options', [
                'option' => $option,
                'price' => $price
            ]);
        }


        //２つ目の予約
        $request2 = reqToArray(makeCorrectRequest());
        $service->reserve($request2);

        $this->assertDatabaseHas('reservations', [
            'plan' => '【非商用】基本プラン(平日)',
            'id' => 2,
            'name' => 'テストユーザー',
            'email' => 'sansan106700@gmail.com',
            'status' => 'Contact',
            'price' => 19500,
            'date' => '2017-11-26',
            'number' => 10
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

    //予約済み日程での予約の場合
    public function testCheckCalenderNotAvailable()
    {
        $request = reqToArray(makeCorrectRequest());

        $service = $this->app->make(AcceptanceReservationService::class);

        try {
            $service->reserve($request);
            $this->fail('例外無し');
        }catch(\InvalidArgumentException $e){
            $this->assertEquals('ご希望の時間帯は別の方が予約済みです',$e->getMessage());
        }

    }

    public function testRequestToArray()
    {
        $request = makeCorrectRequest();

        $array = reqToArray($request);
        dd($array);

        $this->assertTrue(true);

    }

}
