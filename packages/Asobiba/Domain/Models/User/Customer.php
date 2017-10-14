<?php

namespace Asobiba\Domain\Models\User;

/**
* 
*/
class Customer
{
	
	private $name;

	private $email;

	public function __construct($name,$email)
	{
		$this->name = $name;
		$this->email = $email;	
	}

	public function getCustomerName()
	{
		return $this->name;
	}

	public function getCustomerEmail()
	{
		return $this->email;
	}
}

?>