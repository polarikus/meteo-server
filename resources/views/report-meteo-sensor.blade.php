@extends('base-template.base')
@section('title')
    Меиеостатистика
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
        function getSensorDesc() {
            $.ajax({
                url: '/api/reports/meteo/sensor-desc/' + serial_number
            }).done(function (data) {
                let time = moment();
                let lastOnline = moment(data.last_online.last_online);
                lastOnline = moment(data.last_meteo_data[0].created_at);
                online = moment.duration(time.diff(lastOnline));
                console.log('Разница: ' + online / 1000);
                console.log('Сейчас: ' + time);
                console.log('Был: ' + lastOnline);
                $('.card-temperature-last').text(data.last_meteo_data[0].temperature);
                $('.card-humidity-last').text(data.last_meteo_data[0].humidity + '%');
                $('.badge-model').text(data.chip + ' rev.' + data.rev);
                $('.last-online').text(lastOnline.fromNow());
                console.log((online  > 60000);
                console.log(online + Dscdelay);
                if ((online + Dscdelay) < 60000){
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

        getGraphData();

        let timerGraph = setTimeout(function request() {
            if (getGraphData() === false){
                Gdelay *= 2;
            }
            timerGraph = setTimeout(request, Gdelay);
        }, Gdelay);




    </script>
@endsection
