<?php

namespace Tests\Feature\Reservation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use DB;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function repository()
    {
        DB::table('reservation_seqs')->insert(["nextval" => 0]);
        return new EloquentReservationRepository;
    }
    /**
     * Question test.
     *
     * @return void
     */
    public function testGetQuestion()
    {
        $request = makeCorrectRequest();

        $id = $this->repository()->nextIdentity();
        $reservation = createReservation($id,$request);

        $this->assertEquals('途中退出ありですか？',$reservation->getQuestion());
    }

    public function testCheckHasQuestion()
    {
        $request = makeCorrectRequest();

        $id = $this->repository()->nextIdentity();
        $reservation = createReservation($id,$request);

        $this->assertTrue($reservation->hasQuestion()); 
    }

    public function testCheckNotHasQuestion()
    {
        $request = makeCorrectRequest();
        unset($request->question);

        $id = $this->repository()->nextIdentity();
        $reservation = createReservation($id,$request);

        $this->assertTrue(!$reservation->hasQuestion()); 
    }

}
