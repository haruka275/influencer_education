<header class="admin-header">
    
    <nav>
        <ul  class="admin-header-nav">
            <li class="nav-btn"><a href="{{ route('admin.show.curriculum.list') }}">授業管理</a></li>
            <li class="nav-btn admin-article-li"><a href="{{ route('admin.show.article.list')}}">お知らせ管理</a></li>
            <li class="nav-btn admin-banner-li"><a href="{{ route('admin.show.banner.edit') }}">バナー管理</a></li>

            @auth('admin')   
                {{-- デフォルトのwebガードを使って判定してしまうので指定 --}}
                {{-- ユーザーがログイン（認証済み）の場合のみ、内部のコードを表示。 --}}
                <li class="nav-auth">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit">ログアウト</button>
                    </form>
                </li>
            @endauth


            @guest('admin') {{-- 認証されていない（ログインしていない）場合に表示。 --}}
                <li class="nav-auth">
                    <a href="{{ route('admin.show.login') }}">ログイン</a></li>
            @endguest {{-- 条件分岐の終わり。 --}}
        </ul>
    </nav>
</header>
