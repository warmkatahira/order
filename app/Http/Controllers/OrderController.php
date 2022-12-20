<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Store;
use Carbon\Carbon;
use App\Http\Requests\OrderConfirmRequest;
use App\Services\OrderConfirmService;
use App\Services\ItemSearchService;

class OrderController extends Controller
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
        return view('order.index')->with([
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
        return view('order.index')->with([
            'items' => $items,
        ]);
    }

    public function input()
    {
        // 店舗マスタを取得
        $stores = Store::all();
        return view('order.input')->with([
            'stores' => $stores,
        ]);
    }

    public function confirm(OrderConfirmRequest $request)
    {
        // 現在の日時を取得
        $nowDate = new Carbon('now');
        // サービスクラスを定義
        $OrderConfirmService = new OrderConfirmService;
        try {
            // トランザクション処理を開始
            //DB::beginTransaction();
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
            // ordersテーブルにレコードを追加
            $order = $OrderConfirmService->addOrder($request, $nowDate);
            // order_detailsテーブルにレコードを追加
            $OrderConfirmService->addOrderDetail($order['order_id'], $order_info);
            // メールを送信
            $OrderConfirmService->sendOrderConfirmMail($order['order_id'], $request);
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
        return redirect()->route('order_detail.index', ['order_id' => $order['order_id']]);
    }

    public function cart_in_ajax(Request $request)
    {
        // 商品の情報を取得
        $item = Item::where('item_id', $request->item_id)->first();
        // 現在のカートセッション情報を変数にセット（空の場合は空をセット）
        if($request->operation_type == "new"){
            $order_info = session()->exists('order_info') ? session('order_info') : array();
        }
        if($request->operation_type == "modify"){
            $order_info = session()->exists('order_modify_info') ? session('order_modify_info') : array();
        }
        // 配列に存在しない商品であれば追加
        if(array_key_exists($item->item_id, $order_info) == false){
            // 変数に今回の商品情報をセット(商品IDをキーにしてセット)
            $order_info[$item->item_id] = [
                'item_id' => $item->item_id,
                'item_code' => $item->item_code,
                'item_jan_code' => $item->item_jan_code,
                'item_name' => $item->item_name,
                'quantity' => 1
            ];
        }
        // セッションに変数をセット
        if($request->operation_type == "new"){
            session(['order_info' => $order_info]);
        }
        if($request->operation_type == "modify"){
            session(['order_modify_info' => $order_info]);
        }
        // 結果を返す
        return response()->json([
            'item' => $item,
            'order_info_counter' => count($order_info),
        ]);
    }

    public function cart_delete_ajax(Request $request)
    {
        // 現在のカートセッション情報を変数にセット
        if($request->operation_type == "new"){
            $order_info = session('order_info');
        }
        if($request->operation_type == "modify"){
            $order_info = session('order_modify_info');
        }
        // キーを指定して削除
        unset($order_info[$request->item_id]);
        // セッションに変数をセット
        if($request->operation_type == "new"){
            session(['order_info' => $order_info]);
        }
        if($request->operation_type == "modify"){
            session(['order_modify_info' => $order_info]);
        }
        // 結果を返す
        return response()->json();
    }

    public function order_quantity_change_ajax(Request $request)
    {
        // 現在のカートセッション情報を変数にセット
        if($request->operation_type == "new"){
            $order_info = session('order_info');
        }
        if($request->operation_type == "modify"){
            $order_info = session('order_modify_info');
        }
        // キーを指定して発注数を変更
        $order_info[$request->item_id]['quantity'] = $request->quantity;
        // セッションに変数をセット
        if($request->operation_type == "new"){
            session(['order_info' => $order_info]);
        }
        if($request->operation_type == "modify"){
            session(['order_modify_info' => $order_info]);
        }
        // 結果を返す
        return response()->json();
    }

    public function store_search_get_ajax(Request $request)
    {
        // 店舗情報を取得
        $stores = Store::where('store_name', 'LIKE', '%'.$request->search_word.'%')->get();
        // 結果を返す
        return response()->json([
            'stores' => $stores,
        ]);
    }

    public function select_store_get_ajax(Request $request)
    {
        // 店舗情報を取得
        $store = Store::where('store_id', $request->store_id)->first();
        // 結果を返す
        return response()->json([
            'store' => $store,
        ]);
    }
}
