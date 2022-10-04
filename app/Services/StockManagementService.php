<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\StockHistory;
use App\Models\StockHistoryDetail;
use Carbon\Carbon;

class StockManagementService
{
    public function getTargetQuantity($data)
    {
        // 数量欄に数値がある要素だけを取得
        $quantity = array_filter($data, function($val) {
            return is_numeric($val);
        });
        return $quantity;
    }

    public function updateStockQuantityAddStockHistory($quantity)
    {
        // 変動履歴を追加
        $stock_history = StockHistory::create([
            'operation_date' => Carbon::today()->format('Y-m-d'),
            'operation_user_name' => Auth::user()->name,
            'operation_comment' => '',
        ]);
        foreach($quantity as $key => $value){
            // 計上対象を取得
            $item = Item::where('item_id', $key)->first();
            // 在庫数に計上
            $item->increment('stock_quantity', $value);
            // 在庫数がマイナスではないか確認
            if($item->stock_quantity < 0){
                return '在庫数がマイナスになる計上数が入力されています。';
            }
            // 数量がマイナスの場合、計上後の在庫数が引当済み在庫数を下回らないか確認
            if($value < 0 && $item->allocated_stock_quantity > $item->stock_quantity){
                return '引当済み在庫数を下回る計上数が入力されています。';
            }
            // 変動履歴詳細を追加
            StockHistoryDetail::create([
                'stock_history_id' => $stock_history->stock_history_id,
                'operation_category' => $value > 0 ? '入庫' : '出庫',
                'operation_item_code' => $item->item_code,
                'operation_item_category' => $item->item_category,
                'operation_item_jan_code' => $item->item_jan_code,
                'operation_item_name' => $item->item_name,
                'operation_quantity' => $value,
            ]);
        }
        return null;
    }

    public function procDefaultDispStockHistory()
    {
        // セッションを削除
        session()->forget(['operation_date_from', 'operation_date_to']);
        // 今日の日付を取得
        $today = Carbon::today()->format('Y-m-d');
        // セッションに初期表示させるための条件をセット
        session(['operation_date_from' => $today]);
        session(['operation_date_to' => $today]);
        return;
    }

    public function getSearchCondition($request)
    {
        // セッションに検索条件をセット
        session(['operation_date_from' => $request->operation_date_from]);
        session(['operation_date_to' => $request->operation_date_to]);
        return;
    }

    public function checkSearchStockHistoryDate()
    {
        // エラー内容を格納する変数をセット
        $error_info = null;
        // 発注日の条件が正しいかチェック
        // 条件1:開始と終了の日付がどちらも指定されているか
        // 条件2:現在より91日前が指定されていないか
        if (!empty(session('operation_date_from')) && !empty(session('operation_date_to'))) {
            // 今日の日付を取得
            $today = Carbon::today();
            // 今日から90日を減算
            $operation_date_from_available = $today->subDay(90);
            // 発注日の開始をセット
            $operation_date_from = new Carbon(session('operation_date_from'));
            // 発注日の開始が今日から90日前と同じか小さければNG
            if($operation_date_from <= $operation_date_from_available){
                $error_info = '計上日の開始は「'.$operation_date_from_available->addDay(1)->format('Y-m-d').'」以降で指定して下さい。';
            }
        }else{
            $error_info = '計上日の開始と終了はどちらも指定して下さい。';
        }
        return $error_info;
    }

    public function getStockHistorySearch()
    {
        // 現在のURLを取得
        session(['back_url_2' => url()->full()]);
        // クエリを使用する
        $query = StockHistory::query();
        // 発注日を期間指定
        $query->whereBetween('operation_date', [session('operation_date_from'), session('operation_date_to')]);
        $stock_histories = $query->get();
        return $stock_histories;
    }
}