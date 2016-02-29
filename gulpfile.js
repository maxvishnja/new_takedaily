var elixir = require('laravel-elixir');
var gulp = require('gulp');
var svgSprite = require('gulp-svg-sprite');
require('laravel-elixir-spritesmith');


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

//elixir.extend('sourcemaps', false);


elixir(function (mix)
{
	svgSpriteConfig = {
		mode: {
			css: {
				bust: false,
				dest: 'images',
				render: {
					scss: {
						dest: '../../resources/assets/sass/_svg-sprites'
					}
				},
				sprite: '../images/svg-sprite.svg'
			},
		}
	};
	gulp.src('resources/assets/sprites/*.svg')
		.pipe(svgSprite(svgSpriteConfig))
		.pipe(gulp.dest('public/'));

	mix.spritesmith('resources/assets/sprites', {
		retinaSrcFilter: 'resources/assets/sprites/*@2x.png',
		imgOutput: 'public/images',
		cssOutput: 'resources/assets/sass/',
		cssFormat: 'sass',
		cssName: '_sprites.sass',
		imgPath: '/images/sprite.png',
		retinaImgName: 'sprite@2x.png',
		retinaImgPath: '/images/sprite@2x.png'
	});

	mix.sass('app.sass', false, {indentedSyntax: true});

	mix.scripts([
		'/vendor/jquery.min.js',
		'/vendor/vue.min.js',
		'/vendor/pickadate/picker.js',
		'/vendor/pickadate/picker.date.js',
		'/vendor/pickadate/legacy.js',
		'/vendor/sweetalert.min.js',
		'/app.js',
	], 'public/js/app.js');
});