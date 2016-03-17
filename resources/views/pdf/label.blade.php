<link href="{{ asset('/css/app.css') }}" rel="stylesheet" type="text/css"/>
<style>
	th, td, p, div, b { margin: 0; padding: 0; page-break-inside: avoid; }

	* {
		padding: 0;margin: 0;
		page-break-after: avoid;
		page-break-before: avoid;
		page-break-inside: avoid;
	}

	html { line-height: 1;margin: 0; width: 570px; height: 262px; overflow: hidden; page-break-inside: avoid; }

	@page {
		size: 570px 262px;
		margin: 0;
		padding: 0;
	}

	body {
		background: #fff url(/images/label-logo-bg.jpg) no-repeat left center; background-size: cover;
		page-break-inside: avoid;
		padding: 0 !important;
	}

	table, table tr, table tbody {
		width: 100%; page-break-inside: avoid;
		page-break-after: avoid;
		page-break-before: avoid;
	}

	thead:before, thead:after { display: none;
		page-break-after: avoid;
		page-break-before: avoid;
		page-break-inside: avoid; }

	tbody:before, tbody:after { display: none;
		page-break-after: avoid;
		page-break-before: avoid;
		page-break-inside: avoid; }
</style>
<table style="width: 570px; margin: 0; padding: 0;">
	<tbody style="width: 100%;">
	<tr style="width: 100%;">
		<td style="width: 310px;">
			<table style="margin: 50px 30px 10px; width: 260px; height: 180px;">
				<tbody style="width: 100%;">
				@foreach($customer->getCombinations() as $combinationKey => $combinationValue)
					<tr style="width: 100%">
						<td style="padding: 5px 0;width: 50%; color: #444; font-size: 15px;">{{ $combinationKey }}</td>
						<td style="padding: 5px 0;width: 50%; text-align: right; letter-spacing: 3px; color: #777; font-size: 14px;">{{ $combinationValue }}</td>
					</tr>
				@endforeach

				<tr style="width: 100%">
					<td colspan="2" style="width: 100%;">
						<br/>
						<br/>
						<div style="margin: 0 auto;" class="logo logo-color"></div>
					</td>
				</tr>
				</tbody>
			</table>
		</td>

		<td style="width: 260px; color: #333; vertical-align: top">
			<table style="margin: 50px 30px 10px; width: 200px; height: 180px;">
				<tbody style="width: 100%;">
				<tr style="width: 100%;">
					<td style="color: #333;font-size: 16px;padding: 5px 0;width: 100%; text-align: right;"><strong>{{ $customer->getName() }}</strong></td>
				</tr>

				<tr style="width: 100%;">
					<td style="color: #333;font-size: 16px;padding: 5px 0;width: 100%; text-align: right;">{{ $customer->getCustomerAttribute('address_line1') }}</td>
				</tr>

				<tr style="width: 100%;">
					<td style="color: #333;font-size: 16px;padding: 5px 0;width: 100%; text-align: right;">{{ $customer->getCustomerAttribute('address_postal') }}, {{ $customer->getCustomerAttribute('address_city') }}</td>
				</tr>

				<tr style="width: 100%;">
					<td style="color: #333;font-size: 16px;padding: 5px 0;width: 100%; text-align: right;">{{ $customer->getCustomerAttribute('address_country') }}</td>
				</tr>
				</tbody>
			</table>
		</td>
	</tr>
	</tbody>
</table>