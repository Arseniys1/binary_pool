@extends('layouts.app')

@section('content')
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @else
            <h4>Профиль {{ $user->name }}</h4>
            <ul class="list-inline">
                <li class="list-inline-item"><a
                            href="{{ route('profile', ['user_id' => $user->id, 'mode' => 'fast_stat']) }}">Статистика
                        пользователя</a></li>
                <li class="list-inline-item"><a
                            href="{{ route('profile', ['user_id' => $user->id, 'mode' => 'listeners']) }}">Слушатели
                        пользователя</a></li>
            </ul>

            <div class="row mb-5">
                @if(Request::route('mode') == 'fast_stat' || Request::route('mode') == null)
                    @if($fast_stat->count() > 0)
                        @foreach($fast_stat as $stat)
                            <div class="card col-md-4">
                                <div class="card-body">
                                    @if($stat->account_mode == 1)
                                        <h5 class="card-title">Статистика источника</h5>
                                    @elseif($stat->account_mode == 0)
                                        <h5 class="card-title">Статистика слушателя</h5>
                                    @elseif($stat->account_mode == 2)
                                        <h5 class="card-title">Статистика демо источника</h5>
                                    @elseif($stat->account_mode == 3)
                                        <h5 class="card-title">Статистика демо слушателя</h5>
                                    @endif

                                    <ul class="list-unstyled">
                                        <li class="text-success">Успешные {{ $stat->success_count }}</li>
                                        <li class="text-danger">Проигрышные {{ $stat->loss_count }}</li>
                                        <li class="text-dark">Возвраты {{ $stat->ret_count }}</li>
                                        <li class="text-success">Заработал {{ $stat->win_sum / 100 }}</li>
                                        <li class="text-danger">Проиграл {{ $stat->loss_sum / 100 }}</li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach

                        {{ $fast_stat->links('vendor.pagination.bootstrap-4') }}
                    @else
                        <div class="text-center w-100">Статистика не найдена</div>
                    @endif
                @elseif(Request::route('mode') == 'listeners')
                    @if($notify_access->count() > 0)
                        @foreach($notify_access as $notify)
                            <div class="card col-md-4">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $notify->user->name }}</h5>

                                    @foreach($notify->user->fastStat as $stat)
                                        <ul class="list-unstyled mb-2">
                                            @if($stat->account_mode == 1)
                                                <li class="text-info">Статистика источника</li>
                                            @elseif($stat->account_mode == 0)
                                                <li class="text-info">Статистика слушателя</li>
                                            @elseif($stat->account_mode == 2)
                                                <li class="text-info">Статистика демо источника</li>
                                            @elseif($stat->account_mode == 3)
                                                <li class="text-info">Статистика демо слушателя</li>
                                            @endif

                                            <li class="text-success">Успешные {{ $stat->success_count }}</li>
                                            <li class="text-danger">Проигрышные {{ $stat->loss_count }}</li>
                                            <li class="text-dark">Возвраты {{ $stat->ret_count }}</li>
                                            <li class="text-success">Заработал {{ $stat->win_sum / 100 }}</li>
                                            <li class="text-danger">Проиграл {{ $stat->loss_sum / 100 }}</li>
                                        </ul>
                                    @endforeach

                                    <a href="{{ route('profile', ['user_id' => $stat->user->id]) }}" class="card-link">В
                                        профиль</a>
                                </div>
                            </div>
                        @endforeach

                        {{ $notify_access->links('vendor.pagination.bootstrap-4') }}
                    @else
                        <div class="text-center w-100">Пользователи не найдены</div>
                    @endif
                @endif
            </div>
        @endif
    </div>
@stop