<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 出荷待ち件数
        $syukka_machi_cnt = Order::where('order_status', '出荷待ち')->count();
        // 出荷作業中件数
        $syukka_sagyou_cnt = Order::where('order_status', '出荷作業中')->count();
        // 今月の出荷済み件数を取得
        $current_month_shipping_cnt = Order::whereBetween('shipping_date', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])
                                        ->count();
        return view('home')->with([
            'syukka_machi_cnt' => $syukka_machi_cnt,
            'syukka_sagyou_cnt' => $syukka_sagyou_cnt,
            'current_month_shipping_cnt' => $current_month_shipping_cnt,
        ]);
    }
}
