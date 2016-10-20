<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
	<title>@yield('title', 'TakeDaily')</title>

	<meta charset="UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, user-scalable=no, maximum-scale=1.0"/>

	<link href="{{ asset('css/app.css') }}" rel="stylesheet"/>

	<link rel="shortcut icon" type="image/png" href="/favicon.png"/>
	<link rel="icon" type="image/png" href="/favicon.png"/>

	<!-- todo add meta image from page.blade.php -->

	<!--[if lt IE 9]>
	<script src="/js/respond.min.js"></script>
	<script src="/js/html5shiv.min.js"></script>
	<![endif]-->

    <script src="/js/modernizr-custom.min.js"></script>
</head>

<body class="@yield('pageClass', 'index')">