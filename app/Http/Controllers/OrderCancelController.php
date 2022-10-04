<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Services\OrderCancelService;


class OrderCancelController extends Controller
{
    public function cancel(Request $request)
    {
        // サービスクラスを定義
        $OrderCancelService = new OrderCancelService;
        try {
            // トランザクション処理を開始
            DB::beginTransaction();
            // 発注データの削除と発注キャンセルメールの送信
            $OrderCancelService->deleteOrder($request);
            // テーブルへ反映
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            session()->flash('alert_danger', '発注キャンセルができませんでした。');  
            return back();
        }
        session()->flash('alert_success', '発注をキャンセルしました。');
        return redirect()->route('order_list.index');
    }
}
