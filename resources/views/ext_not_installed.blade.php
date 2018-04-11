@extends('layouts.app')

@section('content')
    <div class="container">
        <p>Для того чтобы начать получать сигналы вам нужно установить расширение!
            <a href="{{ url('/how_to_receive_signals') }}">Здесь</a>
            вы можете посмотреть как это сделать.
        </p>
    </div>
@stop