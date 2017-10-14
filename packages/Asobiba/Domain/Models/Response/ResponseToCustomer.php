<?php

namespace Asobiba\Domain\Models\Response;

/**
* 
*/
class ResponseToCustomer
{

	private $to;

	private $from;

	private $subject;

	private $content;

	private $reservation;
	
	public function __construct($to,$from,Reservation $reservation)
	{
		$this->to = $to;
		$this->from = $from;
		$this->reservation = $reservation;
	}

	public function sendAutoResponse()
	{
		//自動メール返信(場合わけしてテンプレートを変える)
	}


}



?>