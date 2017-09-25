<?php \App::setLocale( $locale ); ?>
	<!DOCTYPE html>
<html lang="{{ \App::getLocale() }}">
<head>
	<title>Giftcard</title>
	<meta charset="UTF-8"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="{{ elixir('css/print.css') }}">
	<style>
		@page {
			width: 530px;
			height: 360px;
			margin: 0;
			padding: 0;
		}

		body, html {
			font-family: "Proxima Nova", "Open Sans", Montserrat, Arial, sans-serif;
			background: #88E2C4;
			margin: 0;
			padding: 0;

		}

		.content {
			padding: 140pt 0 100pt;
			text-align: center;
		}

		h1 {
			font-weight: 600;
			font-size: 30pt;
			color: #198562;
			letter-spacing: 2pt;
			text-transform: uppercase;
			margin: 0;
		}

		span {
			font-weight: 600;
			font-size: 16pt;
			color: #3AAC87;
			letter-spacing: 1pt;
			text-transform: uppercase;
			display: block;
			margin: 0;
		}

		.logo {
			margin-left: 30pt;
		}
	</style>
</head>

<body>
<div class="content">
	<span>{{ trans('giftcard.your-giftcard') }}</span>
	<h1>{{ $token }}</h1>
</div>
<img class="logo" src="{{ asset('/images/giftcardpdf-logo.png') }}"/>
</body>
</html>