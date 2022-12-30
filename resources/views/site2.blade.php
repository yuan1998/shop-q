<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover"
    />

    <title>{{data_get($setting,'web_title' , env('APP_TITLE'))}}</title>
    <link rel="stylesheet" href="{{asset('/css/vant.css')}}">
    <link rel="stylesheet" href="{{mix('/site2/css/app.css')}}">
    <script>
        window._setting_ = @json($setting);
    </script>
</head>
<body>
<div id="app"></div>
<script src="{{asset('/js/amap-jsapi-loader.min.js')}}"></script>
<script src="{{asset('/js/vue.global.prod.js')}}"></script>
<script src="{{asset('/js/vue-router.global.prod.js')}}"></script>
<script src="{{asset('/js/vant.js')}}"></script>
<script src="{{asset('/js/axios.min.js')}}"></script>
<script src="{{asset('/js/localstoragedb.min.js')}}"></script>
<script src="{{asset('/js/lodash.js')}}"></script>
<script src="{{mix('/site2/js/manifest.js')}}"></script>
<script src="{{mix('/site2/js/vendor.js')}}"></script>
<script src="{{mix('/site2/js/app.js')}}"></script>
</body>
</html>
