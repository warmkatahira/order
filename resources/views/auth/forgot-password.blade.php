<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            パスワードを忘れた場合は、以下のパスワードリセット用のURLを使用してパスワードを変更して下さい。
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="text-sm">メールアドレス</label>
                <input type="email" name="email" class="text-sm rounded-lg w-full block mt-1" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="grid grid-cols-12 mt-4">
                <button class="col-span-12 bg-black text-white rounded-lg text-sm hover:bg-gray-400 font-semibold py-1">リセットURLを送る</button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
