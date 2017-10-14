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
	private $reservation;

	/** @var Options */
	private $options;

	/** @var Plan */
	private $plan;

	/** @var Number */
	private $number;

	/** @var Date */
	private $date;

	/** @var Question */
	private $question;

	public function __construct(Request $request)
	{
		$this->reservation = $request;
		$this->options = new Options($request->options);
		$this->plan = new Plan($request->plan,$options);
		$this->number = new Number($request->number,$plan);
	}

}



?>