<script src="{{ asset('js/order_detail.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header" class="">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_1') }}" class="col-span-2 xl:col-span-1 rounded-lg bg-black text-white text-center py-3 text-xs xl:text-sm">戻る</a>
            <div class="col-span-4 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                発注詳細
            </div>
            <!-- ステータスとロールをチェックして、処理可能であればボタンを表示させる -->
            @if($order->order_status == '発注待ち' && Auth::user()->role_id <= '11')
                <a href="{{ route('order_modify.index', ['order_id' => $order->order_id]) }}" id="order_modify" class="col-start-7 xl:col-start-11 col-span-3 xl:col-span-1 rounded-lg text-center py-3 bg-orange-200 text-xs xl:text-sm">修正画面へ</a>
                <a href="{{ route('order.cancel', ['order_id' => $order->order_id]) }}" id="order_cancel" class="col-start-10 xl:col-start-12 col-span-3 xl:col-span-1 rounded-lg text-center py-3 bg-pink-200 text-xs xl:text-sm">キャンセル</a>
            @endif
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <form method="POST" action="{{ route('order_status_modify') }}" class="m-0 col-span-12 grid grid-cols-12">
            @csrf
            <p class="text-base xl:text-xl border-b-4 border-blue-500 col-span-12 xl:col-span-2 mb-3">ステータス変更</p>
            <div class="col-span-12 grid grid-cols-12 mb-3">
                <!-- ステータス条件 -->
                <label for="order_status" class="col-span-3 xl:col-span-1 text-xs xl:text-sm text-center py-4 xl:py-2 bg-black text-white">ステータス</label>
                <select id="order_status_select" name="order_status_select" class="col-span-5 xl:col-span-1 text-xs xl:text-sm">
                    @foreach(App\Consts\OrderStatusConsts::ORDER_STATUS_LIST_MODIFY_TARGET as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                <button type="submit" id="order_status_modify" class="col-span-3 xl:col-span-1 rounded-lg bg-blue-200 ml-5 text-xs xl:text-sm">変更</button>
                <input type="hidden" name="order_id" value="{{ $order->order_id }}">
            </div>
        </form>
        <div class="col-span-12 grid grid-cols-12 grid-rows-6 gap-4">
            <!-- 発注概要 -->
            <div class="row-span-6 col-span-12 xl:col-span-3 grid grid-cols-12 p-5 border border-black rounded-lg bg-emerald-100">
                <p class="col-span-12 text-sm">ステータス</p>
                <p class="col-span-12 text-base xl:text-3xl text-center">{{ $order->order_status }}</p>
            </div>
            <!-- 発注概要 -->
            <div class="row-span-6 col-span-12 xl:col-span-3 grid grid-cols-12 p-5 border border-black rounded-lg bg-emerald-100">
                <p class="col-span-12 text-sm mb-3 border-b-2 border-black">発注概要</p>
                <p class="col-span-4 text-sm">発注ID</p>
                <p class="col-span-8 text-sm">{{ $order->order_id }}</p>
                <p class="col-span-4 text-sm">発注者</p>
                <p class="col-span-8 text-sm">{{ $order->order_user_name }}</p>
                <p class="col-span-4 text-sm">発注日</p>
                <p class="col-span-8 text-sm">{{$order->order_date }}</p>
                <p class="col-span-4 text-sm">配送希望日</p>
                <p class="col-span-8 text-sm">{{$order->delivery_date }}</p>
                <p class="col-span-4 text-sm">配送希望時間</p>
                <p class="col-span-8 text-sm">{{$order->delivery_time }}</p>
            </div>
            <!-- 配送先 -->
            <div class="row-span-6 col-span-12 xl:col-span-3 grid grid-cols-12 p-5 border border-black rounded-lg bg-emerald-100">
                <p class="col-span-12 text-sm mb-3 border-b-2 border-black">配送先</p>
                <p class="col-span-12 text-sm">{{ $order->shipping_store_name }}</p>
                <p class="col-span-12 text-sm">{{ $order->shipping_store_zip_code }}</p>
                <p class="col-span-12 text-sm">{{ $order->shipping_store_address_1 }}</p>
                <p class="col-span-12 text-sm">{{ $order->shipping_store_address_2 }}</p>
                <p class="col-span-12 text-sm">{{ $order->shipping_store_tel_number }}</p>
                <p class="col-span-12 text-sm">{{ $order->store_pic }}</p>
            </div>
            <!-- 出荷情報 -->
            <div class="row-span-6 col-span-12 xl:col-span-3 grid grid-cols-12 p-5 border border-black rounded-lg bg-emerald-100">
                <p class="col-span-12 text-sm mb-3 border-b-2 border-black">出荷情報</p>
                <p class="col-span-4 text-sm">出荷日</p>
                <p class="col-span-8 text-sm">{{ $order->shipping_date }}</p>
                <p class="col-span-4 text-sm">配送伝票番号</p>
                <p class="col-span-8 text-sm">{{ $order->tracking_number }}</p>
                <p class="col-span-4 text-sm">出荷担当者</p>
                <p class="col-span-8 text-sm">{{$order->warehouse_pic_user_name }}</p>
            </div>
        </div>
        <!-- 発注商品一覧 -->
        <table class="col-start-1 col-span-12 mt-5">
            <thead>
                <tr class="text-sm text-left text-white bg-gray-600 border-gray-600">
                    <th class="font-thin p-2 px-2 w-10/12">商品名</th>
                    <th class="font-thin p-2 px-2 w-2/12 text-right">発注数</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($order_details as $order_detail)
                    <tr class="text-sm hover:bg-teal-100">
                        <td class="p-1 px-2 border">{{ $order_detail->order_item_name }}</td>
                        <td class="p-1 px-2 border text-right">{{ $order_detail->order_quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>