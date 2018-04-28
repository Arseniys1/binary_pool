<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Binary Pool @if(isset($title)) {{ '| ' . $title }} @endif</title>
    <link rel="icon" href="{{ asset('binary-pool-no-fon.png') }}">

    <script src="http://{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div id="app">
        <div>
            <navbar/>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-2 bg-dark2" id="left-side-wrap">
                    <left-side/>
                </div>

                <div class="col-md-9 col-10" id="content-wrap">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include('v2.layouts.data')

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>