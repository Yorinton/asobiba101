<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Asobiba\Infrastructure\Repositories\EloquentReservationRepository;
use Asobiba\Domain\Models\Reservation\ReservationId;
use DB;

class ReservationIdTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateReservationId()
    {
        DB::table('reservation_seqs')->insert(["nextval" => 0]);

        $repository = new EloquentReservationRepository;
        $reservationId = $repository->nextIdentity();
        $this->assertInstanceOf(ReservationId::class,$reservationId);
        $this->assertEquals(1,$reservationId->getId());

    }
}
