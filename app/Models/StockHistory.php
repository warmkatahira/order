<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'stock_history_id';

    // レコードの追加を許可する
    protected $fillable = [
        'operation_date',
        'operation_user_name',
        'operation_comment',
    ];
}
