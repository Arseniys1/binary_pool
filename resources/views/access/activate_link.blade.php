@extends('layouts.app')

@section('content')
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @else
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Активация доступа для {{ $access_link->preset->source->name }}</h5>

                    <ul class="list-unstyled">
                        @if($access_link->preset->forever)
                            <li>Тип подписки: Перманентная</li>
                        @else
                            <li>Тип подписки: Истекаемая {{ $notify_access->end_at }}</li>
                            <li>Количество дней: {{ $access_link->preset->days }}</li>
                        @endif

                        @if($access_link->preset->comment != null)
                            <li>Комментарий: {{ $access_link->preset->comment }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        @endif
    </div>
@stop