<?php

namespace App\Consts;

class ShippingMethodConsts
{
    public const SAGAWA = '佐川急便';
    public const YAMATO = 'ヤマト運輸';
    public const YUBIN = '日本郵便';
    public const SHIPPING_METHOD_LIST = [
        self::SAGAWA => self::SAGAWA,
        self::YAMATO => self::YAMATO,
        self::YUBIN => self::YUBIN,
    ];
}