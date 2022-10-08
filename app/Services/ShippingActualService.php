<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Item;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShippingActualMail;
use App\Services\MailTargetService;

class ShippingActualService
{
    public function updateShippingActual()
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // 出荷実績のレコード分だけループ処理
        foreach(session('imports') as $import){
            // 発注IDをキーにレコードを検索
            $order = Order::where('order_id', $import['order_id'])
                    ->where('order_status', '出荷作業中')
                    ->first();
            // レコードが存在しなかったら処理を中断
            if($order === null){
                return '発注ID='.$import['order_id'].'が存在しないか、出荷作業中のステータスではない為、出荷実績が反映できませんでした。';
            }
            // 出荷実績を反映
            $order->update([
                'shipping_date' => $nowDate->format('Ymd'),
                'tracking_number' => $import['tracking_number'],
                'shipping_method' => $import['shipping_method'],
                'warehouse_pic_user_id' => Auth::user()->id,
                'warehouse_pic_user_name' => Auth::user()->name,
                'order_status' => '出荷済み',
            ]);
        }
        return null;
    }

    public function updateStockQuantity()
    {
        // 出荷実績のレコード分だけループ処理
        foreach(session('imports') as $import){
            // 発注IDをキーにレコードを検索
            $order_details = OrderDetail::where('order_id', $import['order_id'])->get();
            // 商品分だけループ処理
            foreach($order_details as $order_detail){
                // 引当済み在庫数から発注数分をマイナスする
                Item::where('item_id', $order_detail->order_item_id)->decrement('allocated_stock_quantity', $order_detail->order_quantity);
                // 総在庫数から発注数分をマイナスする
                Item::where('item_id', $order_detail->order_item_id)->decrement('stock_quantity', $order_detail->order_quantity);
            }
        }
        return;
    }

    public function sendShippingActualMail()
    {
        // メールに使用する情報を取得
        $order_info = array();
        foreach(session('imports') as $import){
            // 発注IDをキーにレコードを検索
            $order = Order::where('order_id', $import['order_id'])->first();
            // 変数に情報をセット
            $order_info[$order->order_id] = [
                'order_id' => $order->order_id,
                'shipping_store_name' => $order->shipping_store_name,
                'delivery_date' => $order->delivery_date,
                'shipping_date' => $order->shipping_date,
                'tracking_number' => $order->tracking_number,
                'shipping_method' => $order->shipping_method,
            ];
        }
        // サービスクラスを定義
        $MailTargetService = new MailTargetService;
        // メールを送る対象を取得
        $users = $MailTargetService->getMailTargetAll();
        foreach($users as $user){
            // 出荷メールを送信
            Mail::send(new ShippingActualMail($order_info, $user->email));
        }
        return;
    }
}