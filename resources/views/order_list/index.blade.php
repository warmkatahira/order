<script src="{{ asset('js/order.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header" class="">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-4 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                発注一覧
            </div>
            <a href="{{ route('shipping_data_download') }}" class="col-start-7 xl:col-start-11 col-span-3 xl:col-span-1 text-xs xl:text-sm text-center bg-orange-200 rounded-lg py-3">出荷データDL</a>
            <a href="{{ route('shipping_actual.index') }}" class="col-start-10 xl:col-start-12 col-span-3 xl:col-span-1 text-xs xl:text-sm text-center bg-orange-200 rounded-lg py-3">出荷実績</a>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <!-- 検索条件 -->
        <form method="GET" action="{{ route('order_list.search') }}" class="m-0 col-span-12 grid grid-cols-12">
            <p class="text-base xl:text-xl border-b-4 border-blue-500 col-span-12 xl:col-span-2 mb-3">検索条件</p>
            <div class="col-span-12 grid grid-cols-12 mb-3">
                <!-- 発注日条件 -->
                <label for="order_date" class="col-span-3 xl:col-span-1 text-xs xl:text-sm text-center py-3 bg-black text-white">発注日</label>
                <input type="date" id="order_date_from" name="order_date_from" class="text-xs xl:text-xs col-span-4 xl:col-span-1" value="{{ session('order_date_from') }}">
                <p class="col-span-1 text-xs xl:text-sm text-center py-3">～</p>
                <input type="date" id="order_date_to" name="order_date_to" class="text-xs xl:text-xs col-span-4 xl:col-span-1" value="{{ session('order_date_to') }}">
                <!-- ステータス条件 -->
                <label for="order_status" class="col-start-1 xl:col-start-6 col-span-3 xl:col-span-1 text-xs xl:text-sm text-center py-3 bg-black text-white">ステータス</label>
                <select id="order_status" name="order_status" class="col-span-4 xl:col-span-1 text-xs xl:text-sm">
                    <option></option>
                    @foreach(App\Consts\OrderStatusConsts::ORDER_STATUS_LIST_ALL as $key => $value)
                        <option value="{{ $key }}" {{ session('order_status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                <button type="submit" class="col-start-1 xl:col-start-12 col-span-12 xl:col-span-1 rounded-lg bg-black text-white py-2 xl:py-0 mt-2 xl:mt-0 "><i class="las la-search la-lg"></i></button>
            </div>
        </form>
        <div class="col-span-12 grid grid-cols-12 overflow-x-auto">
            <table class="col-span-12 min-w-full">
                <thead>
                    <tr class="text-xs xl:text-sm text-left text-white bg-gray-600 border-gray-600 whitespace-nowrap">
                        <th class="font-thin p-2 px-2 w-1/12">発注ID</th>
                        <th class="font-thin p-2 px-2 w-1/12">発注者</th>
                        <th class="font-thin p-2 px-2 w-1/12">発注日</th>
                        <th class="font-thin p-2 px-2 w-1/12">配送希望日</th>
                        <th class="font-thin p-2 px-2 w-5/12">店舗名</th>
                        <th class="font-thin p-2 px-2 w-1/12">ステータス</th>
                        <th class="font-thin p-2 px-2 w-2/12 text-center">操作</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($orders as $order)
                        <tr class="text-xs xl:text-sm hover:bg-teal-100 whitespace-nowrap">
                            <td class="p-1 px-2 border">{{ $order->order_id }}</td>
                            <td class="p-1 px-2 border">{{ $order->order_user_name }}</td>
                            <td class="p-1 px-2 border">{{ $order->order_date }}</td>
                            <td class="p-1 px-2 border">{{ $order->delivery_date }}</td>
                            <td class="p-1 px-2 border">{{ $order->shipping_store_name }}</td>
                            <td class="p-1 px-2 border">{{ $order->order_status }}</td>
                            <td class="p-1 px-2 border text-center">
                                <a href="{{ route('order_detail.index', ['order_id' => $order->order_id]) }}" class="rounded-lg bg-orange-200 text-xs xl:text-sm text-center py-1 px-2">詳細</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>