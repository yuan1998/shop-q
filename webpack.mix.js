let mix = require('laravel-mix');

if (process.env.section) {
    require(`${__dirname}/webpack/webpack.${process.env.section}.js`);
}
