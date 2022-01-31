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
    <link rel="stylesheet" href="https://unpkg.zhimg.com/vant@3.2.7/lib/index.css">
    <link rel="stylesheet" href="{{mix('/site2/css/app.css')}}">
    <script>
        window._setting_ = @json($setting);
    </script>
</head>
<body>
<div id="app"></div>
<script src="https://unpkg.zhimg.com/@amap/amap-jsapi-loader@1.0.1/dist/index.js"></script>
<script src="https://unpkg.zhimg.com/vue@3.2.10/dist/vue.global.prod.js"></script>
<script src="https://unpkg.zhimg.com/vue-router@4.0.5/dist/vue-router.global.prod.js"></script>
<script src="https://unpkg.zhimg.com/vant@3.2.7/lib/vant.js"></script>
<script src="https://unpkg.zhimg.com/axios@0.25.0/dist/axios.min.js"></script>
<script src="https://unpkg.zhimg.com/localstoragedb@2.3.2/localstoragedb.js"></script>
<script src="https://unpkg.zhimg.com/lodash@4.17.21/lodash.js"></script>
<script src="{{mix('/site2/js/manifest.js')}}"></script>
<script src="{{mix('/site2/js/vendor.js')}}"></script>
<script src="{{mix('/site2/js/app.js')}}"></script>
</body>
</html>
