<nav class="navbar navbar-expand-lg darkness mb-5">
    <a class="navbar-brand" href="/">
        <img src="{{ asset('binary-pool-no-fon.png') }}" alt="Binary Pool">
        Binary Pool
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sources_list', ['search_mode' => 'source']) }}">Статистика
                    источников</a>
            </li>
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('my_access') }}">Мои подписки</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile', ['user_id' => Auth::user()->id]) }}">Мой профиль</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('profile', ['user_id' => Auth::user()->id, 'mode' => 'my_balance']) }}">Мой
                        баланс</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="{{ route('profile', ['user_id' => Auth::user()->id, 'mode' => 'my_settings']) }}">Настройки</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/how_to_receive_signals') }}">Как получать сигналы?</a>
                </li>
            @endauth
        </ul>
        @auth
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Выход
                    </a>

                    <form id="logout-form" action="/logout" method="post" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        @else
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/login">Вход</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Регистрация</a>
                </li>
            </ul>
        @endauth
    </div>
</nav>