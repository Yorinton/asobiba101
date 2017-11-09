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
    public function testAddReservationToDB()
    {

        $request = makeCorrectRequest();


        $customer = new Customer($request->name, $request->email);
        $id = $this->repository()->nextIdentity();
        $reservation = createReservation($id, $request);
        $this->repository()->add($customer, $reservation);//DBに保存

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
