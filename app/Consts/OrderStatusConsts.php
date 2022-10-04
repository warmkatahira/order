<?php

namespace App\Consts;

class OrderStatusConsts
{
    public const ORDER_STATUS_01 = '発注待ち';
    public const ORDER_STATUS_02 = '出荷待ち';
    public const ORDER_STATUS_03 = '出荷作業中';
    public const ORDER_STATUS_04 = '出荷済み';
    // 全てのステータス
    public const ORDER_STATUS_LIST_ALL = [
        self::ORDER_STATUS_01 => self::ORDER_STATUS_01,
        self::ORDER_STATUS_02 => self::ORDER_STATUS_02,
        self::ORDER_STATUS_03 => self::ORDER_STATUS_03,
        self::ORDER_STATUS_04 => self::ORDER_STATUS_04,
    ];
    // 発注詳細で使用する変更先のステータスリスト
    public const ORDER_STATUS_LIST_MODIFY_TARGET = [
        self::ORDER_STATUS_01 => self::ORDER_STATUS_01,
        self::ORDER_STATUS_02 => self::ORDER_STATUS_02,
        self::ORDER_STATUS_03 => self::ORDER_STATUS_03,
    ];
}