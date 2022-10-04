<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Services\ItemSearchService;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

class StockController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $ItemSearchService = new ItemSearchService;
        // 検索条件が格納されているセッションを削除
        $ItemSearchService->deleteSearchSession();
        // 検索処理
        $items = $ItemSearchService->getItemSearch();
        return view('stock.index')->with([
            'items' => $items,
        ]);
    }

    public function search(Request $request)
    {
        // サービスクラスを定義
        $ItemSearchService = new ItemSearchService;
        // 検索条件を取得
        $ItemSearchService->getSearchCondition($request);
        // 検索処理
        $items = $ItemSearchService->getItemSearch();
        return view('stock.index')->with([
            'items' => $items,
        ]);
    }

    public function download()
    {
        // 出力する情報を取得
        $export = DB::table('items')
            ->select(DB::raw(
                'item_id as 商品ID,
                item_code as 商品コード,
                item_category as 商品カテゴリ,
                item_jan_code as 商品JANコード,
                item_name as 商品名,
                stock_quantity as 在庫数,
                allocated_stock_quantity as 引当済み在庫数,
                stock_quantity - allocated_stock_quantity as 有効在庫数'
            ))
            ->get();
        // CSVで出力
        return (new FastExcel($export))->download('【petsrock】在庫データ_' . new Carbon('now') . '.csv');
    }
}
