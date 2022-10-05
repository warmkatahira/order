<script src="{{ asset('js/stock_mgt.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-4 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                在庫管理
            </div>
            <a href="{{ route('stock_history_list.index') }}" class="col-start-7 xl:col-start-11 col-span-3 xl:col-span-1 rounded-lg text-center bg-orange-200 py-3 text-xs xl:text-sm">履歴一覧</a>
            <button type="button" id="stock_mgt_enter" class="col-start-10 xl:col-start-12 col-span-3 xl:col-span-1 rounded-lg text-center bg-blue-200 text-xs xl:text-sm">計上</button>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <!-- 検索条件 -->
        <form method="GET" action="{{ route('stock_mgt.search') }}" class="m-0 col-span-12 grid grid-cols-12">
            @component('components.item-search')
            @endcomponent
        </form>
        <form method="post" action="{{ route('stock_mgt.confirm') }}" id="stock_mgt_form" class="m-0 col-span-12 grid grid-cols-12">
            @csrf
            <div class="col-span-12 grid grid-cols-12 overflow-x-auto">
                <table class="col-span-12 min-w-full">
                    <thead>
                        <tr class="text-xs xl:text-sm text-left text-white bg-gray-600 border-gray-600 whitespace-nowrap">
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
                            <tr class="text-xs xl:text-sm hover:bg-teal-100 whitespace-nowrap">
                                <td class="p-1 px-2 border">{{ $item->item_code }}</td>
                                <td class="p-1 px-2 border">{{ $item->item_category }}</td>
                                <td class="p-1 px-2 border">{{ $item->item_jan_code }}</td>
                                <td class="p-1 px-2 border">{{ $item->item_name }}</td>
                                <td class="p-1 px-2 border text-right">{{ number_format($item->stock_quantity) }}</td>
                                <td class="p-1 px-2 border text-right"><input type="tel" name="{{ 'quantity[' .$item->item_id.']' }}" class="text-xs xl:text-sm text-right rounded-lg" autocomplete="off"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
        <!-- ページネーション -->
        <div class="col-span-12 mt-3">
            {{ $items->appends(request()->input())->links() }}
        </div>
    </div>
</x-app-layout>