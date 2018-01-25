var elixir = require('laravel-elixir');
var randomString = require('randomstring');
require('laravel-elixir-spritesmith');
require('laravel-elixir-imagemin');


/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.extend('sourcemaps', false);

elixir.config.images = {
    folder: 'images',
    outputFolder: 'images'
};

elixir.spriteName = randomString.generate() + '_sprite';

elixir(function (mix) {
    mix.spritesmith('resources/assets/sprites', {
        retinaSrcFilter: 'resources/assets/sprites/*@2x.png',
        imgOutput: 'resources/assets/images',
        cssOutput: 'resources/assets/sass/',
        cssName: '_sprites.sass',
        imgPath: '/images/' + elixir.spriteName + '.png',
        imgName: elixir.spriteName + '.png',
        retinaImgName: elixir.spriteName + '@2x.png',
        retinaImgPath: '/images/' + elixir.spriteName + '@2x.png'
    });

    mix.sass('app.sass', false, {indentedSyntax: true});
    mix.sass('print.sass', false, {indentedSyntax: true});

    mix.scripts([
        '/vendor/jquery.min.js',
        '/vendor/picturefill.js',
        '/vendor/slick.js',
        '/vendor/vue.min.js',
        '/vendor/bootstrap-datepicker.min.js',
        '/vendor/datepicker/*.*',
        '/vendor/popup/*.*',
        '/vendor/sweetalert.min.js',
        '/vendor/slider.js',
        '/vendor/jquery.sticky.js',
        '/vendor/payment.jquery.js',
        '/vendor/js.cookie.js',
        '/vendor/tooltip.min.js',
        '/vendor/clipboard.min.js',
        '/vendor/he.js',
        '/vendor/jquery.history.js',
        '/vendor/croppie.min.js',
        '/app.js'
    ], 'public/js/app.js');

    mix.scripts([
        '/vendor/validation/core.js'
    ], 'public/js/validator.js');

    mix.scripts('/vendor/validation/validation_messages_da.js');
    mix.scripts('/vendor/validation/validation_messages_nl.js');

    mix.version(['js/validator.js', 'js/app.js', 'css/app.css', 'css/print.css']);

    mix.imagemin();
});