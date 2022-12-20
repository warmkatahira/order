<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use Rap2hpoutre\FastExcel\FastExcel;

class ShippingDataDownloadController extends Controller
{
    public function download()
    {
        // 出力する情報を取得
        $export = DB::table('orders')
            ->where('order_status', '出荷作業中')
            ->select(
                'orders.order_id as 発注ID',
                'orders.order_date as 発注日',
                'orders.shipping_store_name as 配送先店舗名',
                'orders.shipping_store_zip_code as 配送先郵便番号',
                'orders.shipping_store_address_1 as 配送先住所1',
                'orders.shipping_store_address_2 as 配送先住所2',
                'orders.shipping_store_tel_number as 配送先電話番号',
                'orders.store_pic as 店舗担当者',
                'orders.delivery_date as 配送希望日',
                'orders.delivery_time as 配送希望時間',
                'orders.shipping_method as 配送方法',
                'order_details.order_item_code as 商品コード',
                'order_details.order_item_jan_code as 商品JANコード',
                'order_details.order_item_name as 商品名',
                'order_details.order_quantity as 発注数',
            )
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->get();
        // 出力できるデータがなければ処理を中断
        if($export->count() == 0){
            session()->flash('alert_danger', '出荷作業中の発注がない為、出荷データをダウンロードできません。');
            return back();
        }
        // CSVで出力
        return (new FastExcel($export))->download('【petsrock】出荷データ_' . new Carbon('now') . '.csv');
    }
}
