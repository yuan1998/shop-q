<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover"
    />

    <title>{{env('APP_TITLE')}}</title>
    <link rel="stylesheet" href="{{mix('/site1/css/app.css')}}">
</head>
<body>
<div id="app"></div>

<script src="{{mix('/site1/js/app.js')}}"></script>
</body>
</html>
