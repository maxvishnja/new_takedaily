<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href="{{ asset('/public/css/app.css') }}" rel="stylesheet" type="text/css"/>
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
</style>

<body>
<?php
	$cur= 0;
?>
@foreach($printables as $printable)
	<?php $cur++; ?>
	<div class="print" style="width: 210mm; height: 290mm;overflow: hidden">
		<div style="width: 174mm;">
			<div style="width: 174mm; height: 240mm;">
				<div style="padding: 10mm 7mm; position: relative">
					{!! $printable['sticker'] !!}
				</div>
			</div>

			<div style="width: 174mm;height: 57mm;">
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
