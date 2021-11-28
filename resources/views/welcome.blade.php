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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vant@3.2.7/lib/index.css">
    <link rel="stylesheet" href="{{mix('/site1/css/app.css')}}">
    <script>
        window._setting_ = @json($setting);
    </script>
</head>
<body>
<div id="app"></div>
<script src="https://cdn.jsdelivr.net/npm/@amap/amap-jsapi-loader@1.0.1/dist/index.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@3.2.10/dist/vue.global.prod.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-router@4.0.5/dist/vue-router.global.prod.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vant@3.2.7/lib/vant.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/axios/0.21.1/axios.js"></script>
<script src="https://cdn.jsdelivr.net/npm/localstoragedb@2.3.2/localstoragedb.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script src="{{mix('/site1/js/app.js')}}"></script>
</body>
</html>
