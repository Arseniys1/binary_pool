@extends('layouts.app')

@section('content')
    <div class="container">
        @if(isset($user))
            <h3>Запрос доступа у пользователя {{ $user->name }}</h3>
        @endif

        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @elseif(count($access_presets) > 0)
            @if(session('success_message'))
                <div class="alert alert-success">{{ session('success_message') }}</div>
            @endif

            <div class="row mt-5">
                @foreach($access_presets as $access_preset)
                    <div class="col-md-4 mb-5">
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    @if($access_preset->forever)
                                        <li>Тип подписки: Перманентная</li>
                                    @else
                                        <li>Тип подписки: Истекаемая</li>
                                        <li>Количество дней: {{ $access_preset->preset->days }}</li>
                                    @endif

                                    @if($access_preset->comment != null)
                                        <li>Комментарий: {{ $access_preset->comment }}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="card-footer">
                                <a href="#" class="card-link" onclick="open_modal(event, {{ $access_preset->id }})">Запросить
                                    доступ</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <p>Доступы не найдены</p>
            </div>
        @endif
    </div>

    <div class="modal fade" id="sendRequest" tabindex="-1" role="dialog" aria-labelledby="sendRequestLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendRequestLabel">Отправить запрос</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('access.requests.send') }}" id="send-request">
                        {{ csrf_field() }}

                        <input type="hidden" name="preset_id" id="preset_id">

                        <div class="form-group">
                            <label for="comment">Комментарий</label>
                            <textarea class="form-control" name="comment" id="comment"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-dark-primary" onclick="$('#send-request').submit()">
                        Отправить
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/access/demo.js') }}"></script>
@stop