@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Ссылки доступа</h3>

        @include('access.nav')

        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @elseif(session('success_message'))
            <div class="alert alert-success">{{ session('success_message') }}</div>
        @endif

        <form method="post" action="{{ route('access.links.create') }}" class="mt-5 mb-5">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="access_preset_id">Доступ</label>
                <select type="number" class="form-control" name="access_preset_id" id="access_preset_id">
                    @foreach($access_presets as $access_preset)
                        <option value="{{ $access_preset->id }}">
                            ID: {{ $access_preset->id }} |

                            @if($access_preset->forever)
                                Тип подписки: Перманентная
                            @else
                                Тип подписки: Истекаемая |
                                Количество дней: {{ $access_preset->days }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-dark-primary">Создать</button>
        </form>

        @if(count($access_links) <= 0)
            <div class="text-center">
                <p>Ссылки не найдены</p>
            </div>
        @else
            <div class="items mb-5">
                <div class="row">
                    @foreach($access_links as $access_link)
                        <div class="col-md-12 mb-3">
                            <div class="card" id="link-{{ $access_link->id }}">
                                <div class="card-body">
                                    <h6>Доступ</h6>
                                    <ul class="list-unstyled">
                                        <li>ID доступа: {{ $access_link->preset->id }}</li>
                                        @if($access_link->preset->forever)
                                            <li>Тип подписки: Перманентная</li>
                                        @else
                                            <li>Тип подписки: Истекаемая</li>
                                            <li>Количество дней: {{ $access_link->preset->days }}</li>
                                        @endif

                                        @if($access_link->preset->comment != null)
                                            <li>Комментарий: {{ $access_link->preset->comment }}</li>
                                        @endif
                                    </ul>

                                    <p>ID: {{ $access_link->id }}</p>

                                    <a href="{{ route('access.activate.link', ['key' => $access_link->key]) }}">{{ route('access.activate.link', ['key' => $access_link->key]) }}</a>
                                </div>
                                <div class="card-footer">
                                    <a href="#" class="card-link"
                                       onclick="copy_link(event, {{ $access_link->id }})">Скопировать ссылку</a>
                                    <a href="#" class="card-link"
                                       onclick="delete_link(event, {{ $access_link->id }})">Удалить</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{ $access_links->links('vendor.pagination.bootstrap-4') }}
        @endif
    </div>

    <script type="text/javascript">
        const delete_url = '{{ route('access.links.delete') }}';
    </script>
    <script src="{{ asset('js/access/links.js') }}"></script>
@stop