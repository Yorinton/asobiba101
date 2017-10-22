<?php

namespace Asobiba\Domain\Models\Reservation;


class Options
{
	
	private $options;

	private $totalPrice;

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

	//Priceクラスに分割？
	public function totalOptionPrice(): int
	{
		foreach($this->options as $option){
			$this->totalPrice += $this->optionSet[$option];
		}
		return (int)$this->totalPrice;
	}

	public function getSelectedOptionSet(): array
    {
        return array_filter($this->optionSet,function($k){
            return in_array($k,$this->options,true);
        },ARRAY_FILTER_USE_KEY);
    }

	public function hasLargeGroupOption(): bool
	{
		return in_array('大人数レイアウト', $this->options, true);
	}

	public function hasStayOption(): bool
	{
		$stay = in_array('宿泊(1〜3名様)', $this->options, true);
		$stay2 = in_array('宿泊(4〜5名様)', $this->options, true);
		return $stay || $stay2;
	}

	public function hasMidnightOption(): bool
	{
		return in_array('深夜利用', $this->options, true);		
	}

}





?>