@extends('layouts.admin')

@section('content')
	<div class="module">
		<div class="module-head">
			<h3 class="pull-left">Ordreinformation (#{{ $order->getPaddedId() }})</h3>
			<span style="margin-left: 10px;" class="label pull-left label-{{ $order->stateToColor() }}">{{ $order->state }}</span>

			<div class="btn-group pull-right">
				<a class="btn btn-info" href="{{ URL::action('Dashboard\OrderController@edit', [ 'id' => $order->id ]) }}"><i class="icon-pencil"></i>
					Rediger</a>

				@if($order->state == 'paid' )
					<a class="btn btn-default" href="{{ URL::action('Dashboard\OrderController@markSent', [ 'id' => $order->id ]) }}"><i class="icon-truck"></i>
						Marker som sendt</a>

					<a class="btn btn-default" href="{{ URL::action('Dashboard\OrderController@edit', [ 'id' => $order->id ]) }}"><i class="icon-money"></i>
						Refunder</a> <!-- todo -->
				@endif
			</div>
			<div class="clear"></div>
		</div>

		<div class="module-body">
			<div class="row">
				<div class="span4">
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
				</div>

				<div class="span4">
					<h3>Kunde #{{ $order->customer->id }}
						<small><a href="{{ URL::action('Dashboard\CustomerController@show', [$order->customer->id]) }}"><i class="icon icon-eye-open"></i></a></small>
					</h3>
					Køn: {{ $order->customer->getGender() }}<br/>
					Nyhedsbreve: {{ $order->customer->acceptNewsletters() ? 'Ja' : 'Nej' }}<br/>
					Fødselsdag: {{ $order->customer->getBirthday() }} ({{ $order->customer->getAge() }} år)<br/>
					Antal ordre: {{ $order->customer->getOrderCount() }}
				</div>
			</div>
			<hr/>
			<table class="table table-striped">
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
		</div>
	</div><!--/.module-->
@stop