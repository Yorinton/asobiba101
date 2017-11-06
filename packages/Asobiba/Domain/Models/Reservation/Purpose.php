<?php

namespace Asobiba\Domain\Models\Reservation;

class Purpose
{
    private $purpose;

    public function __construct(string $purpose)
    {
        if($this->isAdultPurpose($purpose)){
            throw new \InvalidArgumentException('アダルト関連の目的ではご利用頂けません');
        }
        $this->purpose = $purpose;
    }

    private function isAdultPurpose(string $purpose)
    {
        $ngWords = ['アダルト','エロ','AV'];
        foreach($ngWords as $ngWord) {
            if(strpos($purpose, $ngWord) !== false){//strposの比較の場合は比較演算子 === を使う
                return true;
            }
        }
        return false;
    }
}