@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-5">
            <div class="card-header">Api token</div>
            <div class="card-body">
                <form method="post" action="{{ route('change_api_token') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="api_token">Api token</label>
                        <input type="password" class="form-control" name="api_token" id="api_token" value="{{ Auth::user()->api_token }}" disabled>
                        <a href="#" id="show_api_token">Показать</a>
                    </div>
                    <button type="submit" class="btn btn-dark-primary">Создать новый</button>
                </form>
            </div>
        </div>

        <button type="button" class="btn btn-success btn-lg btn-block" id="start">Старт</button>
        <button type="button" class="btn btn-danger btn-lg btn-block mt-0" id="stop">Стоп</button>
    </div>

    <script type="text/javascript">
        window.user = '{!! json_encode(Auth::user()->with('settings')->find(Auth::user()->id)) !!}';
    </script>
    {{--<script src="{{ asset('js/extension.js') }}"></script>--}}
@stop