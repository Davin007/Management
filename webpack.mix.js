// Mix's webpack.mix.js
const { mix } = require('laravel-mix');

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

mix.js(
    [
        'resources/assets/lib/jQuery/jquery-1.12.4.js',
        'resources/assets/js/app.js',
        'resources/assets/lib/sweetAlert/sweetalert.min.js',
        'resources/assets/lib/dataTable/jquery.dataTables.min.js',
        // 'resources/assets/js/general.js'
    ], 'public/js/app.js');
mix.styles(
        [
            'vendor/twbs/bootstrap/dist/css/bootstrap.css',
            'vendor/components/font-awesome/css/font-awesome.css',
            'resources/assets/lib/dataTable/jquery.dataTables.min.css',
            'resources/assets/lib/sweetAlert/sweetalert.css',
            'resources/assets/css/style.css'
        ],'public/css/app.css');