<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
    <a class="navbar-brand" href="/">Binary pool</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            @if(Auth::check())
                <li class="nav-item @if(Route::currentRouteName() == 'sources_list') active @endif">
                    <a class="nav-link" href="{{ route('sources_list', ['search_mode' => 'source']) }}">Статистика источников</a>
                </li>
            @endif
        </ul>
    </div>
</nav>