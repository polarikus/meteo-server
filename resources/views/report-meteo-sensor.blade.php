@extends('base-template.base')
@section('title')
    Онлайн монитор
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-5 col-lg-3 col-xl-4">
            @include('meteo-sensor')
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div id="chart"></div>
            <div/>
    </div>
    <script>

        let serial_number = $('#serial_number').text();
        let online;
        let Dscdelay = 5000;
        var Gdelay = 100000;
        var last_temperature = 0;
        var last_humidity = 0;
        function getGraphData(){
            $.ajax({
                url: '/api/reports/meteo/sensor-stat/' + serial_number + '/hour'
            }).done(function(data) {
                console.log(data);
                $("#chart").shieldChart({
                    theme: "light",
                    seriesSettings: {
                        line: {
                            dataPointText: {
                                enabled: true
                            }
                        }
                    },
                    chartLegend: {
                        align: 'center',
                        borderRadius: 2,
                        borderWidth: 2,
                        verticalAlign: 'top'
                    },
                    exportOptions: {
                        image: true,
                        print: true
                    },
                    axisX: {
                        categoricalValues: data.mins
                    },
                    axisY: {
                        title: {
                            text: "Температура / Влажность"
                        }
                    },
                    primaryHeader: {
                        text: "График минутный"
                    },
                    dataSeries: [{
                        seriesType: 'line',
                        collectionAlias: 'Температура',
                        data:  data.temperature
                    }, {
                        seriesType: 'line',
                        collectionAlias: 'Влажность',
                        data: data.humidity
                    }]
                });
                return true;
            }).fail(function (err) {
                return false;
            });
        }

        function getSensorDesc() {
            $.ajax({
                url: '/api/reports/meteo/sensor-desc/' + serial_number
            }).done(function (data) {
                let time = moment();
                let lastOnline = moment(data.last_online);
                online = moment.duration(time.diff(lastOnline));
                console.log('Сейчас h: ' + data.last_meteo_data.humidity);
                console.log('Был h: ' + last_humidity);
                console.log('Сейчас t: ' + data.last_meteo_data.temperature);
                console.log('Был: t' + last_temperature);
                if (last_humidity != data.last_meteo_data.humidity || last_temperature != data.last_meteo_data.temperature){
                    getGraphData();
                }
                last_humidity = data.last_meteo_data.humidity;
                last_temperature = data.last_meteo_data.temperature;
                $('.card-temperature-last').text(data.last_meteo_data.temperature);
                $('.card-humidity-last').text(data.last_meteo_data.humidity + '%');
                $('.badge-model').text(data.chip + ' rev.' + data.rev);
                $('.last-online').text(lastOnline.fromNow());
                if ( online < 60000){
                    $('.badge-online').text('Online');
                    $('.badge-online').removeClass('badge-danger');
                    $('.badge-online').addClass('badge-success');
                }else {
                    $('.badge-online').text('Offline');
                    $('.badge-online').addClass('badge-danger');
                    $('.badge-online').removeClass('badge-success');
                }
                return true;
            }).fail(function (err) {
                return false
            });
        };
        getSensorDesc();
        let timerId = setTimeout(function request() {
           if (getSensorDesc() === false){
               Dscdelay *= 2;
           }
            timerId = setTimeout(request, Dscdelay);
        }, Dscdelay);


        getGraphData();

        let timerGraph = setTimeout(function request() {
            if (getGraphData() === false){
                Gdelay *= 2;
            }
            timerGraph = setTimeout(request, Gdelay);
        }, Gdelay);




    </script>
@endsection
