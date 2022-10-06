<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                システム管理者メニュー
            </div>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12 gap-4">
        <a href="{{ route('admin.user_index') }}" class="col-span-5 xl:col-span-2 py-3 text-base xl:text-2xl rounded-lg text-center bg-blue-200">ユーザーマスタ</a>
    </div>
</x-app-layout>