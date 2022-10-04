<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ route('welcome') }}">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="text-sm">氏名</label>
                <input type="text" name="name" class="text-sm rounded-lg w-full block mt-1" value="{{ old('name') }}" required autofocus>
            </div>

            <!-- Company -->
            <div class="mt-4">
                <label for="company" class="text-sm">会社名</label>
                <input type="text" name="company" class="text-sm rounded-lg w-full block mt-1" value="{{ old('company') }}" required autofocus>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email" class="text-sm">メールアドレス</label>
                <input type="email" name="email" class="text-sm rounded-lg w-full block mt-1" value="{{ old('email') }}" required>
            </div>

            <!-- Role -->
            <div class="mt-4">
                <label for="role" class="text-sm">アカウント</label>
                <select name="role" class="text-sm rounded-lg w-full block mt-1">
                    @foreach($roles as $role)
                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="text-sm">パスワード</label>
                <input type="password" name="password" class="text-sm rounded-lg w-full block mt-1" autocomplete="off" required>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="text-sm">パスワード(確認)</label>
                <input type="password" name="password_confirmation" class="text-sm rounded-lg w-full block mt-1" autocomplete="off" required>
            </div>

            <div class="grid grid-cols-12 mt-4">
                <button class="col-span-12 bg-green-300 rounded-lg text-sm hover:bg-gray-400 py-8 px-5 font-semibold">ユーザー登録</button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
