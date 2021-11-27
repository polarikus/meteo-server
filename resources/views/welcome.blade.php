@extends('base-template.base')
@section('title')
    Главная
@endsection
@section('content')
    <h1 class="mt-5">Назначение проекта</h1>
    <p class="lead">
        Проект разработан для получения статистики с различных датчиков и отображения этих данных в режиме онлайн.
    </p>
    <p>Помочь в разработке может каждый желающий, выполнив fork, а затем pull request <a target="_blank"
                                                                                         href="https://github.com/polarikus/meteo-server/tree/dev">в
            Dev ветку репозитория.</a></p>
    <br>
    <p class="lead">
        Пока существует http api и прошивка только для датчика температуры DHT11, который подключен к ESP32.
    </p>
    <p>Исходный код прошивки и инструкция <a target="_blank" href="https://github.com/polarikus/MyMetioStation">
            тут.</a></p>
    <p class="lead">
        Для получения токена авторизации для запросов напишите мне в <a target="_blank" href="https://t.me/idcloud2">телеграмм</a>,
        указав Вашу почту, имя или никнейм.
    </p>
    <p>На данный момент можно подключить только <span class="text-danger">одну плату</span>, так как проект OpenSource,
        а места на сервере не так много :)</p>
    <br>
        <div class="form-row align-items-center">
            <div class="col-auto">
                <label class="sr-only" for="form-serial-number">serial number</label>
                <input id="form-serial-number" @if(isset($sn))value="{{$sn}}"@endif type="text" class="form-control mb-2" placeholder="Серийный номер" required>
            </div>
            <div class="col-auto">
                <button type='button' id="sensor-go-btn" class="btn btn-primary mb-2">Просмотр</button>
            </div>
            @if(isset($err))
                <div class="col-auto">
                    <span class="badge badge-danger">{{$err}}</span>
                </div>@endif
        </div>
        <div class="form-row align-items-center">
            <div class="col-auto">
                <p>Введите серийный номер своего устройства и нажмите "Просмотр"</p>
            </div>
            <div class="col-auto">
                <p>Для просмотра демо - используйте серийный номер <code>0032016336044</code></p>
            </div>
            <div class="col-auto">
                <p>Если датчик оффлайн - напишите <a target="_blank" href="https://t.me/idcloud2">мне</a>, я включу</p>
            </div>
        </div>
    <h4>Видео демонстрация</h4>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/B6fKr31_bFs" title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
    <script>
        $('#sensor-go-btn').click(function () {
            window.location = '/sensor/' + $('#form-serial-number').val() + '/meteo-data';
        });
    </script>
@endsection
