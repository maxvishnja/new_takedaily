<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="{{ elixir('css/print.css') }}" rel="stylesheet" type="text/css"/>
</head>
<style>
	.pb {
		page-break-after: always;
	}

	.print:last-child {
		page-break-after: auto;
	}

	@page {
		margin: 0;
		size: 297mm 210mm;
	}

	th, td, p, div, b {
		margin: 0;
		padding: 0;
	}

	body {
		background: #fff;
		font-family: 'Montserrat', sans-serif;
		padding: 0 !important;
		margin: 0;
	}

	* {
		padding: 0;
		margin: 0;
		box-sizing: border-box;
	}

	html {
		line-height: 1;
		margin: 0;
		padding: 0;
	}

	/*
	 * Sticker
	 */
	.vitamins {
		display: flex;
		flex-direction: column;
		flex-wrap: wrap;
		height: 210mm;
		width: 166mm;
		position: relative;
	}

	.vitamins:after {
		content: "";
		display: block;
		background: #CCE9E0;
		left: 50%;
		margin-left: -1px;
		position: absolute;
		top: 0;
		height: 100%;
		width: 1px;
	}

	.vitamins .vitamin {
		width: 50%;
		padding: 2pt;
	}

	.vitamins .vitamin {
		border-bottom: 1px solid #CCE9E0;
	}

	.vitamins .vitamin:last-child {
		border-bottom: none
	}

	.vitamin thead th,
	.vitamin tbody td {
		/*padding-bottom: 1pt;*/
	}

	/*
	 * Label
	 */
	address {
		font-style: normal;
		color: #333;
		font-size: 18pt;
		line-height: 1.3;
		text-transform: uppercase;
	}
</style>

<body>
<?php
$cur = 0;
?>
@foreach($printables as $printable)
	<?php
		App::setLocale($printable['locale']);
		$cur ++;
	?>
	<div class="print" style="width: 210mm; height: 297mm;">
		<div style="width: 174mm; height: 297mm; position: relative">
			<div style="width: 174mm; height: 240mm;">
				<div style="padding: 4mm; position: relative">
					{!! $printable['sticker'] !!}
				</div>
			</div>

			<div style="width: 174mm;height: 57mm; position: absolute; bottom: 0">
				<div style="padding: 3.5mm 7mm; position: relative">
					{!! $printable['label'] !!}
				</div>
			</div>
		</div>
	</div>

	@if(count($printables) != $cur)
		<div class="pb"></div>
	@endif
@endforeach

<script>
	window.print();
</script>
</body>
</html>
