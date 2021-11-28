let mix = require('laravel-mix');

mix
    .setPublicPath('public/site1')
    .js('resources/js/app.js', 'js/app.js')
    .vue()
    .less('resources/less/app.less', 'css/app.css')
    .options({
        processCssUrls: false
    })
    .webpackConfig({
        output: {
            publicPath: 'site1/',
        },
        externals: {
            'vue': 'Vue',
            'vue-router': 'VueRouter',
            'localstoragedb': 'localStorageDB',
            'lodash': '_',
            '@amap/amap-jsapi-loader': 'AMapLoader',
            'axios': "axios",
            'vant': "vant",
        }
    })
;
