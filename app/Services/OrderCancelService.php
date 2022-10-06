<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCancelMail;
use App\Services\MailTargetService;

class OrderCancelService
{
    public function deleteOrder($request)
    {
        // 削除対象を取得
        $order = Order::where('order_id', $request->order_id)->first();
        // 削除
        $order->delete();
        // 発注キャンセルメールを送信(自分宛て)
        Mail::send(new OrderCancelMail($order->order_id, $order->shipping_store_name, $order->delivery_date, Auth::user()->email));
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
}