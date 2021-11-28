<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
    <link type="text/css" rel="StyleSheet" href="{{asset('/css/style.css')}}" />
    <title>@yield('title')</title>
</head>
<script src="{{asset('/js/jquery-3.6.0.js')}}"></script>
<script src="{{asset('/js/popper.min.js')}}"></script>
<script src="{{asset('/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/js/script.js')}}"></script>
<script src="{{asset('/js/moment-with-locales.min.js')}}"></script>
<script src="{{asset('/js/moment-timezone-with-data.js')}}"></script>
<body>
<header class="mb-2">
    @include('base-template.header')
</header>
<div class="container">
    @yield('content')
</div>
    <footer>
        @include('base-template.footer')
    </footer>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>
</html>
