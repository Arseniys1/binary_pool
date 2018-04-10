@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Статистика источников</h3>

        <div class="filter text-right mt-5 mb-5">
            <ul class="list-inline">
                <li class="list-inline-item">Статистика на</li>
                <li class="list-inline-item"><a href="{{ route('sources_list', ['search_mode' => 'source']) }}">Реальном
                        счете</a></li>
                <li class="list-inline-item"><a href="{{ route('sources_list', ['search_mode' => 'source_demo']) }}">Демо
                        счете</a></li>
            </ul>
        </div>

        <div class="items mb-5">
            @if($fast_stat != null && $fast_stat->count() > 0)
                @foreach($fast_stat as $stat)
                    @if($stat->user != null)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $stat->user->name }}</h5>
                                <ul class="list-unstyled">
                                    <li class="text-success">Успешные сделки {{ $stat->success_count }}</li>
                                    <li class="text-danger">Проигрышные сделки {{ $stat->loss_count }}</li>
                                    <li class="">Возвраты {{ $stat->ret_count }}</li>
                                    <li class="">Продажи {{ $stat->cancel_count }}</li>
                                    <li class="text-success">Заработал {{ $stat->win_sum / 100 }}</li>
                                    <li class="text-danger">Проиграл {{ $stat->loss_sum / 100 }}</li>
                                </ul>
                                @foreach($stat->user->settings as $setting)
                                    @if($setting->name == 'price')
                                        <a href="#" class="card-link">Оповещения {{ $setting->value / 100 }}
                                            рублей</a>
                                    @endif
                                @endforeach
                                <a href="{{ route('profile', ['user_id' => $stat->user->id]) }}" class="card-link">В
                                    профиль</a>
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