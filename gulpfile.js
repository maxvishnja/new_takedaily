var elixir = require('laravel-elixir');

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
