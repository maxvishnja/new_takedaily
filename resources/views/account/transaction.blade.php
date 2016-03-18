@extends('layouts.account')

@section('pageClass', 'account account-transactions account-transaction')

@section('content')
	<h1>Levering #{{ $order->getPaddedId() }}</h1>

	<h3>Leveringsadresse</h3>
	@if($order->customer->getCustomerAttribute('company'))
		{{ $order->customer->getCustomerAttribute('company') }}<br/>
		c/o: {{ $order->customer->getName() }}<br/>
	@else
		{{ $order->customer->getName() }}<br/>
	@endif
	{{ $order->customer->getCustomerAttribute('address_line1') }}<br/>
	@if($order->customer->getCustomerAttribute('address_line2'))
		{{ $order->customer->getCustomerAttribute('address_line2') }}<br/>
	@endif
	{{ $order->customer->getCustomerAttribute('address_city') }}, {{ $order->customer->getCustomerAttribute('address_postal') }}<br/>
	@if($order->customer->getCustomerAttribute('address_state'))
		{{ $order->customer->getCustomerAttribute('address_state') }},
	@endif
	{{ $order->customer->getCustomerAttribute('address_country') }}<br/>

	<table class="table table--full table--striped">
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
				<td>{{ $line->description }}</td>
				<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($line->amount, true) }} kr.</td>
				<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($line->tax_amount, true) }} kr.</td>
				<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($line->total_amount, true) }} kr.</td>
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
			<td style="border: none; text-align: right;">Heraf moms</td>
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