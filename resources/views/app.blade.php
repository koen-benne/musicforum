<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>@yield('title')</title>
    <meta name="author" content="Koen Benne">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>

<body>

@include('inc.topnav')

@yield('content')

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
