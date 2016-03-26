@extends('layouts.account')

@section('pageClass', 'account account-transactions account-transaction')

@section('title', "Levering #{$order->getPaddedId()} - Take Daily")

@section('content')
	<h1>Levering #{{ $order->getPaddedId() }}</h1>

	<h3>Leveringsadresse</h3>
	@if($order->shipping_company != '')
		{{ $order->shipping_company }}<br/>
		c/o: {{ $order->shipping_name }}<br/>
	@else
		{{ $order->shipping_name }}<br/>
	@endif
	{{ $order->shipping_street }}<br/>
	{{ $order->shipping_city }}, {{ $order->shipping_zipcode }}<br/>
	{{ $order->shipping_country }}<br/>

	<table class="table table--full text-left table--striped m-t-40">
		<thead>
		@if(count($order->lines) > 0)
			<tr>
				<th>Beskrivelse</th>
				<th>Beløb</th>
				<th>Moms</th>
				<th>Total</th>
			</tr>
		@endif
		</thead>

		<tbody>
		@foreach($order->lines as $line)
			<tr>
				<td>{{ trans("products.{$line->description}") }}</td>
				<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($line->amount, true) }} kr.</td>
				<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($line->tax_amount, true) }} kr.</td>
				<td><strong>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($line->total_amount, true) }} kr.</strong></td>
			</tr>
		@endforeach
		</tbody>

		<tfoot>
		<tr>
			<td colspan="2" style="border: none;"></td>
			<td style="border: none; text-align: right;">Subtotal</td>
			<td style="border: none;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->sub_total, true) }} kr.</td>
		</tr>

		<tr>
			<td colspan="2" style="border: none;"></td>
			<td style="border: none; text-align: right;">Fragt</td>
			<td style="border: none;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->total_shipping, true) }} kr.</td>
		</tr>

		<tr>
			<td colspan="2" style="border: none;"></td>
			<td style="border: none; text-align: right;">Moms</td>
			<td style="border: none;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->total_taxes, true) }} kr.</td>
		</tr>

		<tr>
			<td colspan="2" style="border: none;"></td>
			<td style="border: none; text-align: right; font-weight: bold;">Total</td>
			<td style="border: none; font-weight: bold;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->total, true) }} kr.</td>
		</tr>
		</tfoot>
	</table>
@endsection