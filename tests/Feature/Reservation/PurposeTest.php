<?php

namespace Tests\Feature\Reservation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Asobiba\Domain\Models\Reservation\Reservation;


class PurposeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNotAdultPurpose()
    {
        $request = makeOtherRequestWithPurpose();

        try{
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
                $request->purpose,
                $request->question
            );
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
            $reservation = new Reservation(
                $request->options,
                $request->plan,
                $request->number,
                $request->date,
                $request->start_time,
                $request->end_time,
                $request->purpose,
                $request->question
            );
            $this->fail('例外発生無し');
        }catch(\InvalidArgumentException $e){
            $this->assertEquals('アダルト関連の目的ではご利用頂けません',$e->getMessage());

        }
        $this->assertTrue(true);
    }
}
