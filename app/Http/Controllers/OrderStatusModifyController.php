<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Services\OrderStatusModifyService;

class OrderStatusModifyController extends Controller
{
    public function modify(Request $request)
    {
        // サービスクラスを定義
        $OrderStatusModifyService = new OrderStatusModifyService;
        try {
            // トランザクション処理を開始
            DB::beginTransaction();
            // 変更対象を取得
            $order = Order::where('order_id', $request->order_id)->first();
            // 変更可能なロール、変更可能なステータスであるか確認
            $check_flg = $OrderStatusModifyService->checkOrderStatusModify($order, $request->order_status_select);
            // 変数がfalseなら変更できないので、処理を中断する
            if($check_flg == false){
                throw new Exception("変更できません。");
            }
            // ステータス変更処理
            $OrderStatusModifyService->modifyOrderStatus($order, $request->order_status_select);
            // 発注数を引当済み在庫数からマイナスする(発注待ちに変更になる場合のみ)
            $OrderStatusModifyService->decrementAllocatedStock($request->order_id, $request->order_status_select);
            // テーブルへ反映
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            session()->flash('alert_danger', $e->getMessage());  
            return back();
        }
        return back();
    }
}
