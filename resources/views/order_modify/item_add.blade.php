<script src="{{ asset('js/order.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header" class="">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 text-xl text-gray-800 p-2">
                発注商品追加
            </div>
            <!-- カートアイコン -->
            <a href="{{ session('back_url_3') }}" class="col-start-12 col-span-1 rounded-lg text-center">
                <lord-icon
                    src="https://cdn.lordicon.com/dnoiydox.json"
                    trigger="loop"
                    delay="1000"
                    style="width:50px;height:50px">
                </lord-icon>
                <span id="order_info_counter" class="px-3 py-1 text-xs text-white bg-teal-500 rounded-full">
                    @if(session('order_modify_info'))
                        {{ count(session('order_modify_info')) }}
                    @else
                        0
                    @endif
                </span>
            </a>
            <input type="hidden" id="operation_type" value="modify">
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <!-- 検索条件 -->
        <form method="GET" action="{{ route('order_modify.item_add_search') }}" class="m-0 col-span-12 grid grid-cols-12">
            @component('components.item-search')
            @endcomponent
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