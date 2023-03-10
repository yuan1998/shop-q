let mix = require('laravel-mix');
require('laravel-mix-bundle-analyzer');

if (mix.inProduction()) {
    mix.bundleAnalyzer({
        analyzerMode: 'static'
    });
}

mix
    .setPublicPath('public/site1')
    .extract(['@vant/area-data'])
    .js('resources/js/site1/app.js', 'js/app.js')
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
