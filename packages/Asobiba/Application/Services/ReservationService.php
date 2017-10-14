<?php

namespace Asobiba\Application\Service;

use Illuminate\Http\Request;


class ReservationService
{
	

	private $request;

	public function __construct(Request $request)//ReservationRequestに変更
	{
		$this->request = $request;
	}

	public function reserve()
	{
		//予約内容保存

		//質問内容の有無をチェック

		//メール
	}


	



}


?>