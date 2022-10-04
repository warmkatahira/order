<script src="{{ asset('js/order_input.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header" class="">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_2') }}" class="col-span-1 rounded-lg bg-black text-white text-center py-2">戻る</a>
            <div class="col-span-2 text-xl text-gray-800 p-2">
                発注修正
            </div>
            <a href="{{ route('order_modify.item_add') }}" class="col-start-11 col-span-1 rounded-lg text-center bg-orange-200 py-2">商品追加</a>
            <button type="button" id="order_enter" class="col-start-12 col-span-1 rounded-lg text-center bg-blue-200">発注</button>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <form method="post" action="{{ route('order_modify.confirm') }}" id="order_form" class="m-0 col-span-12 grid grid-cols-12">
            @csrf
            <input type="hidden" id="operation_type" name="operation_type" value="modify">
            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
            <div class="col-span-12 grid grid-cols-12 gap-4 grid-rows-6">
                <!-- 配送先欄 -->
                <div class="row-span-6 col-start-1 col-span-5 grid grid-cols-12 gap-4 border border-black rounded-lg p-3 bg-emerald-100">
                    <div class="col-span-12 grid grid-cols-12">
                        <p class="col-span-12"><i class="las la-info-circle la-lg"></i>配送先</p>
                    </div>
                    <div class="col-span-12 grid grid-cols-12">
                        <label for="shipping_store_name" class="col-start-1 col-span-3 ml-6 mt-2 text-sm">店舗名<span class="text-xs bg-red-500 text-white text-center px-2 py-1 rounded-md ml-1">必須</span></label>
                        <input type="text" id="shipping_store_name" name="shipping_store_name" class="rounded-lg col-span-6 text-sm" autocomplete="off" value="{{ old('shipping_store_name', $order->shipping_store_name) }}">
                        <button type="button" id="store_select_modal_open" class="col-start-11 col-span-2 rounded-lg bg-black text-white text-sm text-center">選択</button>
                    </div>
                    <div class="col-span-12 grid grid-cols-12">
                        <label for="shipping_store_zip_code" class="col-start-1 col-span-3 ml-6 mt-2 text-sm">〒<span class="text-xs bg-red-500 text-white text-center px-2 py-1 rounded-md ml-1">必須</span></label>
                        <input type="tel" id="shipping_store_zip_code" name="shipping_store_zip_code" class="rounded-lg col-span-3 text-sm" autocomplete="off" value="{{ old('shipping_store_zip_code', $order->shipping_store_zip_code) }}">
                    </div>
                    <div class="col-span-12 grid grid-cols-12">
                        <label for="shipping_store_address_1" class="col-start-1 col-span-3 ml-6 mt-2 text-sm">住所1<span class="text-xs bg-red-500 text-white text-center px-2 py-1 rounded-md ml-1">必須</span></label>
                        <input type="text" id="shipping_store_address_1" name="shipping_store_address_1" class="rounded-lg col-span-9 text-sm" autocomplete="off" value="{{ old('shipping_store_address_1', $order->shipping_store_address_1) }}">
                    </div>
                    <div class="col-span-12 grid grid-cols-12">
                        <label for="shipping_store_address_2" class="col-start-1 col-span-3 ml-6 mt-2 text-sm">住所2</label>
                        <input type="text" id="shipping_store_address_2" name="shipping_store_address_2" class="rounded-lg col-span-9 text-sm" autocomplete="off" value="{{ old('shipping_store_address_2', $order->shipping_store_address_2) }}">
                    </div>
                    <div class="col-span-12 grid grid-cols-12">
                        <label for="shipping_store_tel_number" class="col-start-1 col-span-3 ml-6 mt-2 text-sm">TEL<span class="text-xs bg-red-500 text-white text-center px-2 py-1 rounded-md ml-1">必須</span></label>
                        <input type="tel" id="shipping_store_tel_number" name="shipping_store_tel_number" class="rounded-lg col-span-3 text-sm" autocomplete="off" value="{{ old('shipping_store_tel_number', $order->shipping_store_tel_number) }}">
                    </div>
                    <div class="col-span-12 grid grid-cols-12">
                        <label for="store_pic" class="col-start-1 col-span-3 ml-6 mt-2 text-sm">担当者<span class="text-xs bg-red-500 text-white text-center px-2 py-1 rounded-md ml-1">必須</span></label>
                        <input type="text" id="store_pic" name="store_pic" class="rounded-lg col-span-3 text-sm" autocomplete="off" value="{{ old('store_pic', $order->store_pic) }}">
                    </div>
                </div>
                <!-- 配送希望日時欄 -->
                <div class="row-span-3 col-span-3 grid grid-cols-12 gap-4 border border-black rounded-lg p-3 bg-emerald-100">
                    <div class="col-span-12 grid grid-cols-12">
                        <p class="col-span-12"><i class="las la-info-circle la-lg"></i>配送希望日時</p>
                    </div>
                    <div class="col-span-12 grid grid-cols-12">
                        <label for="delivery_date" class="col-start-1 col-span-5 ml-6 mt-2 text-sm">配送希望日</label>
                        <input type="date" id="delivery_date" name="delivery_date" class="rounded-lg col-span-7 text-sm" autocomplete="off" value="{{ old('delivery_date', $order->delivery_date) }}">
                    </div>
                    <div class="col-span-12 grid grid-cols-12">
                        <label for="delivery_time" class="col-start-1 col-span-5 ml-6 mt-2 text-sm">配送希望時間</label>
                        <select id="delivery_time" name="delivery_time" class="rounded-lg col-span-7 text-sm">
                            @foreach(App\Consts\DeliveryTimeConsts::TIME_LIST as $key => $value)
                                <option value="{{ $key }}" {{ $key == old('delivery_time', $order->delivery_time) ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- 発注商品一覧 -->
            <p class="col-start-1 mt-5"><i class="las la-info-circle la-lg"></i>発注商品</p>
            <table class="col-start-1 col-span-8">
                <thead>
                    <tr class="text-sm text-left text-white bg-gray-600 border-gray-600">
                        <th class="font-thin p-2 px-2 w-2/12">商品コード</th>
                        <th class="font-thin p-2 px-2 w-5/12">商品名</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-right">有効在庫数</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-right">発注数</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-center">削除</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach(session('order_modify_info') as $item)
                        <tr id="{{ $item['item_id'] }}" class="text-sm h-14 hover:bg-teal-100">
                            <td class="p-1 px-2 border">{{ $item['item_code'] }}</td>
                            <td class="p-1 px-2 border">{{ $item['item_name'] }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format(GetAvailableStockQuantityFunc::GetAvailableStockQuantityFunc($item['item_id'])) }}</td>
                            <td class="p-1 px-2 border"><input type="tel" name="{{ 'order_quantity['.$item['item_id'].']' }}" class="order_quantity text-sm text-right rounded-lg w-full" autocomplete="off" value="{{ $item['quantity'] }}"></td>
                            <td class="p-1 px-2 border text-center"><button type="button" id="{{ $item['item_id'] }}" class="order_item_delete bg-red-500 text-white rounded-lg p-3"><i class="las la-trash la-lg"></i></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
    <!-- 配送店舗選択モーダル -->
    <div id="store_select_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-20 mx-auto shadow-lg rounded-md bg-white max-w-2xl">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4 id="modal_header">配送店舗選択画面</h4>
                <button class="store_select_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <div class="grid grid-cols-12 gap-2">
                    <label for="store_search" class="col-span-3">店舗検索</label><br>
                    <input type="text" id="store_search" class="col-span-9 mb-5 rounded-lg text-sm" autocomplete="off"><br>
                    <button type="button" id="store_search_enter" class="col-span-2 mb-5 bg-black rounded-lg text-center text-white text-sm">検索</button>
                    <label for="store_select" class="col-span-3">店舗名</label><br>
                    <select id="store_select" class="col-span-9 rounded-lg text-sm w-full">
                        @foreach($stores as $store)
                            <option value="{{ $store->store_id }}">{{ $store->store_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <a id="store_select_enter" class="cursor-pointer rounded-lg bg-blue-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    選択
                </a>
                <a class="store_select_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>