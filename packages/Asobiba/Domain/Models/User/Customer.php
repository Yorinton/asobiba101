<?php

namespace Asobiba\Domain\Models\User;

class Customer
{
	private $name;

	private $email;

	public function __construct(CustomerName $name,CustomerEmail $email)
	{
		$this->name = $name;
		$this->email = $email;	
	}

	public function getName(): CustomerName
	{
		return $this->name;
	}

	public function getEmail(): CustomerEmail
	{
		return $this->email;
	}
}
