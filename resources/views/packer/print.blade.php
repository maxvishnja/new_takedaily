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
		/*margin: 0;*/
		/*size: portrait;*/
		/*size: 210mm 297mm;*/
		/*size: 297mm 210mm;*/
		size: A4;
		margin: 0;
	}

	@media screen {
		* {
			display: none
		}
	}

	@media print {
		html, body {
			width: 173mm;
			height: 277mm;
		}

		/* ... the rest of the rules ... */
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
		height: 200mm;
		width: 173mm;
		position: relative;

	}

	.vitamins:after {
		content: "";
		display: block;
		border-right: 1px solid #CCE9E0;
		left: 50%;
		margin-left: -1px;
		position: absolute;
		top: 0;
		height: 100%;
		width: 1px;
	}

	.vitamins .vitamin {
		width: 50%;
		padding: 5pt 7pt;
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
		line-height: 1.15;
		text-transform: uppercase;
	}
</style>

<body>
<?php
$cur = 0;
?>
@foreach($printables as $printable)
	<?php
	App::setLocale( $printable['locale'] );
	$cur ++;
	?>
	<div class="print" style="left: 0; top: {{ ($cur-1)*100 }}%; width: 173mm; ">
		<div style="width: 99.8571428571429%; position: relative;  height: 100%;">
			<div style="width: 99.8571428571429%; position: relative; height: 235mm;  top: 0; left: 0;  overflow: hidden;">
				{!! $printable['sticker'] !!}
			</div>

			<div style="width: 100%; height: 50mm; position: relative;  left: 0;  overflow: hidden;">
				<div style="padding: 0pt 10pt; position: relative; margin-top:40pt">
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
