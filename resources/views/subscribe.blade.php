@extends('layouts.app')

@section('content')
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach

            <a href="{{ url()->previous() }}">Назад</a>
        @else
            <div class="card">
                <div class="card-header">Купить оповещения пользователя {{ $user->name }}</div>
                <div class="card-body">
                    <?php
                    $price = null;
                    $days = null;
                    $forever = null;

                    foreach ($user->settings as $setting) {
                        if ($setting->name == 'price') {
                            $price = $setting->value;
                        } elseif ($setting->name == 'days') {
                            $days = $setting->value;
                        } elseif ($setting->name == 'forever') {
                            $forever = $setting->value;
                        }
                    }
                    ?>

                    <p>Цена {{ $price / 100 }} рублей</p>

                    @if($forever == true)
                        <p>Продолжительность подписки: Перманентная
                            <a data-toggle="tooltip" data-placement="top" title="Вечная подписка">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </a>
                        </p>
                    @else
                        <p>Продолжительность подписки: {{ $days }} дней</p>
                    @endif

                    <form method="post" action="https://wl.walletone.com/checkout/checkout/Index">
                        <input type="hidden" name="WMI_MERCHANT_ID" value="173762429793"/>
                        <input type="hidden" name="WMI_PAYMENT_NO" value="{{ $payment->id }}"/>
                        <input type="hidden" name="WMI_PAYMENT_AMOUNT" value="{{ sprintf('%.2f', $price / 100) }}"/>
                        <input type="hidden" name="WMI_CURRENCY_ID" value="643"/>
                        <input type="hidden" name="WMI_DESCRIPTION" value="Подписка на пользователя {{ $user->name }}"/>
                        <input type="hidden" name="WMI_CULTURE_ID" value="ru-RU"/>

                        <button type="submit" class="btn btn-dark-primary">Купить оповещения</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop