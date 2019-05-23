<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Selectra')</title>
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<body>

@include('layouts.navbar')

<div>
    @yield('content')
</div>

</body>
</html>
