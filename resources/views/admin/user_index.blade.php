<script src="{{ asset('js/admin.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-7 xl:col-span-2 font-semibold text-base xl:text-xl text-gray-800 p-2">
                ユーザーマスタ
            </div>
            <button type="button" id="user_save" class="col-start-10 xl:col-start-12 col-span-3 xl:col-span-1 rounded-lg text-center bg-blue-200 text-xs xl:text-sm">保存</button>
        </div>
    </x-slot>
    <div class="py-3 px-4 grid grid-cols-12">
        <div class="col-span-12 grid grid-cols-12 overflow-x-auto">
            <form method="post" action="{{ route('admin.user_save') }}" id="user_form" class="m-0 col-span-12 grid grid-cols-12">
                @csrf
                <table class="col-span-8 min-w-full">
                    <thead>
                        <tr class="text-xs xl:text-sm text-left text-white bg-gray-600 border-gray-600 whitespace-nowrap">
                            <th class="font-thin p-2 px-2 w-2/12">氏名</th>
                            <th class="font-thin p-2 px-2 w-3/12">会社名</th>
                            <th class="font-thin p-2 px-2 w-3/12">メールアドレス</th>
                            <th class="font-thin p-2 px-2 w-2/12 text-center">権限</th>
                            <th class="font-thin p-2 px-2 w-2/12 text-center">ステータス</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($users as $user)
                            <tr class="text-xs xl:text-sm hover:bg-teal-100 whitespace-nowrap">
                                <td class="p-1 px-2 border">
                                    <input type="text" name="name[]" class="text-xs xl:text-sm rounded-lg xl:w-full" value="{{ $user->name }}" autocomplete="off">
                                </td>
                                <td class="p-1 px-2 border">
                                    <input type="text" name="company[]" class="text-xs xl:text-sm rounded-lg xl:w-full" value="{{ $user->company }}" autocomplete="off">
                                </td>
                                <td class="p-1 px-2 border">
                                    <input type="email" name="email[]" class="text-xs xl:text-sm rounded-lg xl:w-full" value="{{ $user->email }}" autocomplete="off">
                                </td>
                                <td class="p-1 px-2 border text-center">
                                    <select name="role_id[]" class="text-xs xl:text-sm rounded-lg">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->role_id }}" {{ $user->role_id == $role->role_id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-1 px-2 border text-center">
                                    <select name="status[]" class="text-xs xl:text-sm rounded-lg">
                                        <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>無効</option>
                                        <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>有効</option>
                                    </select>
                                </td>
                            </tr>
                            <input type="hidden" name="id[]" value="{{ $user->id }}">
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</x-app-layout>