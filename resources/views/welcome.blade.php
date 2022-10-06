<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Order</title>
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
 
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- LINE AWESOME -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=DynaPuff&family=Kosugi+Maru&family=Lobster&display=swap" rel="stylesheet">

        <!-- Lordicon -->
        <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>

        <!-- favicon -->
        <link rel="shortcut icon" href="{{ asset('image/favicon.svg') }}">

    </head>
    <body style="font-family:Kosugi Maru" class="bg-gray-100">
        <div class="grid grid-cols-12 gap-4">
            <p class="col-span-12 text-2xl xl:text-4xl text-center pt-2">発注システム</p>
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('home.index') }}" class="col-start-5 col-span-4 bg-black text-white text-sm text-center py-10 rounded-lg mt-10">ホーム</a>
                @else
                    <a href="{{ route('login') }}" class="col-start-2 xl:col-start-3 col-span-10 xl:col-span-3 bg-black text-white text-sm text-center py-10 rounded-lg mt-10">ログイン</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="col-start-2 xl:col-start-8 col-span-10 xl:col-span-3 bg-black text-white text-sm text-center py-10 rounded-lg mt-10">ユーザー登録</a>
                    @endif
                @endauth
            @endif
        </div>
    </body>
</html>
