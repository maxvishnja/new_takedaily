@extends('layouts.admin')

@section('content')
{{--
	<div class="btn-group pull-right" style="margin-bottom:20px">
		<a class="btn btn-default"
		   href="{{ URL::action('Dashboard\OrderController@download', [ 'id' => $order->id ]) }}"><i
				class="icon-download"></i>
			Download label</a>

		<a class="btn btn-default"
		   href="{{ URL::action('Dashboard\OrderController@downloadSticker', [ 'id' => $order->id ]) }}"><i
				class="icon-download"></i>
			Download sticker</a>
	</div>--}}

	<div class="clear"></div>

	<div class="module">
		<div class="module-head">
			<h3 class="pull-left">Order (#{{ $order->getPaddedId() }})</h3>
			<span style="margin-left: 10px;"
				  class="label pull-left label-{{ $order->stateToColor() }}">{{ $order->state }}</span>

			<div class="btn-group pull-right">
				<a class="btn btn-default" onclick="javascript:history.back();">Back</a>
				<a class="btn btn-info"
				   href="{{ URL::action('Dashboard\OrderController@edit', [ 'id' => $order->id ]) }}"><i
						class="icon-pencil"></i>
					Edit</a>

				@if($order->state == 'paid' )
					<a class="btn btn-default"
					   href="{{ URL::action('Dashboard\OrderController@markSent', [ 'id' => $order->id ]) }}"><i
							class="icon-truck"></i>
						Mark as sent</a>

					<a class="btn btn-default"
					   href="{{ URL::action('Dashboard\OrderController@refund', [ 'id' => $order->id ]) }}"><i
							class="icon-money"></i>
						Refund</a>
				@endif
			</div>
			<div class="clear"></div>
		</div>

		<div class="module-body">
			<div class="row">
				<div class="span4">
					<h3>Deliveryaddress</h3>
					@if($order->shipping_company != '')
						{{ $order->shipping_company }}<br/>
						c/o: {{ $order->shipping_name }}<br/>
					@else
						{{ $order->shipping_name }}<br/>
					@endif
					{{ $order->shipping_street }}, {{$order->customer->getCustomerAttribute('address_number')}}<br/>
					{{ $order->shipping_city }}, {{ $order->shipping_zipcode }}<br/>
					{{ trans('countries.' . $order->shipping_country) }}<br/>
				</div>

				<div class="span4">
					<h3>Customer #{{ $order->customer->id }}
						<small><a href="{{ URL::action('Dashboard\CustomerController@show', [$order->customer->id]) }}"><i
									class="icon icon-eye-open"></i></a></small>
					</h3>
					Gender: {{ ((string) $order->customer->getCustomerAttribute('user_data.gender', '1') === '1') ? 'Male' : 'Female' }}<br/>
					Birthdate: {{ $order->customer->getBirthday() }} ({{ $order->customer->getAge() }} år)<br/>
					Count orders: {{ $order->customer->getOrderCount() }}
				</div>
			</div>
			<hr/>
			<table class="table table-striped">
				<thead>
				@if(count($order->lines) > 0)
					<tr>
						<th>Description</th>
						<th>Coupon</th>
						<th>Amount</th>
						<th>Taxes</th>
						<th>Total</th>
					</tr>
				@endif
				</thead>

				<tbody>
				@foreach($order->lines as $line)
					<tr>
						<td>{{ trans("products.{$line->description}") }}</td>
						<td>{{ $coupon }}</td>
						<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($line->amount, true) }} {{ $order->currency }}</td>
						<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($line->tax_amount, true) }} {{ $order->currency }}</td>
						<td>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($line->total_amount, true) }} {{ $order->currency }}</td>
					</tr>
				@endforeach
				</tbody>

				<tfoot>
				<tr>
					<td rowspan="4">@if($order->getVitamins())
							@foreach($order->getVitamins() as $vitamin)

								{{--· {{\DB::table('ltm_translations')->where([--}}
								{{--['group', '=', 'pill-names'],--}}
								{{--['locale', '=', App::getLocale()],--}}
								{{--['key', '=', strtolower(\App\Vitamin::remember(60)->find($vitamin)->code)],--}}
								{{--])->value('value')}}--}}
								 {{ \App\Apricot\Helpers\PillName::get(strtolower(\App\Vitamin::remember(60)->find($vitamin)->code)) }}
								<br/>
							@endforeach
						@else
							Not found vitamins
						@endif</td>
					<td colspan="2" style="border: none;"></td>
					<td style="border: none; text-align: right;">Subtotal</td>
					<td style="border: none;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->sub_total, true) }}
						{{ $order->currency }}
					</td>
				</tr>

				<tr>
					<td colspan="2" style="border: none;"></td>
					<td style="border: none; text-align: right;">Shipping</td>
					<td style="border: none;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->total_shipping, true) }}
						{{ $order->currency }}
					</td>
				</tr>

				<tr>
					<td colspan="2" style="border: none;"></td>
					<td style="border: none; text-align: right;">Taxes</td>
					<td style="border: none;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->total_taxes, true) }}
						{{ $order->currency }}
					</td>
				</tr>

				<tr>
					<td colspan="2" style="border: none;"></td>
					<td style="border: none; text-align: right; font-weight: bold;">Total</td>
					<td style="border: none; font-weight: bold;">{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->total, true) }}
						{{ $order->currency }}
					</td>
				</tr>
				</tfoot>
			</table>
		</div>{{-- todo format currency using trans general --}}
	</div><!--/.module-->
@stop