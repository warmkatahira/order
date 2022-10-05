<p class="col-span-12 xl:col-span-2 text-base xl:text-xl border-b-4 border-blue-500 mb-3">検索条件</p>
<div class="col-span-12 grid grid-cols-12 mb-3">
    <!-- 商品コード条件 -->
    <label for="search_item_code" class="col-span-5 xl:col-span-1 text-xs xl:text-sm text-center py-2 bg-black text-white">商品コード</label>
    <input type="text" id="search_item_code" name="search_item_code" class="col-span-7 xl:col-span-1 text-xs xl:text-sm" value="{{ session('search_item_code') }}" autocomplete="off">
    <!-- 商品カテゴリ条件 -->
    <label for="search_item_category" class="col-span-5 xl:col-span-1 text-xs xl:text-sm text-center py-2 bg-black text-white">商品カテゴリ</label>
    <input type="text" id="search_item_category" name="search_item_category" class="col-span-7 xl:col-span-1 text-xs xl:text-sm" value="{{ session('search_item_category') }}" autocomplete="off">
    <!-- 商品JANコード条件 -->
    <label for="search_item_jan_code" class="col-span-5 xl:col-span-1 text-xs xl:text-sm text-center py-2 bg-black text-white">商品JANコード</label>
    <input type="text" id="search_item_jan_code" name="search_item_jan_code" class="col-span-7 xl:col-span-1 text-xs xl:text-sm" value="{{ session('search_item_jan_code') }}" autocomplete="off">
    <!-- 商品名条件 -->
    <label for="search_item_name" class="col-span-5 xl:col-span-1 text-xs xl:text-sm text-center py-2 bg-black text-white">商品名</label>
    <input type="text" id="search_item_name" name="search_item_name" class="col-span-7 xl:col-span-1 text-xs xl:text-sm" value="{{ session('search_item_name') }}" autocomplete="off">
    <!-- 検索ボタン -->
    <button type="submit" class="col-start-1 xl:col-start-12 col-span-12 xl:col-span-1 py-2 xl:py-0 mt-2 xl:mt-0 rounded-lg bg-black text-white"><i class="las la-search la-lg"></i></button>
</div>