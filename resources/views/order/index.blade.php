<script src="{{ asset('js/order.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header" class="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-8 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                発注商品選択
            </div>
            <!-- カートアイコン -->
            <a href="{{ route('order.input') }}" class="col-start-9 xl:col-start-12 col-span-4 xl:col-span-1 rounded-lg text-center">
                <lord-icon
                    src="https://cdn.lordicon.com/dnoiydox.json"
                    trigger="loop"
                    delay="1000"
                    style="width:50px;height:50px">
                </lord-icon>
                <span id="order_info_counter" class="px-3 py-1 text-xs text-white bg-teal-500 rounded-full">
                    @if(session('order_info'))
                        {{ count(session('order_info')) }}
                    @else
                        0
                    @endif
                </span>
            </a>
            <input type="hidden" id="operation_type" value="new">
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <!-- 検索条件 -->
        <form method="GET" action="{{ route('order.item_search') }}" class="m-0 col-span-12 grid grid-cols-12">
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
        </form>
        <table class="col-span-12">
            <thead>
                <tr class="text-sm text-left text-white bg-gray-600 border-gray-600">
                    <th class="font-thin p-2 px-2 w-2/12">商品コード</th>
                    <th class="font-thin p-2 px-2 w-2/12">商品カテゴリ</th>
                    <th class="font-thin p-2 px-2 w-1/12">商品JANコード</th>
                    <th class="font-thin p-2 px-2 w-5/12">商品名</th>
                    <th class="font-thin p-2 px-2 w-1/12 text-right">有効在庫数</th>
                    <th class="font-thin p-2 px-2 w-1/12 text-center">発注</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($items as $item)
                    <tr class="text-sm h-14 hover:bg-teal-100">
                        <td class="p-1 px-2 border">{{ $item->item_code }}</td>
                        <td class="p-1 px-2 border">{{ $item->item_category }}</td>
                        <td class="p-1 px-2 border">{{ $item->item_jan_code }}</td>
                        <td class="p-1 px-2 border">{{ $item->item_name }}</td>
                        <td class="p-1 px-2 border text-right">{{ number_format(GetAvailableStockQuantityFunc::GetAvailableStockQuantityFunc($item->item_id)) }}</td>
                        <td class="p-1 px-2 border text-center">
                            <!-- 有効在庫数が1以上あれば発注ボタンを表示、なければボタンを非表示にする -->
                            @if(GetAvailableStockQuantityFunc::GetAvailableStockQuantityFunc($item->item_id) > 0)
                                <button type="button" id="{{ $item->item_id }}" class="order_in text-center"><i class="las la-cart-plus la-2x"></i></button>
                            @else
                                <p class="text-sm">在庫なし</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- ページネーション -->
        <div class="col-span-12 mt-3">
            {{ $items->appends(request()->input())->links() }}
        </div>
    </div>
</x-app-layout>