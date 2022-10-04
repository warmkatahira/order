<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Services\ItemSearchService;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

class ItemController extends Controller
{
    public function index()
    {
        // サービスクラスを定義
        $ItemSearchService = new ItemSearchService;
        // 検索条件が格納されているセッションを削除
        $ItemSearchService->deleteSearchSession();
        // 検索処理
        $items = $ItemSearchService->getItemSearch();
        return view('master.item_index')->with([
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
        return view('master.item_index')->with([
            'items' => $items,
        ]);
    }

    public function register_modify(ItemRequest $request)
    {
        // オペレーションタイプによって、処理を分岐
        if($request->operation_type == 'add'){
            $this->register($request);
        }
        if($request->operation_type == 'mod'){
            $this->modify($request);
        }
        return back();
    }

    public function register($request)
    {
        // Itemのmodelクラスのインスタンスを生成
        $item = new Item();
        // データベースに値をinsert
        $item->create([
            'item_code' => $request->item_code,
            'item_category' => $request->item_category,
            'item_jan_code' => $request->item_jan_code,
            'item_name' => $request->item_name,
            'stock_quantity' => 0,
            'allocated_stock_quantity' => 0,
        ]);
        return;
    }

    public function modify($request)
    {
        // 商品情報を更新する
        Item::where('item_id', $request->item_id)->update([
            'item_code' => $request->item_code,
            'item_category' => $request->item_category,
            'item_jan_code' => $request->item_jan_code,
            'item_name' => $request->item_name,
        ]);
        return;
    }

    public function delete(Request $request)
    {
        // 商品を削除する
        $item = Item::where('item_id', $request->item_id)->first();
        $item->delete();
        return back();
    }

    public function item_info_get_ajax(Request $request)
    {
        // 変更対象の商品情報を取得
        $item = Item::where('item_id', $request->item_id)->first();
        // 結果を返す
        return response()->json([
            'item' => $item,
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
                item_name as 商品名'
            ))
            ->get();
        // CSVで出力
        return (new FastExcel($export))->download('【petsrock】商品マスタ_' . new Carbon('now') . '.csv');
    }
}
