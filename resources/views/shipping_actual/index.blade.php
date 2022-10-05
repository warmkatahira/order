<x-app-layout>
    <x-slot name="header" class="">
        <div class="grid grid-cols-12 gap-4">
            <a href="{{ session('back_url_1') }}" class="col-span-2 xl:col-span-1 rounded-lg bg-black text-white text-center py-3 text-xs xl:text-sm">戻る</a>
            <div class="col-span-4 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                出荷実績
            </div>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <div class="col-span-12 xl:col-span-4 grid grid-cols-12">
            <p class="text-xs xl:text-sm col-span-12">出荷実績CSVを選択してください。</p>
            <form method="post" action="{{ route('shipping_actual.check') }}" enctype="multipart/form-data" class="col-span-12 grid grid-cols-12">
                @csrf
                <input type="file" name="shipping_actual_csv" class="text-xs xl:text-sm col-span-12 mt-5" required>
                <button type="submit" class="col-span-12 bg-blue-200 text-xs xl:text-sm rounded-lg py-2 mt-5">確認へ進む</button>
            </form>
        </div>
    </div>
</x-app-layout>