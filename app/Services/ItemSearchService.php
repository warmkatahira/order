<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Item;

class ItemSearchService
{
    public function deleteSearchSession()
    {
        // セッションを削除
        session()->forget(['search_item_code', 'search_item_category', 'search_item_jan_code', 'search_item_name']);
        return;
    }

    public function getSearchCondition($request)
    {
        // セッションに検索条件をセット
        session(['search_item_code' => $request->search_item_code]);
        session(['search_item_category' => $request->search_item_category]);
        session(['search_item_jan_code' => $request->search_item_jan_code]);
        session(['search_item_name' => $request->search_item_name]);
        return;
    }

    public function getItemSearch()
    {
        // クエリを使用する
        $query = Item::query();
        // 商品コード条件がある場合
        if (!empty(session('search_item_code'))) {
            $query->where('item_code', 'LIKE', '%'.session('search_item_code').'%');
        }
        // 商品カテゴリ条件がある場合
        if (!empty(session('search_item_category'))) {
            $query->where('item_category', 'LIKE', '%'.session('search_item_category').'%');
        }
        // 商品JANコード条件がある場合
        if (!empty(session('search_item_jan_code'))) {
            $query->where('item_jan_code', 'LIKE', '%'.session('search_item_jan_code').'%');
        }
        // 商品名条件がある場合
        if (!empty(session('search_item_name'))) {
            $query->where('item_name', 'LIKE', '%'.session('search_item_name').'%');
        }
        $items = $query->paginate(20);
        return $items;
    }
}