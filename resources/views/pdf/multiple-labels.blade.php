<html>{{-- todo fix multiplage when only single sticker... --}}
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="{{ ('/public/css/app.css') }}" rel="stylesheet" type="text/css"/>
	<style>
		th, td, p, div, b {
			margin: 0;
			padding: 0;
			page-break-inside: avoid;
		}

		* {
			padding: 0;
			margin: 0;
			page-break-after: avoid;
			page-break-before: avoid;
			page-break-inside: avoid;
		}

		html {
			line-height: 1;
			margin: 0;
			width: 570pt;
			height: 262pt;
			overflow: hidden;
			page-break-inside: avoid;
		}

		@page {
			size: 570pt 262pt;
			margin: 0;
			padding: 0;
		}

		body {
			background: #fff url(/images/label-logo-bg.jpg) no-repeat left center;
			background-size: cover;
			page-break-inside: avoid;
			font-family: 'Montserrat', sans-serif;
			padding: 0 !important;
		}

		table, table tr, table tbody {
			width: 100%;
			page-break-inside: avoid;
			page-break-after: avoid;
			page-break-before: avoid;
		}

		thead:before, thead:after {
			display: none;
			page-break-after: avoid;
			page-break-before: avoid;
			page-break-inside: avoid;
		}

		tbody:before, tbody:after {
			display: none;
			page-break-after: avoid;
			page-break-before: avoid;
			page-break-inside: avoid;
		}
	</style>
</head>
<body>
@foreach($labels as $label)
	{!! $label !!}
	<div style="break-after: always;page-break-after: always;"></div>
@endforeach
</body>
</html>