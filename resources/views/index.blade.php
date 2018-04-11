@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <h1>Хочешь успешно торговать на Olymp Trade?</h1>
            <h2 class="mt-3">Получай торговые сигналы от топовых трейдеров!</h2>
            <h3 class="mt-5">На Binary Pool ты можешь получать торговые сигналы в режиме реального времени.</h3>
            <h3 class="mt-3">Ты можешь просматривать статистику трейдеров и их сделки!</h3>

            <a href="{{ route('register') }}" role="button" class="btn btn-success btn-lg mt-5">Я хочу получать торговые сигналы!</a>
            <a href="{{ url('/how_to_receive_signals') }}" class="d-block mt-3">Посмотрите инструкцию перед регистрацией</a>
        </div>
    </div>
@stop