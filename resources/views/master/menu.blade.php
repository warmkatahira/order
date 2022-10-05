<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                マスタメニュー
            </div>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12 gap-4">
        <a href="{{ route('item.index') }}" class="col-span-5 xl:col-span-2 py-3 text-base xl:text-2xl rounded-lg text-center bg-blue-200">商品マスタ</a>
        <a href="{{ route('store.index') }}" class="col-span-5 xl:col-span-2 py-3 text-base xl:text-2xl rounded-lg text-center bg-blue-200">店舗マスタ</a>
    </div>
</x-app-layout>