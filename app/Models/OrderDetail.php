<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'order_detail_id';

    // レコードの追加を許可する
    protected $fillable = [
        'order_id', 
        'order_item_id', 
        'order_item_code', 
        'order_item_jan_code',
        'order_item_name',
        'order_quantity',
    ];
}
