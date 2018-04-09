@extends('layouts.app')

@section('content')
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach

            <a href="{{ url()->previous() }}">Назад</a>
        @else
            <h4>Профиль {{ $user->name }}</h4>
            <ul class="list-inline">
                <li class="list-inline-item"><a
                            href="{{ route('profile', ['user_id' => $user->id, 'mode' => 'fast_stat']) }}">Статистика
                        пользователя</a></li>
                <li class="list-inline-item"><a
                            href="{{ route('profile', ['user_id' => $user->id, 'mode' => 'listeners']) }}">Слушатели
                        пользователя</a></li>
                @if(Auth::user()->id == Request::route('user_id'))
                    <li class="list-inline-item"><a
                                href="{{ route('profile', ['user_id' => $user->id, 'mode' => 'my_stat']) }}">Мои
                            сделки</a>
                    </li>

                    <li class="list-inline-item"><a
                                href="{{ route('profile', ['user_id' => $user->id, 'mode' => 'my_balance']) }}">Мой
                            баланс</a>
                    </li>

                    <li class="list-inline-item"><a
                                href="{{ route('profile', ['user_id' => $user->id, 'mode' => 'my_settings']) }}">Мои
                            настройки</a>
                    </li>
                @endif
            </ul>

            @if(Request::route('mode') == 'fast_stat' || Request::route('mode') == null)
                @if($fast_stat->count() > 0)
                    <div class="row mb-5">
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
                    </div>

                    {{ $fast_stat->links('vendor.pagination.bootstrap-4') }}
                @else
                    <div class="text-center w-100">Статистика не найдена</div>
                @endif
            @elseif(Request::route('mode') == 'listeners')
                @if($notify_access->count() > 0)
                    <div class="row mb-5">
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
                    </div>

                    {{ $notify_access->links('vendor.pagination.bootstrap-4') }}
                @else
                    <div class="text-center w-100">Пользователи не найдены</div>
                @endif
            @elseif(Request::route('mode') == 'my_stat')
                @if($user_stat != null && $user_stat->count() > 0)
                    <div class="row mb-5">
                        @foreach($user_stat as $stat)
                            <div class="card col-md-4">
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li>Id: {{ $stat->id }}</li>
                                        <li>Id в платформе: {{ $stat->platform_id }}</li>

                                        @if($stat->account_mode == 1)
                                            <li>Режим: Источник</li>
                                        @elseif($stat->account_mode == 0)
                                            <li>Режим: Слушатель</li>
                                        @elseif($stat->account_mode == 2)
                                            <li>Режим: Демо источник</li>
                                        @elseif($stat->account_mode == 3)
                                            <li>Режим: Демо слушатель</li>
                                        @endif

                                        @if($stat->direction == 1)
                                            <li>Up</li>
                                        @elseif($stat->direction == 0)
                                            <li>Down</li>
                                        @endif

                                        <li>Сумма: {{ $stat->sum / 100 }}</li>

                                        @if($stat->status == 1)
                                            <li class="text-success">Статус: Успешная</li>
                                        @elseif($stat->status == 0)
                                            <li class="text-danger">Статус: Проигрыш</li>
                                        @elseif($stat->status == 2)
                                            <li class="text-dark">Статус: Возврат</li>
                                        @elseif($stat->status == 3)
                                            <li class="text-dark">Статус: Нет статуса</li>
                                        @endif

                                        <li>Валютная пара: {{ $stat->cur_pair }}</li>
                                        <li>Валюта сделки: {{ $stat->cur }}</li>

                                        @if($stat->demo == 1)
                                            <li>Демо</li>
                                        @elseif($stat->demo == 0)
                                            <li>Реальный</li>
                                        @endif

                                        <li>Создана: {{ $stat->created_at }}</li>
                                        <li>Обновлена: {{ $stat->updated_at }}</li>

                                        @if($stat->source)
                                            <li>Статистика оповещения</li>
                                            <li>Успешно {{ $stat->source->sourceStat->success_count }}</li>
                                            <li>Проигрыш {{ $stat->source->sourceStat->loss_count }}</li>
                                            <li>Возврат {{ $stat->source->sourceStat->ret_count }}</li>
                                            <li>Заработали {{ $stat->source->sourceStat->win_sum / 100 }}</li>
                                            <li>Проиграли {{ $stat->source->sourceStat->loss_sum / 100 }}</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{ $user_stat->links('vendor.pagination.bootstrap-4') }}
                @else
                    <div class="text-center w-100">Сделки не найдены</div>
                @endif
            @elseif(Request::route('mode') == 'my_settings')
                @if($user_settings != null && $user_settings->count() > 0)
                    <div class="card mb-3">
                        <div class="card-header">Подписка</div>
                        <div class="card-body">
                            <form method="post" action="{{ route('edit_profile', ['mode' => 'subscribe']) }}">
                                {{ csrf_field() }}

                                @foreach($user_settings as $setting)
                                    @if($setting->name == 'price')
                                        <div class="form-group">
                                            <label for="enable_price">Разрешить покупать оповещения</label>
                                            @if($setting->value != null)
                                                <input type="checkbox" name="enable_price" id="enable_price" value="1"
                                                       checked>
                                            @else
                                                <input type="checkbox" name="enable_price" id="enable_price" value="1">
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Цена подписки</label>
                                            @if($setting->value != null)
                                                <input type="number" class="form-control" name="price" id="price"
                                                       placeholder="100" min="100" value="{{ $setting->value / 100 }}">
                                            @else
                                                <input type="number" class="form-control" name="price" id="price"
                                                       placeholder="100" min="100" value="100">
                                            @endif
                                            <small class="form-text text-muted">В рублях</small>
                                        </div>
                                    @elseif($setting->name == 'forever')
                                        <div class="form-group">
                                            <label for="enable_forever">Перманентная подписка</label>
                                            @if($setting->value == true)
                                                <input type="checkbox" name="enable_forever" id="enable_forever"
                                                       value="1" checked>
                                            @else
                                                <input type="checkbox" name="enable_forever" id="enable_forever"
                                                       value="1">
                                            @endif
                                        </div>
                                    @elseif($setting->name == 'days')
                                        <div class="form-group">
                                            <label for="price">Продолжительность подписки</label>
                                            @if($setting->value != null)
                                                <input type="number" class="form-control" name="days" id="days"
                                                       placeholder="30" min="1" value="{{ $setting->value }}">
                                            @else
                                                <input type="number" class="form-control" name="days" id="days"
                                                       placeholder="30" min="1" value="1">
                                            @endif
                                            <small class="form-text text-muted">Количество дней. Не учитывается если
                                                включена перманентная подписка
                                            </small>
                                        </div>
                                    @endif
                                @endforeach
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header">Источник оповещений</div>
                        <div class="card-body">
                            <form method="post" action="{{ route('edit_profile', ['mode' => 'notify_id']) }}">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="notify_id">Источник оповещений</label>
                                    <select class="form-control" name="notify_id" id="notify_id">
                                        @foreach($notify_access as $notify)
                                            <option value="{{ $notify->source->id }}">{{ $notify->source->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Режим аккаунта</div>
                        <div class="card-body">
                            <form>
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <select class="form-control" name="account_mode" id="account_mode">
                                        @foreach($user_settings as $setting)
                                            @if($setting->name == 'account_mode' && $setting->value == 0)
                                                <option value="0" selected>Слушатель</option>
                                                <option value="1">Источник</option>
                                            @elseif($setting->name == 'account_mode' && $setting->value == 1)
                                                <option value="0">Слушатель</option>
                                                <option value="1" selected>Источник</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Режим аккаунта можно менять 1 раз в 10 минут</small>
                                </div>
                                <div class="alert alert-danger" role="alert" style="display: none;" id="error_msg"></div>
                                <button type="submit" class="btn btn-primary" id="save_account_mode">Сохранить</button>
                            </form>
                        </div>
                    </div>

                    <script type="text/javascript">
                        window.api_token = '{!! Auth::user()->api_token !!}';
                        window.user = '{!! json_encode($user) !!}'
                    </script>
                    <script src="{{ asset('js/my_settings.js') }}"></script>
                @endif
            @elseif(Request::route('mode') == 'my_balance')
                @if($user_settings != null)
                    <p>Баланс {{ $user_settings->value / 100 }} рублей</p>
                    <form method="post" action="{{ route('edit_profile', ['mode' => 'balance']) }}" class="mb-5">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="comment">Комментарий</label>
                            <textarea type="text" class="form-control" name="comment" id="comment"
                                      placeholder="Qiwi +79111111111"></textarea>
                            <small class="form-text text-muted">Куда выводим</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Вывести</button>
                    </form>

                    <ul class="list-group">
                        @foreach($balance as $b)
                            <li class="list-group-item">
                                @if($b->status == 0)
                                    В процессе
                                @elseif($b->status == 1)
                                    Обработано
                                @elseif($b->status == 2)
                                    Ошибка
                                @endif
                                {{ $b->created_at }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endif
        @endif
    </div>
@stop