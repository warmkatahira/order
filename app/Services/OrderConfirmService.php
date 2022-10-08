<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmMail;
use App\Services\MailTargetService;

class OrderConfirmService
{
    public function getOrderInfo($operation_type)
    {
        // 現在のカートセッション情報を変数にセット
        if($operation_type == "new"){
            $order_info = session('order_info');
        }
        if($operation_type == "modify"){
            $order_info = session('order_modify_info');
        }
        return $order_info;
    }

    public function checkAllocateStock($order_infos)
    {
        // 在庫引当NG情報を格納する変数をセット
        $allocate_stock_ng_info = array();
        // 発注商品をループして在庫が引き当てられるか確認
        foreach($order_infos as $order_info){
            // 対象の商品を取得
            $item = Item::where('item_id', $order_info['item_id'])->first();
            // 有効在庫数が発注数より小さければ情報を変数に格納
            if(($item->stock_quantity - $item->allocated_stock_quantity) < $order_info['quantity']){
                $allocate_stock_ng_info[$order_info['item_id']] = [
                    'item_name' => $item->item_name,
                    'quantity' => $order_info['quantity'],
                    'available_stock_quantity' => $item->stock_quantity - $item->allocated_stock_quantity
                ];
            }
        }
        return $allocate_stock_ng_info;
    }

    public function updateAllocatedStockQuantity($order_infos)
    {
        // 発注商品をループして引当済み在庫数に発注数を計上する
        foreach($order_infos as $order_info){
            Item::where('item_id', $order_info['item_id'])->increment('allocated_stock_quantity', $order_info['quantity']);
        }
        return;
    }

    public function addOrder($request, $nowDate)
    {
        // レコードを追加
        $order = Order::create([
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
            'shipping_method' => $request->shipping_method,
        ]);
        return $order;
    }

    public function addOrderDetail($order_id, $order_infos)
    {
        foreach($order_infos as $order_info){
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

    public function sendOrderConfirmMail($order_id, $request)
    {
        // 発注メールを送信
        Mail::send(new OrderConfirmMail($order_id, $request->shipping_store_name, $request->delivery_date, Auth::user()->email));
        // サービスクラスを定義
        $MailTargetService = new MailTargetService;
        // メールを送る対象を取得
        $users = $MailTargetService->getMailTargetWarehouse(Auth::user()->id);
        foreach($users as $user){
            // 発注キャンセルメールを送信
            Mail::send(new OrderCancelMail($order->order_id, $order->shipping_store_name, $order->delivery_date, $user->email));
        }
        return;
    }
    
    public function deleteSession($operation_type)
    {
        // セッションを削除
        if($operation_type == "new"){
            session()->forget('order_info');
        }
        if($operation_type == "modify"){
            session()->forget('order_modify_info');
        }
        return;
    }
}