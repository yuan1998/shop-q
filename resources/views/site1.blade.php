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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vant@4.0.7/lib/index.min.css" data-asset="{{asset('/css/vant.css')}}" onerror="onCdnError(this)">
    <link rel="stylesheet" href="{{mix('/site1/css/app.css')}}">
    <script src="{{asset('/js/cdnError.js?v=0.0.5')}}"></script>
    <script>
        window._setting_ = @json($setting);
    </script>
</head>
<body>
<div id="app"></div>

<script src="https://cdn.jsdelivr.net/npm/@amap/amap-jsapi-loader@1.0.1/dist/index.js" data-asset="{{asset('/js/amap-jsapi-loader.min.js')}}" onerror="onCdnError(this)"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@3.2.45/dist/vue.global.prod.js" data-asset="{{asset('/js/vue.global.prod.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-router@4.1.6/dist/vue-router.global.prod.js" data-asset="{{asset('/js/vue-router.global.prod.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vant@4.0.7/lib/vant.min.js" data-asset="{{asset('/js/vant.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.2.2/dist/axios.min.js" data-asset="{{asset('/js/axios.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/localstoragedb@2.3.2/localstoragedb.min.js" data-asset="{{asset('/js/localstoragedb.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js" data-asset="{{asset('/js/lodash.js')}}"></script>
<script src="{{asset('/site1/js/manifest.js')}}"></script>
<script src="{{asset('/site1/js/vendor.js')}}"></script>
<script src="{{mix('/site1/js/app.js')}}"></script>
</body>
</html>
