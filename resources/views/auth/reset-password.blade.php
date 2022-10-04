<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ route('welcome') }}">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="text-sm">メールアドレス</label>
                <input type="email" name="email" class="text-sm rounded-lg w-full block mt-1" value="{{ old('email', $request->email) }}" required autofocus>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="text-sm">パスワード</label>
                <input type="password" name="password" class="text-sm rounded-lg w-full block mt-1" autocomplete="off" required>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="text-sm">パスワード</label>
                <input type="password" name="password_confirmation" class="text-sm rounded-lg w-full block mt-1" autocomplete="off" required>
            </div>

            <div class="grid grid-cols-12 mt-4">
                <button class="col-span-12 bg-green-300 rounded-lg text-sm hover:bg-gray-400 py-8 px-5 font-semibold">リセット</button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
