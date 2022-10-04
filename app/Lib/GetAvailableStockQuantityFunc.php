<?php

namespace App\Lib;
use App\Models\Item;

class GetAvailableStockQuantityFunc
{
    public static function GetAvailableStockQuantityFunc($id)
    {
        // 対象の商品を取得
        $item = Item::where('item_id', $id)->first();
        // 総在庫数 - 引当済み在庫数 = 有効在庫数を算出
        $available_stock_quantity = $item->stock_quantity - $item->allocated_stock_quantity;
        return $available_stock_quantity;
    }
}