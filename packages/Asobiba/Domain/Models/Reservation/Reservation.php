<?php

namespace Asobiba\Domain\Models\Reservation;


//リクエストに依存しないように変更
class Reservation
{

	/** @var Options */
	public $options;

	/** @var Plan */
	public $plan;

	/** @var Number */
	public $number;

	/** @var DateOfUse */
	public $dateOfUse;

	/** @var Question */
	public $question;

	// public function __construct(Array $options,)
	public function __construct(
		array $options,
		string $plan,
		int $number,
		DateOfUse $dateOfUse,
		string $question = null

	){

		$this->options = new Options($options);
		$this->plan = new Plan($plan,$this->options);
		$this->dateOfUse = $dateOfUse;
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
		return $this->dateOfUse->getEndTime() - $this->dateOfUse->getStartTime() >= $this->plan->getAcceptableUtilizationTime();
	}

	private function isAcceptableStartTime():bool
	{
		return $this->dateOfUse->getStartTime() >= $this->plan->getAcceptableStartTime();
	}

	private function isAcceptableEndTime():bool
	{
		return $this->dateOfUse->getEndTime() <= $this->plan->getAcceptableEndTime();
	}

	private function hasShortTimePlan():bool
	{
		return $this->plan->hasShortTimePlan();
	}

    /**
     * @return Options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return Plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @return Number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return DateOfUse
     */
    public function getDateOfUse()
    {
        return $this->dateOfUse;
    }

    /**
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

}



?>