<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\StockHistory;
use App\Models\StockHistoryDetail;
use App\Services\StockManagementService;
use Rap2hpoutre\FastExcel\FastExcel;

class StockHistoryListController extends Controller
{
    public function index()
    {
        // 現在のURLを取得
        session(['back_url_2' => url()->full()]);
        // サービスクラスを定義
        $StockManagementService = new StockManagementService;
        // 初期表示させるための処理を実施
        $StockManagementService->procDefaultDispStockHistory();
        // 検索処理
        $stock_histories = $StockManagementService->getStockHistorySearch();
        return view('stock_history_list.index')->with([
            'stock_histories' => $stock_histories,
        ]);
    }

    public function detail(Request $request)
    {
        $stock_history = StockHistory::where('stock_history_id', $request->stock_history_id)->first();
        $stock_history_details = StockHistoryDetail::where('stock_history_id', $request->stock_history_id)->get();
        return view('stock_history_list.detail')->with([
            'stock_history' => $stock_history,
            'stock_history_details' => $stock_history_details,
        ]);
    }

    public function search(Request $request)
    {
        // サービスクラスを定義
        $StockManagementService = new StockManagementService;
        // 検索条件を取得
        $StockManagementService->getSearchCondition($request);
        // 発注日の指定が正しいかチェック
        $error_info = $StockManagementService->checkSearchStockHistoryDate();
        // 条件エラーがあれば処理を中断
        if(!is_null($error_info)){
            session()->flash('alert_danger', $error_info);  
            return back();
        }
        // 検索処理
        $stock_histories = $StockManagementService->getStockHistorySearch();
        return view('stock_history_list.index')->with([
            'stock_histories' => $stock_histories,
        ]);
    }

    public function download()
    {
        // 出力する情報を取得
        $export = DB::table('stock_histories')
            ->whereBetween('operation_date', [session('operation_date_from'), session('operation_date_to')])
            ->select(
                'stock_histories.stock_history_id as 計上ID',
                'stock_histories.operation_date as 計上日',
                'stock_histories.operation_user_name as 計上者',
                'stock_history_details.operation_category as 計上区分',
                'stock_history_details.operation_item_code as 商品コード',
                'stock_history_details.operation_item_jan_code as 商品JANコード',
                'stock_history_details.operation_quantity as 計上数',
                'stock_histories.operation_comment as コメント',
            )
            ->join('stock_history_details', 'stock_histories.stock_history_id', '=', 'stock_history_details.stock_history_id')
            ->get();
        // 出力できるデータがなければ処理を中断
        if($export->count() == 0){
            session()->flash('alert_danger', '指定した条件の計上履歴がない為、データをダウンロードできません。');
            return back();
        }
        // CSVで出力
        return (new FastExcel($export))->download('【petsrock】在庫計上履歴データ_' . new Carbon('now') . '.csv');
    }
}
