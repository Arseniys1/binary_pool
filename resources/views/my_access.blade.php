@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Мои подписки</h3>

        @if(count($notify_access) > 0)
            <div class="row mt-5 p-fix">
                @foreach($notify_access as $notify)
                    <div class="card col-md-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $notify->source->name }}
                                @if(strtotime($notify->source->last_online) > time() - 300)
                                    <small class="text-success">Online</small>
                                @else
                                    <small data-toggle="tooltip" data-placement="top"
                                           title="Последний раз был в сети {{ $notify->source->last_online }}">Offline
                                    </small>
                                @endif
                            </h5>

                            <ul class="list-unstyled">
                                @if($notify->status == 1)
                                    <li>Статус: Активна</li>
                                @elseif($notify->status == 0)
                                    <li>Статус: Истекла</li>
                                @endif

                                @if($notify->access_type == 0)
                                    <li>Тип: Перманентная</li>
                                @elseif($notify->access_type == 1)
                                    <li>Тип: Ограниченная</li>
                                    <li>Истекает: {{ $notify->end_at }}</li>
                                @endif
                            </ul>

                            <a href="{{ route('profile', ['user_id' => $notify->source->id]) }}" class="card-link">В
                                профиль</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center w-100">Подписки не найдены</div>
        @endif
    </div>

    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop