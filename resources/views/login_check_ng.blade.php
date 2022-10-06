<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Order</title>

        <!-- favicon -->
        <link rel="shortcut icon" type="image/x-icon"  href="{{ asset('image/favicon.svg') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=DynaPuff&family=Kosugi+Maru&family=Lobster&display=swap" rel="stylesheet">
    
    </head>
    <body style="font-family:Kosugi Maru" class="bg-slate-100">
        <div class="min-h-screen">
            <div class="border-4 border-orange-400 my-5 mx-5 bg-orange-100">
                <p class="text-3xl py-10 text-center">
                    承認されたユーザーではありません。<br><br><br>
                    システム管理者に問い合わせをお願いします。
                </p>
                <div class="text-center py-5">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <input type="submit" class="bg-orange-400 text-white py-5 px-5 w-1/2 rounded-full hover:bg-gray-400 font-semibold cursor-pointer" value="TOPに戻る">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>