<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Services\ShippingActualService;

class ShippingActualController extends Controller
{
    public function index()
    {
        // 現在のURLを取得
        session(['back_url_2' => url()->full()]);
        return view('shipping_actual.index')->with([
            
        ]);
    }

    public function check(Request $request)
    {
        // 選択したファイルをストレージに保存
        $select_file = $request->file('shipping_actual_csv');
        $uploaded_file = $select_file->getClientOriginalName();
        $orgName = 'shipping_actual.csv';
        $spath = storage_path('app/');
        $path = $spath.$select_file->storeAs('public/import',$orgName);
        // データを取得
        $lines = (new FastExcel)->import($path);
        // 変数に空をセット
        $imports = array();
        // データの行数分だけループ
        foreach ($lines as $index => $line) {
            // UTF-8形式に変換（日本語文字化け対策）
            $line = mb_convert_encoding($line, 'UTF-8', 'ASCII, JIS, UTF-8, SJIS-win');
            // 変数にデータをセット
            $imports[] = [
                'order_id' => $line['発注ID'],
                'shipping_date' => $line['出荷日'],
                'tracking_number' => $line['問い合わせ番号'],
                'shipping_method' => $line['配送方法'],
            ];
        }
        // 情報をセッションに格納
        session(['imports' => $imports]);
        return view('shipping_actual.check')->with([
            'imports' => $imports,
        ]);
    }

    public function upload()
    {
        // サービスクラスを定義
        $ShippingActualService = new ShippingActualService;
        try {
            // トランザクション処理を開始
            DB::beginTransaction();
            // 出荷実績を反映
            $msg = $ShippingActualService->updateShippingActual();
            // msgがnullなら問題なし、それ以外は出荷実績が反映できない理由がある為、処理を中断
            if(empty($msg) == false){
                throw new Exception($msg);
            }
            // 在庫数を更新
            $ShippingActualService->updateStockQuantity();
            // テーブルへ反映
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            session()->flash('alert_danger', $e->getMessage());
            return redirect()->route('shipping_actual.index');
        }
        // 出荷完了メールを送信
        $ShippingActualService->sendShippingActualMail();
        // セッションを削除
        session()->forget('import');
        session()->flash('alert_success', '出荷実績を反映しました。');
        return redirect()->route('shipping_actual.index');
    }
}
