<header class="nav-header py-2">
    <div class="grid grid-cols-12">
        <div class="col-span-2">
            <input type="checkbox" class="menu-btn" id="menu-btn">
            <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
            <ul class="menu">
                <li><a href="{{ route('home.index') }}">ホーム</a></li>
                <!-- 倉庫以外のアカウントで発注機能表示 -->
                @if(Auth::user()->role_id != 21)
                    <li><a href="{{ route('order.index') }}">発注</a></li>
                @endif
                <li><a href="{{ route('order_list.index') }}">発注一覧</a></li>
                <li><a href="{{ route('stock.index') }}">在庫確認</a></li>
                <li><a href="{{ route('master.index') }}">マスタ</a></li>
                <li><a href="{{ route('stock_mgt.index') }}">在庫管理</a></li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">ログアウト</a></li>
                </form>
            </ul>
        </div>
        <p class="col-start-5 col-span-4 text-3xl text-center mt-3">発注システム</p>
        <p class="col-start-11 col-span-2 text-right text-base mr-3 mt-4">{{ Auth::user()->company.' / '.Auth::user()->name }}</p>

    </div>
</header>