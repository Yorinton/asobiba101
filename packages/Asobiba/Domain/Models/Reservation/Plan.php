<?php

namespace Asobiba\Domain\Models\Reservation;

class Plan
{
	private $plan;

	private $price;

	private $capacity;

	private $priceSet = [
		'【非商用】基本プラン(平日)' => 19500,
		'【非商用】基本プラン(休日)' => 20500,
		'【非商用】お昼5時間パック' => 17000,
		'【非商用】夜5時間パック' => 18000,
		'【商用】基本１日プラン' => 28500,		
		'【商用】お昼5時間パック' => 24000,
		'【商用】夜5時間パック' => 25000,
		'【商用】3時間パック' => 20000,
		'【商用】2時間パック' => 17000,
	];

	public function __construct(String $plan,Options $options)
	{
		$this->plan = $plan;
		$this->price = $this->basePrice($plan);
		$this->capacity = $this->getCapacity($plan,$options)
	}

	
	private function basePrice(String $plan): int
	{
		return (int)$this->priceSet[$plan];
	}


	private function getCapacity(String $plan,Options $options): int
	{
		$planCategoryCheck = strpos($plan,'非');
		if(!$planCategoryCheck || $options->hasLargeGroupOption()){
			return 15;
		}
		return 11;
	}

}


?>