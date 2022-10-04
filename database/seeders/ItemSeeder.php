<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 30; $i++) {
            Item::create([
                'item_code' => 'A-'.sprintf('%02d', $i),
                'item_category' => 'Tシャツ',
                'item_jan_code' => '11111111111'.sprintf('%02d', $i),
                'item_name' => 'Tシャツ A-'.sprintf('%02d', $i),
                'stock_quantity' => 10,
                'allocated_stock_quantity' => 0,
            ]);
        }
        for ($i = 1; $i <= 30; $i++) {
            Item::create([
                'item_code' => 'B-'.sprintf('%02d', $i),
                'item_category' => 'バッグ',
                'item_jan_code' => '22222222222'.sprintf('%02d', $i),
                'item_name' => 'バッグ B-'.sprintf('%02d', $i),
                'stock_quantity' => 10,
                'allocated_stock_quantity' => 0,
            ]);
        }
        for ($i = 1; $i <= 30; $i++) {
            Item::create([
                'item_code' => 'C-'.sprintf('%02d', $i),
                'item_category' => 'ポーチ',
                'item_jan_code' => '33333333333'.sprintf('%02d', $i),
                'item_name' => 'ポーチ C-'.sprintf('%02d', $i),
                'stock_quantity' => 20,
                'allocated_stock_quantity' => 0,
            ]);
        }
    }
}
