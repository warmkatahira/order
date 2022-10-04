<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ route('welcome') }}">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="text-sm">メールアドレス</label>
                <input type="email" name="email" class="text-sm rounded-lg w-full block mt-1" value="{{ old('email') }}" required autofocus>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="text-sm">パスワード</label>
                <input type="password" name="password" class="text-sm rounded-lg w-full block mt-1" autocomplete="off" required>
            </div>

            <div class="grid grid-cols-12 mt-4">
                <a href="{{ route('password.request') }}" class="col-span-12 text-center bg-pink-200 text-black rounded-lg text-sm hover:bg-gray-400 hover:text-white py-2 px-5 font-semibold">パスワードを忘れた方はこちら</a>
                <button class="col-span-12 bg-green-300 rounded-lg text-sm hover:bg-gray-400 py-8 px-5 mt-5 font-semibold">ログイン</button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
