<?php

namespace Tests\Feature\Reservation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use DB;

class PurposeTest extends TestCase
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
    public function testNotAdultPurpose()
    {
        $request = makeOtherRequestWithPurpose();

        try{
            $id = $this->repository()->nextIdentity();
            $reservation = createReservation($id,$request);
            $this->assertTrue(true);
        }catch(\InvalidArgumentException $e){
            $this->fail($e->getMessage());
        }
        $this->assertTrue(true);
    }

    public function testHasAdultPurpose()
    {
        $request = makeOtherRequestWithPurpose();
        $request->purpose = 'AV撮影';

        try{
            $id = $this->repository()->nextIdentity();
            $reservation = createReservation($id,$request);
            $this->fail('例外発生無し');
        }catch(\InvalidArgumentException $e){
            $this->assertEquals('アダルト関連の目的ではご利用頂けません',$e->getMessage());

        }
        $this->assertTrue(true);
    }
}
