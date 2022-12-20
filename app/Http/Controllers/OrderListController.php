<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Services\OrderSearchService;
use App\Services\OrderListService;

class OrderListController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $OrderSearchService = new OrderSearchService;
        // 初期表示させるための処理を実施
        $OrderSearchService->procDefaultDispShipping();
        // 検索処理
        $orders = $OrderSearchService->getOrderSearch();
        return view('order_list.index')->with([
            'orders' => $orders,
        ]);
    }

    public function search(Request $request)
    {
        // サービスクラスを定義
        $OrderSearchService = new OrderSearchService;
        // 検索条件を取得
        $OrderSearchService->getSearchCondition($request);
        // 発注日の指定が正しいかチェック
        $error_info = $OrderSearchService->checkSearchOrderDate();
        // 条件エラーがあれば処理を中断
        if(!is_null($error_info)){
            session()->flash('alert_danger', $error_info);  
            return back();
        }
        // 検索処理
        $orders = $OrderSearchService->getOrderSearch();
        return view('order_list.index')->with([
            'orders' => $orders,
        ]);
    }

    public function detail(Request $request)
    {
        // 現在のURLを取得
        session(['back_url_2' => url()->full()]);
        // 修正対象の発注情報を取得
        $order = Order::where('order_id', $request->order_id)->first();
        $order_details = OrderDetail::where('order_id', $request->order_id)->get();
        // サービスクラスを定義
        $OrderListService = new OrderListService;
        // セッションに商品情報を格納
        $OrderListService->inputOrderDetailSession($request->order_id);
        return view('order_list.detail')->with([
            'order' => $order,
            'order_details' => $order_details,
        ]);
    }
}
