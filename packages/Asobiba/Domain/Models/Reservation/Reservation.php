<?php

namespace Asobiba\Domain\Models\Reservation;


//リクエストに依存しないように変更
class Reservation
{

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

	// public function __construct(Array $options,)
	public function __construct(
		array $options,
		string $plan,
		int $number,
		string $date,
		int $start_time,
		int $end_time,
		string $question = null
	){
		$this->options = new Options($options);
		$this->plan = new Plan($plan,$this->options);

		if($this->plan->haveToCheckEndtime($this->options) && $end_time < 22){
		    throw new \InvalidArgumentException('深夜利用or宿泊オプションご希望の場合は、22時までのプランをご利用下さい');
        }

		$fixed_end_time = $this->editEndTimeDependentOption($end_time);
		$this->dateOfUse = new DateOfUse($date,$start_time,$fixed_end_time);
		$this->isAcceptableUseTime();
		$this->number = new Number($number,$this->plan);
		$this->question = new Question($question);
	}


	public function totalPrice(): int
	{
		return $this->options->totalOptionPrice() + $this->plan->getBasePrice();
	}

	public function Capacity(): int
	{
		return $this->plan->getCapacity();
	}

	private function editEndTimeDependentOption(int $end_time): int
    {
        if($this->options->hasMidnightOption()){
            return 24;
        }
        if($this->options->hasStayOption()){
            return 9;
        }
        return $end_time;
    }

	public function Question(): string
	{
		return $this->question->getQuestion();
	}

	public function hasQuestion(): bool
	{
		return $this->question->isQuestion();
	}



	public function isAcceptableUseTime():bool
	{
		if($this->hasShortTimePlan() && !$this->dateOfUse->notCleaningTime()){
			throw new \InvalidArgumentException('2or3時間パックの場合16時~17時以外で指定して下さい');
		}
		if(!$this->isAcceptableStartTime() || !$this->isAcceptableEndTime()){
			throw new \InvalidArgumentException('開始時間又は終了時間が適切ではありません');
		}
		if(!$this->isAcceptableUtilizationTime()){
			throw new \InvalidArgumentException('プランで指定された利用時間をオーバーしています');
		}
		return true;
	}

	private function isAcceptableUtilizationTime():bool
	{
	    if($this->options->hasStayOption()){
            return $this->dateOfUse->getEndTime() + 24 - $this->dateOfUse->getStartTime() <= $this->plan->getAcceptableUtilizationTimeDependentOptions($this->options);
        }
		return $this->dateOfUse->getEndTime() - $this->dateOfUse->getStartTime() <= $this->plan->getAcceptableUtilizationTimeDependentOptions($this->options);
	}

	private function isAcceptableStartTime():bool
	{
		return $this->dateOfUse->getStartTime() >= $this->plan->getAcceptableStartTime();
	}


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


	private function hasShortTimePlan():bool
	{
		return $this->plan->hasShortTimePlan();
	}

    /**
     * @return Options
     */
    public function getOptions(): Options
    {
        return $this->options;
    }

    /**
     * @return Plan
     */
    public function getPlan(): Plan
    {
        return $this->plan;
    }

    /**
     * @return Number
     */
    public function getNumber(): Number
    {
        return $this->number;
    }

    /**
     * @return DateOfUse
     */
    public function getDateOfUse(): DateOfUse
    {
        return $this->dateOfUse;
    }

    /**
     * @return Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

}



?>