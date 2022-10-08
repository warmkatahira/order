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

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=DynaPuff&family=Kosugi+Maru&family=Lobster&display=swap" rel="stylesheet">

        <!-- favicon -->
        <link rel="shortcut icon" href="{{ asset('image/favicon.svg') }}">

    </head>
    <body style="font-family:Kosugi Maru">
        <div class="text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
