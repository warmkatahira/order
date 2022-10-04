<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Store;
use App\Services\OrderModifyService;
use App\Services\OrderConfirmService;
use App\Services\ItemSearchService;
use Carbon\Carbon;

class OrderModifyController extends Controller
{
    public function index(Request $request)
    {
        // 現在のURLを取得
        session(['back_url_3' => url()->full()]);
        // サービスクラスを定義
        $OrderModifyService = new OrderModifyService;
        try {
            // トランザクション処理を開始
            DB::beginTransaction();
            // 修正可能な対象であるかチェック
            $order = $OrderModifyService->checkOrderModifyAvailable($request->order_id);
            // 変数が空であれば修正できない発注なので、処理を中断する
            if(empty($order)){
                throw new Exception();
            }
            // テーブルへ反映
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            session()->flash('alert_danger', '修正できない発注です。');  
            return back();
        }
        // 修正対象を取得
        $order = Order::where('order_id', $request->order_id)->first();
        $stores = Store::all();
        return view('order_modify.index')->with([
            'order' => $order,
            'stores' => $stores,
        ]);
    }

    public function item_add()
    {
        // サービスクラスを定義
        $ItemSearchService = new ItemSearchService;
        // 検索条件が格納されているセッションを削除
        $ItemSearchService->deleteSearchSession();
        // 検索処理
        $items = $ItemSearchService->getItemSearch();
        return view('order_modify.item_add')->with([
            'items' => $items,
        ]);
    }

    public function item_add_search(Request $request)
    {
        // サービスクラスを定義
        $ItemSearchService = new ItemSearchService;
        // 検索条件を取得
        $ItemSearchService->getSearchCondition($request);
        // 検索処理
        $items = $ItemSearchService->getItemSearch();
        return view('order_modify.item_add')->with([
            'items' => $items,
        ]);
    }

    public function confirm(Request $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // サービスクラスを定義
        $OrderModifyService = new OrderModifyService;
        $OrderConfirmService = new OrderConfirmService;
        try {
            // トランザクション処理を開始
            DB::beginTransaction();
            // セッションから発注商品情報を取得
            $order_info = $OrderConfirmService->getOrderInfo($request->operation_type);
            // 引当可能な在庫数があるか確認
            $allocate_stock_ng_info = $OrderConfirmService->checkAllocateStock($order_info);
            // 変数が空でなければ引当できていない商品があるので、処理を中断する
            if(empty($allocate_stock_ng_info) == false){
                throw new Exception("100");
            }
            // 引当済み在庫数を計上する
            $OrderConfirmService->updateAllocatedStockQuantity($order_info);
            // ordersテーブルの内容を更新
            $OrderModifyService->modifyOrder($request, $nowDate);
            // order_detailsテーブルの内容を更新
            $OrderModifyService->modifyOrderDetail($request->order_id);
            // メールを送信
            $OrderConfirmService->sendOrderConfirmMail($request->order_id, $request);
            // テーブルへ反映
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            if($e->getMessage() == '100'){
                session()->flash('allocate_stock_ng_info', $allocate_stock_ng_info);  
                return redirect()->back()->withInput();
            }
        }
        // セッションを削除
        $OrderConfirmService->deleteSession($request->operation_type);
        session()->flash('alert_success', '発注が完了しました。');
        // 今回の発注詳細ページへ移動
        return redirect()->route('order_detail.index', ['order_id' => $request->order_id]);
    }
}
