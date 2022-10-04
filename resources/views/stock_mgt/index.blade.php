<script src="{{ asset('js/stock_mgt.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 text-xl text-gray-800 p-2">
                在庫管理
            </div>
            <a href="{{ route('stock_history_list.index') }}" class="col-start-11 col-span-1 rounded-lg text-center bg-orange-200 py-2">履歴一覧</a>
            <button type="button" id="stock_mgt_enter" class="col-start-12 col-span-1 rounded-lg text-center bg-blue-200">計上</button>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <!-- 検索条件 -->
        <form method="GET" action="{{ route('stock_mgt.search') }}" class="m-0 col-span-12 grid grid-cols-12">
            <p class="text-xl border-b-4 border-blue-500 col-span-2 mb-3">検索条件</p>
            <div class="col-span-12 grid grid-cols-12 mb-3">
                <!-- 商品コード条件 -->
                <label for="search_item_code" class="col-span-1 text-sm text-center py-2 bg-black text-white">商品コード</label>
                <input type="text" id="search_item_code" name="search_item_code" class="text-xs col-span-1" value="{{ session('search_item_code') }}" autocomplete="off">
                <!-- 商品カテゴリ条件 -->
                <label for="search_item_category" class="col-span-1 text-sm text-center py-2 bg-black text-white">商品カテゴリ</label>
                <input type="text" id="search_item_category" name="search_item_category" class="text-xs col-span-1" value="{{ session('search_item_category') }}" autocomplete="off">
                <!-- 商品JANコード条件 -->
                <label for="search_item_jan_code" class="col-span-1 text-sm text-center py-2 bg-black text-white">商品JANコード</label>
                <input type="text" id="search_item_jan_code" name="search_item_jan_code" class="text-xs col-span-1" value="{{ session('search_item_jan_code') }}" autocomplete="off">
                <!-- 商品名条件 -->
                <label for="search_item_name" class="col-span-1 text-sm text-center py-2 bg-black text-white">商品名</label>
                <input type="text" id="search_item_name" name="search_item_name" class="text-xs col-span-2" value="{{ session('search_item_name') }}" autocomplete="off">
                <button type="submit" class="col-start-12 col-span-1 rounded-lg bg-black text-white"><i class="las la-search la-lg"></i></button>
            </div>
        </form>
        <form method="post" action="{{ route('stock_mgt.confirm') }}" id="stock_mgt_form" class="m-0 col-span-12 grid grid-cols-12">
            @csrf
            <table class="col-span-12">
                <thead>
                    <tr class="text-sm text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 px-2 w-2/12">商品コード</th>
                        <th class="font-thin p-2 px-2 w-2/12">商品カテゴリ</th>
                        <th class="font-thin p-2 px-2 w-1/12">商品JANコード</th>
                        <th class="font-thin p-2 px-2 w-5/12">商品名</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-right">在庫数</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-right">数量</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($items as $item)
                        <tr class="text-sm hover:bg-teal-100">
                            <td class="p-1 px-2 border">{{ $item->item_code }}</td>
                            <td class="p-1 px-2 border">{{ $item->item_category }}</td>
                            <td class="p-1 px-2 border">{{ $item->item_jan_code }}</td>
                            <td class="p-1 px-2 border">{{ $item->item_name }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($item->stock_quantity) }}</td>
                            <td class="p-1 px-2 border text-right"><input type="tel" name="{{ 'quantity[' .$item->item_id.']' }}" class="text-sm text-right rounded-lg" autocomplete="off"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
    <!-- ページネーション -->
    <div class="px-4 my-3">
        {{ $items->appends(request()->input())->links() }}
    </div>
</x-app-layout>