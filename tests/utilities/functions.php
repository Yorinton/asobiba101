<?php

function makeCorrectRequest()
{
	$request = new Illuminate\Http\Request();
	$request->name = 'テストユーザー';
	$request->email = 'sansan106700@gmail.com';
	$request->plan = '【非商用】基本プラン(平日)';
	$request->options = ['ゴミ処理','カセットコンロ','宿泊(1〜3名様)'];
	$request->date = '2017-11-26';
	$request->start_time = '11';
	$request->end_time = '22';
	$request->number = '10';
	$request->question = '途中退出ありですか？';

	return $request;
}


?>