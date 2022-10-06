<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Store;


class StoreSearchService
{
    public function deleteSearchSession()
    {
        // セッションを削除
        session()->forget(['search_store_name', 'search_store_address_1']);
        return;
    }

    public function getSearchCondition($request)
    {
        // セッションに検索条件をセット
        session(['search_store_name' => $request->search_store_name]);
        session(['search_store_address_1' => $request->search_store_address_1]);
        return;
    }

    public function getStoreSearch()
    {
        // クエリを使用する
        $query = store::query();
        // 店舗名条件がある場合
        if (!empty(session('search_store_name'))) {
            $query->where('store_name', 'LIKE', '%'.session('search_store_name').'%');
        }
        // 店舗住所1条件がある場合
        if (!empty(session('search_store_address_1'))) {
            $query->where('store_address_1', 'LIKE', '%'.session('search_store_address_1').'%');
        }
        $stores = $query->paginate(20);
        return $stores;
    }
}