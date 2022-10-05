<x-app-layout>
    <x-slot name="header" class="">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_2') }}" class="col-span-2 xl:col-span-1 rounded-lg bg-black text-white text-center py-3 text-xs xl:text-sm">戻る</a>
            <div class="col-span-4 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                出荷実績確認
            </div>
            <a href="{{ route('shipping_actual.upload') }}" class="col-start-10 xl:col-start-12 col-span-3 xl:col-span-1 text-xs xl:text-sm text-center bg-blue-200 rounded-lg py-3">アップロード</a>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <p class="col-span-12 text-xs xl:text-sm">以下の出荷実績をアップロードして問題ありませんか？</p>
        <p class="col-span-12 text-xs xl:text-sm">アップロード件数<i class="las la-angle-double-right mx-1"></i>{{ count($imports) }}</p>
        <table class="col-span-12 xl:col-span-4 mt-5">
            <thead>
                <tr class="text-xs xl:text-sm text-left text-white bg-gray-600 border-gray-600">
                    <th class="font-thin p-2 px-2 w-4/12">発注ID</th>
                    <th class="font-thin p-2 px-2 w-4/12">出荷日</th>
                    <th class="font-thin p-2 px-2 w-4/12">配送伝票番号</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($imports as $import)
                    <tr class="text-xs xl:text-sm hover:bg-teal-100">
                        <td class="p-1 px-2 border">{{ $import['order_id'] }}</td>
                        <td class="p-1 px-2 border">{{ $import['shipping_date'] }}</td>
                        <td class="p-1 px-2 border">{{ $import['tracking_number'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>