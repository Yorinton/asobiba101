<?php

function makeCorrectRequest()
{
	$request = new Illuminate\Http\Request();
	$request->name = 'テストユーザー';
	$request->email = 'sansan106700@gmail.com';
	$request->plan = '【非商用】基本プラン(平日)';
	$request->options = ['ゴミ処理','カセットコンロ','宿泊(1〜3名様)'];
	$request->date = '2017-11-26';
	$request->start_time = 11;
	$request->end_time = 22;
	$request->number = 10;
    $request->purpose = '再現VTR';
	$request->question = '途中退出ありですか？';

	return $request;
}

function makeOtherRequest()
{
    $request = new Illuminate\Http\Request();
    $request->name = 'テストユーザー2';
    $request->email = 'te106700@gmail.com';
    $request->plan = '【商用】3時間パック';
    $request->options = ['ゴミ処理','宿泊(1〜3名様)','電気グリル鍋'];
    $request->date = '2018-03-12';
    $request->start_time = 19;
    $request->end_time = 22;
    $request->number = 10;
    $request->purpose = '再現VTR';
    $request->question = 'いくらになりますか？';

    return $request;
}

function makeOtherRequestWithPurpose()
{
    $request = new Illuminate\Http\Request();
    $request->name = 'テストユーザー2';
    $request->email = 'te106700@gmail.com';
    $request->plan = '【商用】3時間パック';
    $request->options = ['ゴミ処理','宿泊(1〜3名様)','電気グリル鍋'];
    $request->date = '2018-03-12';
    $request->start_time = 19;
    $request->end_time = 22;
    $request->number = 10;
    $request->purpose = '再現VTR';
    $request->question = 'いくらになりますか？';

    return $request;
}

function createReservation($id,$request)
{
    return new Asobiba\Domain\Models\Reservation\Reservation(
        $id,
        $request->options,
        $request->plan,
        $request->number,
        $request->date,
        $request->start_time,
        $request->end_time,
        $request->purpose,
        $request->question
    );
}

?>