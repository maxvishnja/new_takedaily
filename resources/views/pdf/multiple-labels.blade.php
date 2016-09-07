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
<table style="width: 570pt; margin: 0; padding: 0;">
	<tbody style="width: 100%;">
	<tr style="width: 100%;">
		<td style="width: 310pt;">
			<table style="margin: 50pt 30pt 10pt; width: 260pt; height: 180pt;">
				<tbody style="width: 100%;">
				@foreach($customer->getVitaminModels() as $vitamine)
					<tr style="width: 100%">
						<td style="padding: 5pt 0;width: 100%; text-align: left; color: #444; font-size: 15pt;">{{ $vitamine->code }}</td>
					</tr>
				@endforeach

				<tr style="width: 100%">
					<td colspan="2" style="width: 100%;">
						<br/>
						<br/>
						<div style="margin: 0 auto;width: 226pt; height: 40pt;">
							<img style="width: 226pt; height: 40pt;" src="{{ asset('/images/pdf-logo.png') }}"/>
						</div>
					</td>
				</tr>
				</tbody>
			</table>
		</td>

		<td style="width: 260pt;color: #333; vertical-align: top">
			<table style="margin: 50pt 0 10pt; width: 200pt; height: 180pt;">
				<tbody style="width: 100%;">
				<tr style="width: 100%;">
					<td style="color: #333;font-size: 16pt;padding: 5pt 0;width: 100%; text-align: right;">
						<strong>{{ $customer->getName() }}</strong></td>
				</tr>

				<tr style="width: 100%;">
					<td style="color: #333;font-size: 16pt;padding: 5pt 0;width: 100%; text-align: right;">{{ $customer->getCustomerAttribute('address_line1') }}</td>
				</tr>

				<tr style="width: 100%;">
					<td style="color: #333;font-size: 16pt;padding: 5pt 0;width: 100%; text-align: right;">{{ $customer->getCustomerAttribute('address_postal') }}, {{ $customer->getCustomerAttribute('address_city') }}</td>
				</tr>

				<tr style="width: 100%;">
					<td style="color: #333;font-size: 16pt;padding: 5pt 0;width: 100%; text-align: right;">{{ ucfirst($customer->getCustomerAttribute('address_country')) }}</td>
				</tr>

				<tr style="width: 100%; text-align: right;">
					<td style="width: 100%; text-align: right; padding-top: 20pt;">
						@foreach($customer->getVitaminModels() as $vitamine)
							<img style="width: 29pt; height: 30pt;"
								 src="{{ asset('/images/icons/pills/pill-' . $vitamine->code . '@2x.png') }}"/>
						@endforeach
					</td>
				</tr>
				</tbody>
			</table>
		</td>
	</tr>
	</tbody>
</table>

{{--<div style="break-after: always;page-break-after: always;"></div>--}}