<?php

namespace Asobiba\Domain\Models\Reservation;

class PriceOfOptions
{

    private const priceOptionsSet = [
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

    public static function getTotalPrice(array $options): int
    {
        $totalPrice = 0;
        foreach ($options as $option) {
            $totalPrice += self::priceOptionsSet[$option];
        }
        return (int)$totalPrice;
    }

    public static function getOptionAndPriceSet(array $options): array
    {
        return array_intersect_key(self::priceOptionsSet, array_flip($options));
    }

}
