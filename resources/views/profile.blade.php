@extends('layouts.app')

@section('content')
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach

            <a href="{{ url()->previous() }}">Назад</a>
        @else
            <h3>Профиль {{ $user->name }}</h3>

            <div class="filter text-right mt-5 mb-5">
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
                    @else
                        @foreach($user->settings as $setting)
                            @if($setting->name == 'price')
                                @if($setting->value != null)
                                    <li class="list-inline-item"><a
                                                href="{{ route('subscribe', ['user_id' => $user->id]) }}">Оповещения {{ $setting->value / 100 }}
                                            рублей</a></li>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>

            @if(Request::route('mode') == 'fast_stat' || Request::route('mode') == null)
                @if($fast_stat->count() > 0)
                    <div class="row p-fix">
                        @foreach($fast_stat as $stat)
                            <div class="card col-md-6 text-center">
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
                                        <li class="">Возвраты {{ $stat->ret_count }}</li>
                                        <li class="">Продажи {{ $stat->cancel_count }}</li>
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
                    <div class="row mb-5 p-fix">
                        @foreach($notify_access as $notify)
                            <div class="card col-md-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $notify->user->name }}</h5>

                                    <a href="{{ route('profile', ['user_id' => $notify->user_id]) }}" class="card-link">В
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
                    <div class="row mb-5 p-fix">
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
                                            <li class="">Статус: Возврат</li>
                                        @elseif($stat->status == 4)
                                            <li class="">Статус: Продажа</li>
                                        @elseif($stat->status == 3)
                                            <li class="">Статус: Нет статуса</li>
                                        @endif

                                        <li>Валютная пара: {{ $stat->cur_pair }}</li>

                                        @if($stat->demo == 1)
                                            <li>Демо</li>
                                        @elseif($stat->demo == 0)
                                            <li>Реальный</li>
                                        @endif

                                        <li>Создана: {{ $stat->created_at }}</li>
                                        <li>Обновлена: {{ $stat->updated_at }}</li>

                                        @if($stat->sourceStat)
                                            <div class="card mt-3">
                                                <div class="card-body">
                                                    <ul class="list-unstyled">
                                                        <li>Статистика оповещения</li>
                                                        <li class="text-success">
                                                            Успешно {{ $stat->sourceStat->success_count }}</li>
                                                        <li class="text-danger">
                                                            Проигрыш {{ $stat->sourceStat->loss_count }}</li>
                                                        <li>Возврат {{ $stat->sourceStat->ret_count }}</li>
                                                        <li>Продажа {{ $stat->sourceStat->cancel_count }}</li>
                                                        <li class="text-success">
                                                            Заработали {{ $stat->sourceStat->win_sum / 100 }}</li>
                                                        <li class="text-danger">
                                                            Проиграли {{ $stat->sourceStat->loss_sum / 100 }}</li>
                                                    </ul>
                                                </div>
                                            </div>
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
                                <button type="submit" class="btn btn-dark-primary">Сохранить</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-5">
                        <div class="card-header">Api token</div>
                        <div class="card-body">
                            <form method="post" action="{{ route('edit_profile', ['mode' => 'api_token']) }}">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="api_token">Api token</label>
                                    <input type="password" class="form-control" name="api_token" id="api_token"
                                           value="{{ Auth::user()->api_token }}" disabled>
                                    <a href="#" id="show_api_token">Показать</a>
                                </div>
                                <button type="submit" class="btn btn-dark-primary">Создать новый</button>
                            </form>
                        </div>
                    </div>

                    <script src="{{ asset('js/my_settings.js') }}"></script>
                @endif
            @elseif(Request::route('mode') == 'my_balance')
                @if($user_settings != null)
                    <div class="card">
                        <div class="card-header">Мой баланс</div>
                        <div class="card-body">
                            <p>{{ $user_settings->value / 100 }} рублей</p>

                            <form method="post" action="{{ route('edit_profile', ['mode' => 'balance']) }}">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="comment">Комментарий</label>
                                    <textarea type="text" class="form-control" name="comment" id="comment"
                                              placeholder="Qiwi +79111111111"></textarea>
                                    <small class="form-text text-muted">Куда выводим</small>
                                </div>
                                <button type="submit" class="btn btn-dark-primary">Вывести</button>
                            </form>
                        </div>
                    </div>
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