<script src="{{ asset('js/stock_mgt.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_1') }}" class="col-span-1 rounded-lg bg-black text-white text-center py-2">戻る</a>
            <div class="inline-block col-span-2 text-xl text-gray-800 p-2">
                在庫計上履歴
            </div>
            <a href="{{ route('stock_history_data_download') }}" class="col-start-12 col-span-1 rounded-lg text-center bg-blue-200 py-2">履歴出力</a>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <!-- 検索条件 -->
        <form method="GET" action="{{ route('stock_history_list.search') }}" class="m-0 col-span-12 grid grid-cols-12">
            <p class="text-xl border-b-4 border-blue-500 col-span-2 mb-3">検索条件</p>
            <div class="col-span-12 grid grid-cols-12 mb-3">
                <!-- 計上日条件 -->
                <label class="col-span-1 text-sm text-center py-2 bg-black text-white">計上日</label>
                <input type="date" id="operation_date_from" name="operation_date_from" class="text-xs col-span-1" value="{{ session('operation_date_from') }}">
                <p class="col-span-1 text-sm text-center py-2">～</p>
                <input type="date" id="operation_date_to" name="operation_date_to" class="text-xs col-span-1" value="{{ session('operation_date_to') }}">
                <button type="submit" class="col-start-12 col-span-1 rounded-lg bg-black text-white"><i class="las la-search la-lg"></i></button>
            </div>
        </form>
        <table class="col-span-12">
            <thead>
                <tr class="text-sm text-left text-white bg-gray-600 border-gray-600">
                    <th class="font-thin p-2 px-2 w-1/12">在庫計上ID</th>
                    <th class="font-thin p-2 px-2 w-1/12">計上日</th>
                    <th class="font-thin p-2 px-2 w-1/12">計上者</th>
                    <th class="font-thin p-2 px-2 w-8/12">コメント</th>
                    <th class="font-thin p-2 px-2 w-1/12 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($stock_histories as $stock_history)
                    <tr class="text-sm hover:bg-teal-100">
                        <td class="p-1 px-2 border">{{ $stock_history->stock_history_id }}</td>
                        <td class="p-1 px-2 border">{{ $stock_history->operation_date }}</td>
                        <td class="p-1 px-2 border">{{ $stock_history->operation_user_name }}</td>
                        <td class="p-1 px-2 border">{{ $stock_history->operation_comment }}</td>
                        <td class="p-1 px-2 border text-center">
                            <a href="{{ route('stock_history_list.detail', ['stock_history_id' => $stock_history->stock_history_id]) }}" class="rounded-lg bg-orange-200 text-sm text-center py-1 px-2">詳細</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>