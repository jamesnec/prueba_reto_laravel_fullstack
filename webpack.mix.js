const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js(['resources/js/app.js'], 'public/assets/js/app.min.js')
    .js(['resources/js/my_script.js'], 'public/assets/js/all.min.js')
    .sass('resources/sass/app.scss', 'public/assets/css/app.min.css')
    .styles(['resources/css/materialize.min.css', 'resources/css/mystyle.css'], 'public/assets/css/all.min.css');
