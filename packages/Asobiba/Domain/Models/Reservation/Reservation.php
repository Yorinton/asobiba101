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

	/** @var Number */
    private $number;

	/** @var DateOfUse */
    private $dateOfUse;

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
		array $options,
		string $plan,
		int $number,
		string $date,
		int $start_time,
		int $end_time,
		string $question = null
	){
	    $this->id = new ReservationId();
		$this->options = new Options($options);
		$this->plan = new Plan($plan,$this->options);
		$fixed_end_time = $this->optimazeEndTimeByOptions($end_time);
		$this->dateOfUse = new DateOfUse($date,$start_time,$fixed_end_time);
		$this->isAcceptableUseTime();
		$this->number = new Number($number,$this->plan);
		$this->question = new Question($question);
		if($this->hasQuestion()) {
            $this->status = new Status('Contact');
        }else{
            $this->status = new Status('Confirmation');
        }
	}


    /**
     * @return ReservationId
     */
    public function getId(): ReservationId
    {
        return $this->id;
    }

    /**
     * get total price of this reservation
     *
     * @return int
     */
	public function totalPrice(): int
	{
		return $this->options->totalOptionPrice() + $this->plan->getBasePrice();
	}


    /**
     * get price of plan of this reservation
     *
     * @return int
     */
	public function priceOfPlan(): int
	{
		return $this->plan->getBasePrice();
	}


    /**
     * get options and price set of this reservation.
     *
     * @return array
     */
    public function optionsAndPrice(): array
    {
        return $this->options->getSelectedOptionSet();
    }

    /**
     * get plan name.
     *
     * @return string
     */
    public function planName(): string
    {
        return $this->plan->getPlan();
    }

    /**
     * get question of this reservation
     *
     * @return string
     */
    public function question(): string
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
        $method = 'to'.$status;
        $this->status = $this->status->$method();
    }


    /**
     * get DateOfUse instance
     *
     * @return DateOfUse
     */
    public function getDateOfUse(): DateOfUse
    {
        return $this->dateOfUse;
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


    /**
     * edit end_time if this reservation have midnight option or stay option
     *
     * @param int $end_time
     *
     * @return int
     */
    private function optimazeEndTimeByOptions(int $end_time): int
    {
        //check if the selected plan can have midnight or stay option
        $this->canSelectExtendTimeOption($end_time);

        if($this->options->hasMidnightOption()){
            return 24;
        }
        if($this->options->hasStayOption()){
            return 9;
        }
        return $end_time;
    }


    /**
     * check if the user can select midnight option or stay option dependent end_time
     *
     * @param $end_time
     */
    private function canSelectExtendTimeOption($end_time)
    {
        if($this->plan->haveToCheckEndtime($this->options) && $end_time < 22){
            throw new \InvalidArgumentException('深夜利用or宿泊オプションご希望の場合は、22時までのプランをご利用下さい');
        }
    }


    /**
     *
     * check if the time that user set is acceptable
     *
     * @return bool
     *
     */
	private function isAcceptableUseTime():bool
	{
		if($this->hasShortTimePlan() && $this->isCleaningTime()){
			throw new \InvalidArgumentException('2or3時間パックの場合16時~17時以外で指定して下さい');
		}
		if(!$this->isAcceptableStartTime() || !$this->isAcceptableEndTime()){
			throw new \InvalidArgumentException('開始時間又は終了時間が適切ではありません');
		}
		if(!$this->isAcceptableMaxTime()){
			throw new \InvalidArgumentException('プランで指定された利用時間をオーバーしています');
		}
		return true;
	}


    /**
     * check if the max time is acceptable
     *
     * @return bool
     */
	private function isAcceptableMaxTime():bool
	{
	    if($this->options->hasStayOption()){
            return $this->dateOfUse->getEndTime() + 24 - $this->dateOfUse->getStartTime() <= $this->plan->getAcceptableMaxTimeDependentOptions($this->options);
        }
		return $this->dateOfUse->getEndTime() - $this->dateOfUse->getStartTime() <= $this->plan->getAcceptableMaxTimeDependentOptions($this->options);
	}


    /**
     * check if the start_time is acceptable
     *
     * @return bool
     */
	private function isAcceptableStartTime():bool
	{
		return $this->dateOfUse->getStartTime() >= $this->plan->getAcceptableStartTime();
	}

    /**
     * check if the end_time is acceptable
     *
     * @return bool
     */
	private function isAcceptableEndTime():bool
	{
	    if($this->options->hasMidnightOption()){

	        return $this->dateOfUse->getEndTime() === 24;

        }
        if($this->options->hasStayOption()){

	        return $this->dateOfUse->getEndTime() === 9;

        }

        return $this->dateOfUse->getEndTime() <= $this->plan->getAcceptableEndTime();
	}


    /**
     * check if this reservation has Short time plan (2 hours or 3 hours)
     *
     * @return bool
     */
	private function hasShortTimePlan():bool
	{
		return $this->plan->hasShortTimePlan();
	}


    /**
     * check if the use time include cleaning time
     *
     * @return bool
     */
    private function isCleaningTime()
    {
        return !$this->dateOfUse->notCleaningTime();
    }


}



?>