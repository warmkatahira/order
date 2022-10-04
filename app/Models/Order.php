<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'order_id';

    // レコードの追加を許可する
    protected $fillable = [
        'order_user_id', 
        'order_user_name', 
        'store_pic', 
        'order_date', 
        'order_status', 
        'delivery_date', 
        'delivery_time', 
        'shipping_store_name', 
        'shipping_store_zip_code', 
        'shipping_store_address_1', 
        'shipping_store_address_2', 
        'shipping_store_tel_number', 
        'order_comment',
        'shipping_date',
        'tracking_number',
        'warehouse_pic_user_id',
        'warehouse_pic_user_name'
    ];
}
