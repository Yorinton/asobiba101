<?php

namespace Tests\Feature\Reservation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\Reservation\DateOfUse;


class QuestionTest extends TestCase
{

    /**
     * Question test.
     *
     * @return void
     */
    public function testGetQuestion()
    {
        $request = makeCorrectRequest();

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->question
        ); 

        $this->assertEquals('途中退出ありですか？',$reservation->getQuestion());
    }

    public function testCheckHasQuestion()
    {
        $request = makeCorrectRequest();

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->question
        ); 

        $this->assertTrue($reservation->hasQuestion()); 
    }

    public function testCheckNotHasQuestion()
    {
        $request = makeCorrectRequest();
        unset($request->question);

        $reservation = new Reservation(
            $request->options,
            $request->plan,
            $request->number,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->question
        ); 

        $this->assertTrue(!$reservation->hasQuestion()); 
    }

}
