<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::create([
            'store_id' => 1,
            'store_name' => '伊勢丹　新宿店',
            'store_zip_code' => '160-0022',
            'store_address_1' => '東京都新宿区新宿３丁目１４−１',
            'store_address_2' => '',
            'store_tel_number' => '03-3352-1111',
        ]);
        Store::create([
            'store_id' => 2,
            'store_name' => '北千住マルイ',
            'store_zip_code' => '120-8501',
            'store_address_1' => '東京都足立区千住３丁目９２',
            'store_address_2' => 'ミルディスI 番館',
            'store_tel_number' => '03-5244-0101',
        ]);
        Store::create([
            'store_id' => 3,
            'store_name' => '渋谷ストリーム',
            'store_zip_code' => '150-0002',
            'store_address_1' => '東京都渋谷区渋谷３丁目２１−３',
        ]);
    }
}
