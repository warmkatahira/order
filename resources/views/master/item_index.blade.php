<script src="{{ asset('js/item.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-4 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                商品マスタ
            </div>
            <a href="{{ route('item.download') }}" class="col-start-7 xl:col-start-11 col-span-3 xl:col-span-1 rounded-lg text-center bg-orange-200 py-3 text-xs xl:text-sm">出力</a>
            <button type="button" id="item_register_modal_open" class="col-start-10 xl:col-start-12 col-span-3 xl:col-span-1 rounded-lg text-center bg-blue-200 text-xs xl:text-sm">登録</button>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <!-- 検索条件 -->
        <form method="GET" action="{{ route('item.search') }}" class="m-0 col-span-12 grid grid-cols-12">
            @component('components.item-search')
            @endcomponent
        </form>
        <div class="col-span-12 grid grid-cols-12 overflow-x-auto">
            <table class="col-span-12 min-w-full">
                <thead>
                    <tr class="text-xs xl:text-sm text-left text-white bg-gray-600 border-gray-600 whitespace-nowrap">
                        <th class="font-thin p-2 px-2 w-2/12">商品コード</th>
                        <th class="font-thin p-2 px-2 w-2/12">商品カテゴリ</th>
                        <th class="font-thin p-2 px-2 w-2/12">商品JANコード</th>
                        <th class="font-thin p-2 px-2 w-5/12">商品名</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-center">操作</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($items as $item)
                        <tr class="text-xs xl:text-sm hover:bg-teal-100 whitespace-nowrap">
                            <td class="p-1 px-2 border">{{ $item->item_code }}</td>
                            <td class="p-1 px-2 border">{{ $item->item_category }}</td>
                            <td class="p-1 px-2 border">{{ $item->item_jan_code }}</td>
                            <td class="p-1 px-2 border">{{ $item->item_name }}</td>
                            <td class="p-1 px-2 border text-center">
                                <a id="{{ $item->item_id }}" class="item_modify cursor-pointer text-xs xl:text-sm bg-orange-200 rounded-lg text-center px-2 py-1">変更</a>
                                <a href="{{ route('item.delete', ['item_id' => $item->item_id]) }}" class="item_delete text-xs xl:text-sm bg-red-500 text-white rounded-lg text-center px-2 py-1">削除</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- ページネーション -->
        <div class="col-span-12 mt-3">
            {{ $items->appends(request()->input())->links() }}
        </div>
    </div>
    <!-- 商品登録モーダル -->
    <div id="item_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-20 mx-auto shadow-lg rounded-md bg-white max-w-2xl">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4 id="modal_header"></h4>
                <button class="item_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" id="item_register_form" action="{{ route('item.register_modify') }}" class="m-0">
                    @csrf
                    <label for="item_code" class="text-sm">商品コード<span class="text-xs bg-red-500 text-white text-center px-2 py-1 rounded-md ml-1">必須</span></label><br>
                    <input type="text" id="item_code" name="item_code" class="w-1/2 mb-3 rounded-lg text-sm" placeholder="商品コード" autocomplete="off"><br>
                    <label for="item_category" class="text-sm">商品カテゴリ</label><br>
                    <input type="text" id="item_category" name="item_category" class="w-1/2 mb-3 rounded-lg text-sm" placeholder="商品カテゴリ" autocomplete="off"><br>
                    <label for="item_jan_code" class="text-sm">商品JANコード</label><br>
                    <input type="text" id="item_jan_code" name="item_jan_code" class="w-1/2 mb-3 rounded-lg text-sm" placeholder="商品JANコード" autocomplete="off"><br>
                    <label for="item_name" class="text-sm">商品名<span class="text-xs bg-red-500 text-white text-center px-2 py-1 rounded-md ml-1">必須</span></label><br>
                    <input type="text" id="item_name" name="item_name" class="w-full mb-3 rounded-lg text-sm" placeholder="商品名" autocomplete="off"><br>
                    <input type="hidden" id="operation_type" name="operation_type">
                    <input type="hidden" id="item_id" name="item_id">
                </form>
                
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <a id="item_register_enter" class="cursor-pointer rounded-lg bg-blue-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    登録
                </a>
                <a class="item_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>