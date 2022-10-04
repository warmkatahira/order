<?php

namespace App\Consts;

class DeliveryTimeConsts
{
    public const TIME_NONE = '00';
    public const TIME_12_14 = '1214';
    public const TIME_14_16 = '1416';
    public const TIME_16_18 = '1618';
    public const TIME_18_20 = '1820';
    public const TIME_19_21 = '1921';
    public const TIME_LIST = [
        self::TIME_NONE => '指定なし',
        self::TIME_12_14 => '12-14時',
        self::TIME_14_16 => '14-16時',
        self::TIME_16_18 => '16-18時',
        self::TIME_18_20 => '18-20時',
        self::TIME_19_21 => '19-21時',
    ];
}