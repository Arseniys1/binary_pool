@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Запросы на подписку</h3>

        @include('access.nav')

        @if(count($access_requests) <= 0)
            <div class="text-center">
                <p>Запросы не найдены</p>
            </div>
        @else
            @if(session('success_message'))
                <div class="alert alert-success">{{ session('success_message') }}</div>
            @endif

            <div class="items mb-5">
                <div class="row">
                    @foreach($access_requests as $access_request)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $access_request->user->name }}</h5>

                                    <h6>Доступ</h6>
                                    <ul class="list-unstyled">
                                        <li>ID доступа: {{ $access_request->preset->id }}</li>
                                        @if($access_request->preset->forever)
                                            <li>Тип подписки: Перманентная</li>
                                        @else
                                            <li>Тип подписки: Истекаемая</li>
                                            <li>Количество дней: {{ $access_request->preset->days }}</li>
                                        @endif

                                        @if($access_request->preset->comment != null)
                                            <li>Комментарий: {{ $access_request->preset->comment }}</li>
                                        @endif
                                    </ul>

                                    @if($access_request->comment != null)
                                        <p>Комментарий: {{ $access_request->comment }}</p>
                                    @endif

                                    <p>Дата создания: {{ $access_request->created_at }}</p>
                                </div>
                                <div class="card-footer">
                                    <a href="#" class="card-link"
                                       onclick="accept_request(event, {{ $access_request->id }})">Принять</a>
                                    <a href="#" class="card-link"
                                       onclick="reject_request(event, {{ $access_request->id }})">Отклонить</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{ $access_requests->links('vendor.pagination.bootstrap-4') }}
        @endif
    </div>

    <script src="{{ asset('js/access/access.js') }}"></script>
    <script type="text/javascript">
        const accept_url = '{{ route('access.requests.accept') }}';
        const reject_url = '{{ route('access.requests.reject') }}';
    </script>
@stop