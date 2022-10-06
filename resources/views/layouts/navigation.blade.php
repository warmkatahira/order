<header class="nav-header py-2">
    <div class="grid grid-cols-12">
        <div class="col-span-2">
            <input type="checkbox" class="menu-btn" id="menu-btn">
            <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
            <ul class="menu z-10">
                <li><a href="{{ route('home.index') }}">ホーム</a></li>
                <!-- 倉庫以外のアカウントで発注機能表示 -->
                @can('order-higher')
                    <li><a href="{{ route('order.index') }}">発注</a></li>
                @endcan
                <li><a href="{{ route('order_list.index') }}">発注一覧</a></li>
                <li><a href="{{ route('stock.index') }}">在庫確認</a></li>
                <li><a href="{{ route('master.index') }}">マスタ</a></li>
                <li><a href="{{ route('stock_mgt.index') }}">在庫管理</a></li>
                <!-- システム管理者のアカウントのみ表示 -->
                @can('admin-only')
                    <li><a href="{{ route('admin.index') }}">システム管理</a></li>
                @endcan
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">ログアウト</a></li>
                </form>
            </ul>
        </div>
        <p class="col-start-3 xl:col-start-5 col-span-4 text-3xl xl:text-5xl text-left xl:text-center py-2 xl:py-1" style="font-family:Lobster;">Order</p>
        <p class="col-start-7 xl:col-start-11 col-span-6 xl:col-span-2 text-right text-xs xl:text-base mr-3 py-5 xl:py-3">{{ Auth::user()->company.' / '.Auth::user()->name }}</p>
    </div>
</header>