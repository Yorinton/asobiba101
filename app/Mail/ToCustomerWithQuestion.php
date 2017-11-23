<?php

namespace App\Mail;

use Asobiba\Domain\Models\Reservation\Reservation;
use Asobiba\Domain\Models\User\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ToCustomerWithQuestion extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $reservation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer,Reservation $reservation)
    {
        $this->customer = $customer;
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.customer');
    }
}
