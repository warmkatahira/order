<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                ホーム
            </div>
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12 gap-4">
        <div class="col-span-2 bg-sky-100 shadow-lg rounded-lg text-center py-5">
            <p class="">出荷待ち</p>
            <p class="text-2xl pt-5">{{ number_format($syukka_machi_cnt) }}</p>
        </div>
        <div class="col-span-2 bg-sky-100 shadow-lg rounded-lg text-center py-5">
            <p class="">出荷作業中</p>
            <p class="text-2xl pt-5">{{ number_format($syukka_sagyou_cnt) }}</p>
        </div>
        <div class="col-span-2 bg-sky-100 shadow-lg rounded-lg text-center py-5">
            <p class="">今月出荷済み</p>
            <p class="text-2xl pt-5">{{ number_format($current_month_shipping_cnt) }}</p>
        </div>
    </div>
</x-app-layout>