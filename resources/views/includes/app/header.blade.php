<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, user-scalable=no, maximum-scale=1.0"/>

	<title>TakeDaily</title>

	<link href="{{ asset('css/app.css') }}" rel="stylesheet"/>

	<link rel="shortcut icon" type="image/png" href="/favicon.png"/>
	<link rel="icon" type="image/png" href="/favicon.png"/>

	<!--[if lt IE 9]>
		<script src="/js/respond.min.js"></script> todo: Get these!
		<script src="/js/html5shiv.min.js"></script> todo: Get these!
	<![endif]-->
</head>
<body class="@yield('pageClass', 'index')">

@include('includes.app.nav')