<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetail;
use App\Models\Item;

class OrderStatusModifyService
{
    public function checkOrderStatusModify($order, $order_status_select)
    {
        // チェックに使用する変数を定義
        $check_flg = false;
        // システム管理者ロール（発注ロール・倉庫ロールどちらの条件も処理可能）
        if(Auth::user()->role_id == 1){
            $check_flg = $this->checkOrderStatusModify_OrderRole($order, $order_status_select, $check_flg);
            $check_flg = $this->checkOrderStatusModify_WarehouseRole($order, $order_status_select, $check_flg);
        }
        // 発注ロール
        if(Auth::user()->role_id == 11){
            $check_flg = $this->checkOrderStatusModify_OrderRole($order, $order_status_select, $check_flg);
        }
        // 倉庫ロール
        if(Auth::user()->role_id == 21){
            $check_flg = $this->checkOrderStatusModify_WarehouseRole($order, $order_status_select, $check_flg);
        }
        return $check_flg;
    }

    public function checkOrderStatusModify_OrderRole($order, $order_status_select, $check_flg)
    {
        // 発注ロールで変更可能な条件
        if($order->order_status == '出荷待ち' && $order_status_select == '発注待ち'){
            $check_flg = true;
        }
        return $check_flg;
    }

    public function checkOrderStatusModify_WarehouseRole($order, $order_status_select, $check_flg)
    {
        // 倉庫ロールで変更可能な条件
        if($order->order_status == '出荷待ち' && $order_status_select == '出荷作業中'){
            $check_flg = true;
        }
        if($order->order_status == '出荷作業中' && $order_status_select == '出荷待ち'){
            $check_flg = true;
        }
        return $check_flg;
    }

    public function modifyOrderStatus($order, $order_status_select)
    {
        // ステータスを変更
        $order->update([
            'order_status' => $order_status_select,
        ]);
        return;
    }

    public function decrementAllocatedStock($order_id, $order_status_select)
    {
        // 発注待ちに変わる場合のみ実行
        if($order_status_select == '発注待ち'){
            // 削除対象の商品情報を取得
            $order_details = OrderDetail::where('order_id', $order_id)->get();
            // 引当済み在庫数を発注数分だけマイナスする
            foreach($order_details as $order_detail){
                Item::where('item_id', $order_detail->order_item_id)->decrement('allocated_stock_quantity', $order_detail->order_quantity);
            }
        }
        return;
    }
}