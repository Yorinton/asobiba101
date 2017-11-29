<?php

namespace Asobiba\Domain\Models\Reservation;


//リクエストに依存しないように変更
use Asobiba\Domain\Models\User\Customer;
use Asobiba\Domain\Models\User\CustomerId;

class Reservation
{
    /** @var  ReservationId */
    private $id;

    private $customer;

    /** @var Options */
    private $options;

    /** @var Plan */
    private $plan;

    /** @var Capacity */
    private $capacity;

    /** @var Number */
    private $number;

    /** @var DateOfUse */
    private $dateOfUse;

    /** @var Purpose  */
    private $purpose;

    /** @var Question */
    private $question;

    /** @var Status */
    private $status;

    /**
     * Reservation constructor.
     * @param ReservationId $id
     * @param Plan $plan
     * @param Options $options
     * @param DateOfUse $dateOfUse
     * @param Number $number
     * @param Purpose $purpose
     * @param Question $question
     */
    public function __construct(
        ReservationId $id,
        Customer $customer,
        Plan $plan,
        Options $options,
        DateOfUse $dateOfUse,
        Capacity $capacity,
        Number $number,
        Purpose $purpose,
        Question $question
    )
    {
        $this->id = $id;
        $this->customer = $customer;
        $this->plan = $plan;
        $this->options = $options;
        $this->dateOfUse = $dateOfUse;
        $this->number = $number;
        $this->capacity = $capacity;
        $this->purpose = $purpose;
        $this->question = $question;
        if ($this->hasQuestion()) {
            $this->status = new Status('Contact');
        } else {
            $this->status = new Status('Confirmation');
        }
    }
    //引数の型を独自の型にする・・外でインスタンス化する

    /**
     * @return ReservationId
     */
    public function getId(): ReservationId
    {
        return $this->id;
    }


    public function getCustomer() :Customer
    {
        return $this->customer;
    }
    /**
     * get total price of this reservation
     *
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->options->getTotalPrice() + $this->plan->getPrice();
    }


    /**
     * get plan of this reservation
     *
     * @return Plan
     */
    public function getPlan(): Plan
    {
        return $this->plan;
    }

    /**
     * get options and price set of this reservation.
     *
     * @return array
     */
    public function getOptionAndPriceSet(): array
    {
        return $this->options->getOptionAndPriceSet();
    }

    /**
     * get plan name.
     *
     * @return string
     */
    public function getPlanName(): string
    {
        return $this->plan->getPlan();
    }

    /**
     * get capacity of guests.
     *
     * @return int
     */
    public function getCapacity(): Capacity
    {
        return $this->capacity;
    }
    /**
     * get number of guests.
     *
     * @return int
     */
    public function getNumber(): Number
    {
        return $this->number;
    }

    /**
     * get question of this reservation
     *
     * @return string
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return (string)$this->status;//__toStringメソッドが定義されているため
    }


    /**
     * change status
     * @param string $status
     */
    public function changeStatus(string $status)
    {
        $method = 'to' . $status;
        $this->status = $this->status->$method();
    }

    /**
     * get Date
     *
     * @return string
     */
    public function getDate(): dateOfUse
    {
//        return $this->dateOfUse->getDate();
        return $this->dateOfUse;
    }

    /**
     * get StartTime
     *
     * @return int
     */
    public function getStartTime(): int
    {
        return $this->dateOfUse->getStartTime();
    }

    /**
     * get EndTime
     *
     * @return int
     */
    public function getEndTime(): int
    {
        return $this->dateOfUse->getEndTime();
    }

    /**
     * @return Purpose
     */
    public function getPurpose(): Purpose
    {
        return $this->purpose;
    }

    /**
     * check if this reservation has question
     *
     * @return bool
     */
    public function hasQuestion(): bool
    {
        return $this->question->isQuestion();
    }


}

