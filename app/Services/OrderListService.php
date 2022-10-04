<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderListService
{
    public function checkOrderModifyAvailable($order_id)
    {
        // ステータスが発注待ち又は出荷待ちであるかチェック(「待ち」という文字を含んでいるかで判断)
        $order = Order::where('order_id', $order_id)
                    ->where('order_status', 'LIKE', '%待ち%')
                    ->first();
        return $order;
    }

    public function modifyOrderStatus($order_id, $status)
    {
        // ステータスを発注待ちに変更
        Order::where('order_id', $order_id)->update([
            'order_status' => $status,
        ]);
        return;
    }

    public function inputOrderDetailSession($order_id)
    {
        // セッションを削除
        session()->forget('order_modify_info');
        // 発注詳細を取得
        $order_details = OrderDetail::where('order_id', $order_id)->get();
        // 変数に空をセット
        $order_modify_info = array();
        // 変数に商品情報をセット(商品IDをキーにしてセット)
        foreach($order_details as $order_detail){
            $order_modify_info[$order_detail->order_item_id] = [
                'item_id' => $order_detail->order_item_id,
                'item_code' => $order_detail->order_item_code,
                'item_jan_code' => $order_detail->order_item_jan_code,
                'item_name' => $order_detail->order_item_name,
                'quantity' => $order_detail->order_quantity
            ];
        }
        // セッションに変数をセット
        session(['order_modify_info' => $order_modify_info]);
        return;
    }
}