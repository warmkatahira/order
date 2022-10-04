<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'store_id';

    // レコードの追加を許可する
    protected $fillable = [
        'store_name', 'store_zip_code', 'store_address_1', 'store_address_2', 'store_tel_number',
    ];
}
