<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Services\StockManagementService;
use App\Services\ItemSearchService;

class StockManagementController extends Controller
{
    public function index()
    {
        // 現在のURLを取得
        session(['back_url_1' => url()->full()]);
        // サービスクラスを定義
        $ItemSearchService = new ItemSearchService;
        // 検索条件が格納されているセッションを削除
        $ItemSearchService->deleteSearchSession();
        // 検索処理
        $items = $ItemSearchService->getItemSearch();
        return view('stock_mgt.index')->with([
            'items' => $items,
        ]);
    }

    public function search(Request $request)
    {
        // 現在のURLを取得
        session(['back_url_1' => url()->full()]);
        // サービスクラスを定義
        $ItemSearchService = new ItemSearchService;
        // 検索条件を取得
        $ItemSearchService->getSearchCondition($request);
        // 検索処理
        $items = $ItemSearchService->getItemSearch();
        return view('stock_mgt.index')->with([
            'items' => $items,
        ]);
    }

    public function confirm(Request $request)
    {
        // サービスクラスを定義
        $StockManagementService = new StockManagementService;
        try {
            // トランザクション処理を開始
            DB::beginTransaction();
            // 在庫計上対象を取得
            $quantity = $StockManagementService->getTargetQuantity($request->quantity);
            // 変数が空であれば計上できる対象がないので、処理を中断する
            if(empty($quantity) == true){
                throw new Exception('在庫計上できる対象がありませんでした。');
            }
            // 在庫計上と変動履歴を追加
            $msg = $StockManagementService->updateStockQuantityAddStockHistory($quantity);
            // msgがnullなら問題なし、それ以外は計上数に異常がある為、処理を中断
            if(empty($msg) == false){
                throw new Exception($msg);
            }
            // テーブルへ反映
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            session()->flash('alert_danger', $e->getMessage());
            return back();
        }
        session()->flash('alert_success', '在庫計上が完了しました。');
        return back();
    }
}
