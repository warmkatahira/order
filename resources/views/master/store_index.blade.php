<script src="{{ asset('js/store.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-4 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                店舗マスタ
            </div>
            <a href="{{ route('store.download') }}" class="col-start-7 xl:col-start-11 col-span-3 xl:col-span-1 rounded-lg text-center bg-orange-200 py-3 text-xs xl:text-sm">出力</a>
            <button type="button" id="store_register_modal_open" class="col-start-10 xl:col-start-12 col-span-3 xl:col-span-1 rounded-lg text-center bg-blue-200 text-xs xl:text-sm">登録</button>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <!-- 検索条件 -->
        <form method="GET" action="{{ route('store.search') }}" class="m-0 col-span-12 grid grid-cols-12">
            <p class="col-span-12 xl:col-span-2 text-base xl:text-xl border-b-4 border-blue-500 mb-3">検索条件</p>
            <div class="col-span-12 grid grid-cols-12 mb-3">
                <!-- 店舗名条件 -->
                <label for="search_store_name" class="col-span-5 xl:col-span-1 text-xs xl:text-sm text-center py-2 bg-black text-white">店舗名</label>
                <input type="text" id="search_store_name" name="search_store_name" class="col-span-7 xl:col-span-2 text-xs xl:text-sm" value="{{ session('search_store_name') }}" autocomplete="off">
                <!-- 店舗住所1条件 -->
                <label for="search_store_address_1" class="col-span-5 xl:col-span-1 text-xs xl:text-sm text-center py-2 bg-black text-white">店舗住所1</label>
                <input type="text" id="search_store_address_1" name="search_store_address_1" class="col-span-7 xl:col-span-2 text-xs xl:text-sm" value="{{ session('search_store_address_1') }}" autocomplete="off">
                <!-- 検索ボタン -->
                <button type="submit" class="col-start-1 xl:col-start-12 col-span-12 xl:col-span-1 py-2 xl:py-0 mt-2 xl:mt-0 rounded-lg bg-black text-white"><i class="las la-search la-lg"></i></button>
            </div>
        </form>
        <div class="col-span-12 grid grid-cols-12 overflow-x-auto">
            <table class="col-span-12 min-w-full">
                <thead>
                    <tr class="text-xs xl:text-sm text-left text-white bg-gray-600 border-gray-600 whitespace-nowrap">
                        <th class="font-thin p-2 px-2 w-2/12">店舗名</th>
                        <th class="font-thin p-2 px-2 w-1/12">店舗郵便番号</th>
                        <th class="font-thin p-2 px-2 w-4/12">店舗住所1</th>
                        <th class="font-thin p-2 px-2 w-3/12">店舗住所2</th>
                        <th class="font-thin p-2 px-2 w-1/12">店舗電話番号</th>
                        <th class="font-thin p-2 px-2 w-1/12 text-center">操作</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($stores as $store)
                        <tr class="text-xs xl:text-sm hover:bg-teal-100 whitespace-nowrap">
                            <td class="p-1 px-2 border" id="aaa">{{ $store->store_name }}</td>
                            <td class="p-1 px-2 border">{{ $store->store_zip_code }}</td>
                            <td class="p-1 px-2 border">{{ $store->store_address_1 }}</td>
                            <td class="p-1 px-2 border">{{ $store->store_address_2 }}</td>
                            <td class="p-1 px-2 border">{{ $store->store_tel_number }}</td>
                            <td class="p-1 px-2 border text-center">
                                <a id="{{ $store->store_id }}" class="store_modify cursor-pointer text-xs xl:text-sm bg-orange-200 rounded-lg text-center px-2 py-1">変更</a>
                                <a href="{{ route('store.delete', ['store_id' => $store->store_id]) }}" class="store_delete text-xs xl:text-sm bg-red-500 text-white rounded-lg text-center px-2 py-1">削除</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- ページネーション -->
        <div class="col-span-12 mt-3">
            {{ $stores->appends(request()->input())->links() }}
        </div>
    </div>
    <!-- 店舗登録モーダル -->
    <div id="store_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-20 mx-auto shadow-lg rounded-md bg-white max-w-2xl">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4 id="modal_header"></h4>
                <button class="store_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" id="store_register_form" action="{{ route('store.register_modify') }}" class="m-0">
                    @csrf
                    <label for="store_name" class="">店舗名<span class="text-xs bg-red-500 text-white text-center px-2 py-1 rounded-md ml-1">必須</span></label><br>
                    <input type="text" id="store_name" name="store_name" class="w-full mb-3" placeholder="店舗名" autocomplete="off"><br>
                    <label for="store_zip_code" class="">店舗郵便番号<span class="text-xs bg-red-500 text-white text-center px-2 py-1 rounded-md ml-1">必須</span></label><br>
                    <input type="text" id="store_zip_code" name="store_zip_code" class="w-1/2 mb-3" placeholder="店舗郵便番号" autocomplete="off"><br>
                    <label for="store_address_1" class="">店舗住所1<span class="text-xs bg-red-500 text-white text-center px-2 py-1 rounded-md ml-1">必須</span></label><br>
                    <input type="text" id="store_address_1" name="store_address_1" class="w-full mb-3" placeholder="店舗住所1" autocomplete="off"><br>
                    <label for="store_address_2" class="">店舗住所2</label><br>
                    <input type="text" id="store_address_2" name="store_address_2" class="w-full mb-3" placeholder="店舗住所2" autocomplete="off"><br>
                    <label for="store_tel_number" class="">店舗電話番号<span class="text-xs bg-red-500 text-white text-center px-2 py-1 rounded-md ml-1">必須</span></label><br>
                    <input type="text" id="store_tel_number" name="store_tel_number" class="w-1/2 mb-3" placeholder="店舗電話番号" autocomplete="off"><br>
                    <input type="hidden" id="operation_type" name="operation_type">
                    <input type="hidden" id="store_id" name="store_id">
                </form>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <a id="store_register_enter" class="cursor-pointer rounded-lg bg-blue-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    登録
                </a>
                <a class="store_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>