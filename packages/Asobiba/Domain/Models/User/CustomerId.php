<?php

namespace Asobiba\Domain\Models\User;

class CustomerId
{
	
	private $id;

	public function __construct(int $id)
	{
	    if($id <= 0){
	        throw new \InvalidArgumentException('CustomerId is not allowed negative integer');
        }
		$this->id = $id;
	}

	public function getId():int
	{
		return $this->id;
	}

}
