@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Статистика источников</h4>
        <ul class="list-inline">
            <li class="list-inline-item">Показать</li>
            <li class="list-inline-item"><a href="{{ route('sources_list', ['search_mode' => 'source']) }}">Реальный счет</a></li>
            <li class="list-inline-item"><a href="{{ route('sources_list', ['search_mode' => 'source_demo']) }}">Демо счет</a></li>
        </ul>

        <div class="row mb-5">
            @if($fast_stat != null && $fast_stat->count() > 0)
                @foreach($fast_stat as $stat)
                    @if($stat->user != null)
                        <div class="card col-md-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $stat->user->name }}</h5>
                                <ul class="list-unstyled">
                                    <li class="text-success">Успешные {{ $stat->success_count }}</li>
                                    <li class="text-danger">Проигрышные {{ $stat->loss_count }}</li>
                                    <li class="text-dark">Возвраты {{ $stat->ret_count }}</li>
                                    <li class="text-success">Заработал {{ $stat->win_sum / 100 }}</li>
                                    <li class="text-danger">Проиграл {{ $stat->loss_sum / 100 }}</li>
                                </ul>
                                @foreach($stat->user->settings as $setting)
                                    @if($setting->name == 'price')
                                        <a href="#" class="card-link">Оповещения {{ $setting->value / 100 }} рублей</a>
                                    @endif
                                @endforeach
                                <a href="{{ route('profile', ['user_id' => $stat->user->id]) }}" class="card-link">В профиль</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{ $fast_stat->links('vendor.pagination.bootstrap-4') }}
        @else
            <div class="text-center w-100">Статистика не найдена</div>
        @endif
    </div>
@stop