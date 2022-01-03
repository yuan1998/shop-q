let mix = require('laravel-mix');
const path = require('path')
require('laravel-mix-bundle-analyzer');

if (mix.inProduction()) {
    mix.bundleAnalyzer({
        analyzerMode: 'static'
    });
}

mix
    .setPublicPath('public/site2')
    .extract(['@vant/area-data'])
    .js('resources/js/site2/app.js', 'js/app.js')
    .vue()
    .less('resources/less/app.less', 'css/app.css')
    .options({
        processCssUrls: false
    })
    .alias({
        '@': path.join(__dirname, './resources/js'),
        '@site1': path.join(__dirname, './resources/js/site1'),
        '@site2': path.join(__dirname, './resources/js/site2'),
    })
    .webpackConfig({
        output: {
            publicPath: 'site2/',
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
