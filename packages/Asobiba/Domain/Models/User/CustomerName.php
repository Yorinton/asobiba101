<?php

namespace Asobiba\Domain\Models\User;

class CustomerName
{
	
	private $name;

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	public function getName():string
	{
		return $this->name;
	}

}
