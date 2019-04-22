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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.copyDirectory('node_modules/tinymce/skins/ui/oxide', 'public/skin/ui/oxide');
mix.copyDirectory('node_modules/tinymce/skins/content/default', 'public/js/skins/content/default');
mix.copyDirectory('node_modules/tinymce/themes', 'public/js/themes');
mix.copyDirectory('node_modules/tinymce/plugins', 'public/js/plugins');

mix.browserSync('http://localhost/KnowWeb/public/')