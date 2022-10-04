<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Store;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

class StoreController extends Controller
{
    public function index()
    {
        // 店舗マスタの情報を取得
        $stores = Store::all();
        return view('master.store_index')->with([
            'stores' => $stores,
        ]);
    }

    public function register_modify(Request $request)
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
        // Storeのmodelクラスのインスタンスを生成
        $store = new Store();
        // データベースに値をinsert
        $store->create([
            'store_name' => $request->store_name,
            'store_zip_code' => $request->store_zip_code,
            'store_address_1' => $request->store_address_1,
            'store_address_2' => $request->store_address_2,
            'store_tel_number' => $request->store_tel_number
        ]);
        return;
    }

    public function modify($request)
    {
        // 店舗情報を更新する
        Store::where('store_id', $request->store_id)->update([
            'store_name' => $request->store_name,
            'store_zip_code' => $request->store_zip_code,
            'store_address_1' => $request->store_address_1,
            'store_address_2' => $request->store_address_2,
            'store_tel_number' => $request->store_tel_number
        ]);
        return;
    }

    public function delete(Request $request)
    {
        // 店舗を削除する
        $store = Store::where('store_id', $request->store_id)->first();
        $store->delete();
        return back();
    }

    public function store_info_get_ajax(Request $request)
    {
        // 変更対象の店舗情報を取得
        $store = Store::where('store_id', $request->store_id)->first();
        // 結果を返す
        return response()->json([
            'store' => $store,
        ]);
    }

    public function download()
    {
        // 出力する情報を取得
        $export = DB::table('stores')
            ->select(DB::raw(
                'store_id as 店舗ID,
                store_name as 店舗名,
                store_zip_code as 店舗郵便番号,
                store_address_1 as 店舗住所1,
                store_address_2 as 店舗住所2,
                store_tel_number as 店舗電話番号'
            ))
            ->get();
        // CSVで出力
        return (new FastExcel($export))->download('【petsrock】店舗マスタ_' . new Carbon('now') . '.csv');
    }
}
