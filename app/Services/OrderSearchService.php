<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Order;


class OrderSearchService
{
    public function procDefaultDispShipping()
    {
        // セッションを削除
        session()->forget(['order_date_from', 'order_date_to', 'order_status']);
        // 今日の日付を取得
        $today = Carbon::today()->format('Y-m-d');
        // セッションに初期表示させるための条件をセット
        session(['order_date_from' => $today]);
        session(['order_date_to' => $today]);
        return;
    }

    public function getSearchCondition($request)
    {
        // セッションに検索条件をセット
        session(['order_date_from' => $request->order_date_from]);
        session(['order_date_to' => $request->order_date_to]);
        session(['order_status' => $request->order_status]);
        return;
    }

    public function checkSearchOrderDate()
    {
        // エラー内容を格納する変数をセット
        $error_info = null;
        // 発注日の条件が正しいかチェック
        // 条件1:開始と終了の日付がどちらも指定されているか
        // 条件2:現在より91日前が指定されていないか
        if (!empty(session('order_date_from')) && !empty(session('order_date_to'))) {
            // 今日の日付を取得
            $today = Carbon::today();
            // 今日から90日を減算
            $order_date_from_available = $today->subDay(90);
            // 発注日の開始をセット
            $order_date_from = new Carbon(session('order_date_from'));
            // 発注日の開始が今日から90日前と同じか小さければNG
            if($order_date_from <= $order_date_from_available){
                $error_info = '発注日の開始は「'.$order_date_from_available->addDay(1)->format('Y-m-d').'」以降で指定して下さい。';
            }
        }else{
            $error_info = '発注日の開始と終了はどちらも指定して下さい。';
        }
        return $error_info;
    }

    public function getOrderSearch()
    {
        // 現在のURLを取得(詳細から戻るボタンに使用)
        session(['back_url_1' => url()->full()]);
        // クエリを使用する
        $query = Order::query();
        // 発注日を期間指定
        $query->whereBetween('order_date', [session('order_date_from'), session('order_date_to')]);
        // ステータス条件がある場合
        if (!empty(session('order_status'))) {
            $query->where('order_status', session('order_status'));
        }
        $orders = $query->get();
        return $orders;
    }
}