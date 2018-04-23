@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Настройки доступа</h3>

        @include('access.nav')

        <div class="buttons mb-5">
            <button class="btn btn-dark-primary" onclick="add_access(event)">Добавить</button>
        </div>

        @if(count($access_presets) <= 0)
            <div class="text-center">
                <p>Доступы не найдены</p>
            </div>
        @else
            <div class="items mb-5">
                <div class="row">
                    @foreach($access_presets as $access_preset)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li>ID доступа: {{ $access_preset->id }}</li>
                                        @if($access_preset->forever)
                                            <li>Тип подписки: Перманентная</li>
                                        @else
                                            <li>Тип подписки: Истекаемая</li>
                                            <li>Количество дней: {{ $access_preset->days }}</li>
                                        @endif

                                        @if($access_preset->comment != null)
                                            <li>Комментарий: {{ $access_preset->comment }}</li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    <a href="#" class="card-link"
                                       onclick="edit_access(event, {{ $access_preset->id }})">Редактировать</a>
                                    <a href="#" class="card-link"
                                       onclick="delete_access(event, {{ $access_preset->id }})">Удалить</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="addAccessPreset" tabindex="-1" role="dialog" aria-labelledby="addAccessPresetLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccessPresetLabel">Добавить доступ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @elseif(session('success_message'))
                        <div class="alert alert-success">{{ session('success_message') }}</div>
                    @endif

                    <form method="post" action="{{ route('access.presets.save') }}" id="add-access-preset">
                        {{ csrf_field() }}

                        <input type="hidden" name="edit_access_id" id="edit_access_id">

                        <div class="form-group">
                            <label for="days">Количество дней</label>
                            <input type="number" class="form-control" min="1" value="1" name="days" id="days">
                            <small class="form-text text-muted">Не учитывается если подписка перманентная</small>
                        </div>
                        <div class="form-group">
                            <label for="forever">Перманентная подписка</label>
                            <input type="checkbox" name="forever" id="forever">
                        </div>
                        <div class="form-group">
                            <label for="comment">Комментарий</label>
                            <textarea class="form-control" name="comment" id="comment"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-dark-primary" onclick="$('#add-access-preset').submit()">
                        Добавить
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/access/presets.js') }}"></script>
    <script type="text/javascript">
        let show_modal;

        const add_url = '{{ route('access.presets.save') }}';
        const edit_url = '{{ route('access.presets.edit') }}';
        const delete_url = '{{ route('access.presets.delete') }}';

        @if(session('show_modal'))
            show_modal = '{!! session('show_modal') !!}';
        @endif

        @if(session('save'))
            add_access();
        @elseif(session('edit'))
            edit_access(undefined, {{ session('edit_id') }});
        @endif

        if (show_modal !== undefined) {
            $(show_modal).modal('show');
        }
    </script>
@stop