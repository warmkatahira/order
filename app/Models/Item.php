<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'item_id';

    // レコードの追加を許可する
    protected $fillable = [
        'item_code', 'item_category', 'item_jan_code', 'item_name', 'stock_quantity', 'allocated_stock_quantity'
    ];
}
