<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link type="text/css" rel="StyleSheet" href="public/css/style.css" />
    <title>@yield('title')</title>
</head>
<script src="public/js/jquery-3.6.0.js"></script>
<script src="public/js/popper.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/script.js"></script>
<script src="public/js/moment-with-locales.min.js"></script>
<script src="public/js/moment-timezone-with-data.js"></script>
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
