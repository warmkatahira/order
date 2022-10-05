<x-app-layout>
    <x-slot name="header" class="">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_2') }}" class="col-span-2 xl:col-span-1 rounded-lg bg-black text-white text-center py-3 text-xs xl:text-sm">戻る</a>
            <div class="col-span-10 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                在庫計上履歴詳細
            </div>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <div class="col-span-12 grid grid-cols-12 gap-4">
            <div class="col-span-4 xl:col-span-2 rounded-lg bg-emerald-100 text-xs xl:text-sm text-center py-3 px-2 border border-black">
                <p>在庫計上ID</p>
                {{ $stock_history->stock_history_id }}
            </div>
            <div class="col-span-4 xl:col-span-2 rounded-lg bg-emerald-100 text-xs xl:text-sm text-center py-3 px-2 border border-black">
                <p>計上日</p>
                {{ $stock_history->operation_date }}
            </div>
            <div class="col-span-4 xl:col-span-2 rounded-lg bg-emerald-100 text-xs xl:text-sm text-center py-3 px-2 border border-black">
                <p>計上者</p>
                {{ $stock_history->operation_user_name }}
            </div>
            <div class="col-span-12 xl:col-span-6 rounded-lg bg-emerald-100 text-xs xl:text-sm text-left py-3 px-2 border border-black">
                <p>コメント</p>
                {{ $stock_history->operation_comment }}
            </div>
        </div>
        <!-- 商品一覧 -->
        <div class="col-span-12 grid grid-cols-12 overflow-x-auto">
            <table class="col-start-1 col-span-12 mt-5 min-w-full">
                <thead>
                    <tr class="text-xs xl:text-sm text-left text-white bg-gray-600 border-gray-600 whitespace-nowrap">
                        <th class="font-thin p-2 px-2 w-1/12">計上区分</th>
                        <th class="font-thin p-2 px-2 w-2/12">商品コード</th>
                        <th class="font-thin p-2 px-2 w-1/12">商品JANコード</th>
                        <th class="font-thin p-2 px-2 w-7/12">商品名</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-right">計上数</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($stock_history_details as $stock_history_detail)
                        <tr class="text-xs xl:text-sm hover:bg-teal-100 whitespace-nowrap">
                            <td class="p-1 px-2 border">{{ $stock_history_detail->operation_category }}</td>
                            <td class="p-1 px-2 border">{{ $stock_history_detail->operation_item_code }}</td>
                            <td class="p-1 px-2 border">{{ $stock_history_detail->operation_item_jan_code }}</td>
                            <td class="p-1 px-2 border">{{ $stock_history_detail->operation_item_name }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($stock_history_detail->operation_quantity) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>