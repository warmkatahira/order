<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistoryDetail extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'stock_history_detail_id';

    // レコードの追加を許可する
    protected $fillable = [
        'stock_history_id',
        'operation_category', 
        'operation_item_code', 
        'operation_item_jan_code',
        'operation_item_name',
        'operation_quantity',
    ];
}
