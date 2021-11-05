let mix  = require('laravel-mix');

mix
    .setPublicPath('public/site1')
    .js('resources/js/app.js', 'js/app.js')
    .vue()
    .less('resources/less/app.less', 'css/app.css')
    .options({
        processCssUrls: false
    })
;
