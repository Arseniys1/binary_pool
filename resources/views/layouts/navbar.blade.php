<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
    <a class="navbar-brand" href="/">Binary pool</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sources_list', ['search_mode' => 'source']) }}">Статистика источников</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile', ['user_id' => Auth::user()->id]) }}">Мой профиль</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile', ['user_id' => Auth::user()->id, 'mode' => 'my_balance']) }}">Мой баланс</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile', ['user_id' => Auth::user()->id, 'mode' => 'my_settings']) }}">Настройки</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ext') }}">Расширение</a>
                </li>
            @endauth
        </ul>
        @auth
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