<?php

namespace Asobiba\Domain\Models\Reservation;

use Illuminate\Http\Request;
use Asobiba\Domain\Models\Reservation\Options;
use Asobiba\Domain\Models\Reservation\Plan;
use Asobiba\Domain\Models\Reservation\Number;
use Asobiba\Domain\Models\Reservation\Question;
use Asobiba\Domain\Models\Reservation\Date;


class Reservation
{
	
	/** @var Request */
	public $reservation;

	/** @var Options */
	public $options;

	/** @var Plan */
	public $plan;

	/** @var Number */
	public $number;

	/** @var Date */
	public $date;

	/** @var Question */
	public $question;

	public function __construct(Request $request)
	{
		$this->reservation = $request;
		$this->options = new Options($request->options);
		$this->plan = new Plan($request->plan,$this->options);
		$this->number = new Number($request->number,$this->plan);
		$this->question = new Question($request->question);
	}

	public function totalPrice(): int
	{
		return $this->options->totalOptionPrice() + $this->plan->getBasePrice();
	}

	public function Capacity(): int
	{
		return $this->plan->getCapacity();
	}

	public function Question(): String
	{
		return $this->question->getQuestion();
	}

	public function hasQuestion(): bool
	{
		return $this->question->isQuestion();
	}

}



?>