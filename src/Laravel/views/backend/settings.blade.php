@extends('telegramBot::backend.layouts.app')

@section('content')
{{-- {{ dd(get_defined_vars()['__data']) }} --}}
<div class="container">
    {{-- разобраться почему не работает во вьюхе пакета --}}
    @if (Session::has('status'))
        <div class="alert alert-info">s
            <span>{{ Session::get('status') }}</span>
        </div>
    @endif

    {{-- @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif --}}
    {{-- Временная замена вывода через сессию --}}
    @if (isset($status))
        <div class="alert alert-success">
            {{ $status }}
        </div>
    @endif

    <form action="{{ route('tg-admin.setting.store') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="">url_callback для Telegram bot</label>
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" area-expanded="false">Действие <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="document.getElementById('url_callback_bot').value = '{{ url('') }}'">Вставить url</a></li>
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('setWebhook').submit()">Отправить url</a></li>
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('getWebhookInfo').submit()">Получить информацию</a></li>
                    </ul>
                </div>
                <input type="url" class="form-control" id="url_callback_bot" name="url_callback_bot" value="{{ $url_callback_bot ?? '' }}">
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Сохранить</button>
    </form>

    <!-- Форма для отправки URL -->
    <form id="setWebhook" action="{{ route ('tg-admin.setting.setWebhook')}}" method="POST" style="display: none;">
    	{{ csrf_field() }}
    	<input type="hidden" name="url" value="{{ $url_callback_bot ?? ''}}">
    </form>

    <!-- Форма для получения информации о webhook-->
    <form id="getWebhookInfo" action="{{ route ('tg-admin.setting.getWebhookInfo')}}" method="POST" style="display: none;">
    	{{ csrf_field() }}
    </form>
</div>

@endsection