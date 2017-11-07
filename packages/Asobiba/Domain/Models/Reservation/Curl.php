<?php

namespace Asobiba\Domain\Models\Reservation;

class Curl
{
    public function post_content(string $url,string $cookie, array $post)
    {
        $curl = curl_init();//cURL初期化
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_HEADER,0);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,0);
        curl_setopt($curl,CURLOPT_COOKIEJAR,$cookie);
        curl_setopt($curl,CURLOPT_POST,1);
        //送信する中身
        curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($post));
        curl_exec($curl);//cURL実行
        curl_close($curl);

    }

    public function get_content(string $url,string $cookie)
    {
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_HEADER,0);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);//返り値を文字列で表示
        curl_setopt($curl,CURLOPT_COOKIEJAR,$cookie);
        $rs = curl_exec($curl);
        curl_close($curl);
        return $rs;
    }
}



