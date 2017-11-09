<?php

namespace Asobiba\Domain\Models\Reservation;


//リクエストに依存しないように変更
class Reservation
{
    /** @var  ReservationId */
    private $id;

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
     * @param array $options
     * @param string $plan
     * @param int $number
     * @param string $date
     * @param int $start_time
     * @param int $end_time
     * @param string|null $question
     */
    public function __construct(
        ReservationId $id,
        array $options,
        string $plan,
        int $number,
        string $date,
        int $start_time,
        int $end_time,
        string $purpose,
        string $question = null
    )
    {
        $this->id = $id;
        $this->plan = new Plan($plan);
        $this->options = new Options($options, $this->plan, $end_time);
        $this->dateOfUse = new DateOfUse($date, $start_time, $end_time, $this->plan, $this->options);
        $this->capacity = new Capacity($this->plan, $this->options);
        $this->number = new Number($number, $this->capacity);
        $this->purpose = new Purpose($purpose);
        $this->question = new Question($question);
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
    public function getId(): int
    {
        return $this->id->getId();
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
     * get price of plan of this reservation
     *
     * @return int
     */
    public function getPriceOfPlan(): int
    {
        return $this->plan->getPrice();
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
    public function getCapacity(): int
    {
        return $this->capacity->getCapacity();
    }
    /**
     * get number of guests.
     *
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number->getNumber();
    }

    /**
     * get question of this reservation
     *
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question->getQuestion();
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
    public function getDate(): string
    {
        return $this->dateOfUse->getDate();
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
     * check if this reservation has question
     *
     * @return bool
     */
    public function hasQuestion(): bool
    {
        return $this->question->isQuestion();
    }


}

