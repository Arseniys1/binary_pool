@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Источники оповещений</h3>

        <div class="filter text-right mt-5 mb-5">
            <ul class="list-inline">
                <li class="list-inline-item">Отображать статистику на</li>
                @if(Request::route('search_mode') == 'source' || Request::route('search_mode') == null)
                    <li class="list-inline-item"><a href="{{ route('sources_list', ['search_mode' => 'source']) }}"
                                                    class="disabled">Реальном
                            счете</a></li>
                @else
                    <li class="list-inline-item"><a href="{{ route('sources_list', ['search_mode' => 'source']) }}">Реальном
                            счете</a></li>
                @endif

                @if(Request::route('search_mode') == 'source_demo')
                    <li class="list-inline-item"><a href="{{ route('sources_list', ['search_mode' => 'source_demo']) }}"
                                                    class="disabled">Демо
                            счете</a></li>
                @else
                    <li class="list-inline-item"><a
                                href="{{ route('sources_list', ['search_mode' => 'source_demo']) }}">Демо
                            счете</a></li>
                @endif
            </ul>
        </div>

        <div class="items mb-5">
            @if($fast_stat != null && $fast_stat->count() > 0)
                <div class="row">
                    @foreach($fast_stat as $stat)
                        @if($stat->user != null)
                            <div class="col-md-4 mb-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $stat->user->name }}</h5>

                                        <h6>Статистика</h6>
                                        <ul class="list-unstyled">
                                            <li class="text-success">Успешные сделки {{ $stat->success_count }}</li>
                                            <li class="text-danger">Проигрышные сделки {{ $stat->loss_count }}</li>
                                            <li class="">Возвраты {{ $stat->ret_count }}</li>
                                            <li class="">Продажи {{ $stat->cancel_count }}</li>
                                            <li class="text-success">Заработал {{ $stat->win_sum / 100 }}</li>
                                            <li class="text-danger">Проиграл {{ $stat->loss_sum / 100 }}</li>
                                        </ul>

                                        @if($stat->user->settingsList()['price'] != null)
                                            <h6>Подписка</h6>
                                            <ul class="list-unstyled">
                                                <li>Стоимость
                                                    оповещений: <b>{{ $stat->user->settingsList()['price'] / 100 }}</b>
                                                    рублей
                                                </li>
                                                @if($stat->user->settingsList()['forever'])
                                                    <li>Тип подписки: Перманентная</li>
                                                @else
                                                    <li>Тип подписки: Истекаемая</li>
                                                    <li>Количество дней: {{ $stat->user->settingsList()['days'] }}</li>
                                                @endif
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        @if($stat->user->settingsList()['price'] != null)
                                            <a href="{{ route('subscribe', ['user_id' => $stat->user->id]) }}"
                                               class="card-link">Купить оповещения</a>
                                        @endif

                                        @if(count($stat->user->notifyAccessPresets()
                                        ->where('source_id', '=', $stat->user->id)
                                        ->where('status', '=', \App\Models\NotifyAccessPreset::ACTIVE_STATUS)
                                        ->get()) > 0)
                                            <a href="{{ route('access.demo', ['user_id' => $stat->user->id]) }}"
                                               class="card-link">Демо доступ</a>
                                        @endif

                                        @auth
                                            <a href="{{ route('profile', ['user_id' => $stat->user->id]) }}"
                                               class="card-link">В
                                                профиль</a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
        </div>

        {{ $fast_stat->links('vendor.pagination.bootstrap-4') }}
        @else
            <div class="text-center w-100">Статистика не найдена</div>
        @endif
    </div>
@stop