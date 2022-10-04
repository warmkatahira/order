<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderModifyService
{
    public function checkOrderModifyAvailable($order_id)
    {
        // ステータスが発注待ちであるかチェック
        $order = Order::where('order_id', $order_id)
                    ->where('order_status', '発注待ち')
                    ->first();
        return $order;
    }

    public function modifyOrder($request, $nowDate)
    {
        // 内容を更新
        Order::where('order_id', $request->order_id)->update([
            'order_user_id' => Auth::user()->id,
            'order_user_name' => Auth::user()->name,
            'store_pic' => $request->store_pic,
            'order_date' => $nowDate->format('Ymd'),
            'order_status' => '出荷待ち',
            'delivery_date' => $request->delivery_date,
            'delivery_time' => $request->delivery_time,
            'shipping_store_name' => $request->shipping_store_name,
            'shipping_store_zip_code' => $request->shipping_store_zip_code,
            'shipping_store_address_1' => $request->shipping_store_address_1,
            'shipping_store_address_2' => $request->shipping_store_address_2,
            'shipping_store_tel_number' => $request->shipping_store_tel_number,
        ]);
        return;
    }

    public function modifyOrderDetail($order_id)
    {
        // 修正前の商品情報を削除
        OrderDetail::where('order_id', $order_id)->delete();
        // 修正後の商品情報を追加
        foreach(session('order_modify_info') as $order_info){
            // レコードを追加
            OrderDetail::create([
                'order_id' => $order_id,
                'order_item_id' => $order_info['item_id'],
                'order_item_code' => $order_info['item_code'],
                'order_item_jan_code' => $order_info['item_jan_code'],
                'order_item_name' => $order_info['item_name'],
                'order_quantity' => $order_info['quantity'],
            ]);
        }
        return;
    }
}