<div class="mx-5 mb-2">
    @if(session('alert_success'))
        <div id="alert_success" class="bg-blue-100 border border-blue-500 text-blue-700 px-4 py-3 rounded mt-5">
            <p class="text-xs xl:text-sm"><i class="las la-check-circle"></i>{!! nl2br(e(session('alert_success'))) !!}</p>
        </div>
    @endif
    @if(session('alert_danger'))
        <div id="alert_danger" class="bg-red-200 border border-red-500 text-red-700 px-4 py-3 rounded mt-5">
            <p class="text-xs xl:text-sm"><i class="las la-exclamation-triangle"></i>{!! nl2br(e(session('alert_danger'))) !!}</p>
        </div>
    @endif
    @if(session('allocate_stock_ng_info'))
        <div id="allocate_stock_ng_info" class="bg-red-200 border border-red-500 text-red-700 px-4 py-3 rounded mt-5">
            <p class="text-xs xl:text-sm">在庫引当できない商品があります。(有効在庫数 → 発注数)</p>
            @foreach(session('allocate_stock_ng_info') as $error)
                <p class="text-xs xl:text-sm"><i class="las la-exclamation-triangle"></i>{{ $error['item_name'].'('.$error['quantity'].' → '.$error['available_stock_quantity'].')' }}</p>
            @endforeach
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-200 border border-red-500 text-red-700 px-4 py-3 rounded mt-5">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-xs xl:text-sm"><i class="las la-exclamation-triangle"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>