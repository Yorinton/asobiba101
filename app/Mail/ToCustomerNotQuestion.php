<?php

namespace App\Mail;

use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\User\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ToCustomerNotQuestion extends Mailable
{
    use Queueable, SerializesModels;


    public $customer;
    public $reservation;
    public $date;
    public $start;
    public $end;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer,Reservation $reservation)
    {
        $this->customer = $customer;
        $this->reservation = $reservation;
        $dateArr = explode('-',$reservation->getDate()->getDate());
        $this->date = $dateArr[0].'年'.$dateArr[1].'月'.$dateArr[2].'日';
        $this->start = $reservation->getStartTime().'時';
        $this->end = $reservation->getEndTime() === 9 ? '翌午前'.$reservation->getEndTime().'時' : $reservation->getEndTime().'時';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.customer_r_nq');
    }
}
