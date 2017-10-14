<?php

namespace Asobiba\Domain\Models\Reservation;


class Options
{
	
	private $options;

	private $optionSet = [
		'ゴミ処理' => 1500,
		'コタツ(布団付き)' => 3000,
		'電気グリル鍋' => 2000,
		'大きな鍋' => 1000,
		'カセットコンロ' => 1500,
		'たこ焼き器' => 1500,
		'大人数レイアウト' => 4000,
		'寿司桶' => 500,
		'プロジェクター' => 1500,
		'深夜利用' => 5000,
		'宿泊(1〜3名様)' => 6000,
		'宿泊(4〜5名様)' => 8000,
		'コテ' => 1000,
		'撮影用ミニライト' => 1000,
		'姿見鏡' => 1000,
		'サプライズ装飾' => 4000,
		'炊飯器' => 1500,
		'トースター' => 1500,
		'ミキサー' => 1000,
		'付けない' => 0,
	];

	public function __construct(array $options)
	{
		$this->options = $options;
	}

	public function totalOptionPrice(): int
	{
		foreach($this->options as $option){
			$totalPrice += $this->optionSet[$option];
		}
		return (int)$totalPrice;
	}

	public function hasLargeGroupOption(): boolean
	{
		return in_array('大人数', $this->options, true);
	}

	public function hasStayOption(): boolean
	{
		return in_array('宿泊', $this->options, true);
	}

	public function hasMidnightOption(): boolean
	{
		return in_array('深夜利用', $this->options, true);		
	}

}





?>