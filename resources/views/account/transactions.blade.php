@extends('layouts.account')

@section('pageClass', 'account account-transactions')

@section('title', 'Leveringer - Take Daily')

@section('content')
	<h1>Dine leveringer</h1>
	@if($orders->count() == 0 )
		<h3>Ingen leveringer fundet</h3>
	@else
		<table class="table table--full table--striped text-left">
			<thead>
				<tr>
					<th>#</th>
					<th>Dato</th>
					<th>Beløb</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($orders as $order)
				<tr>
					<td># {{ $order->getPaddedId() }}</td>
					<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y H:i') }}</td>
					<td><strong>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true) }} kr.</strong></td>
					<td><span class="state-label state-label--{{ $order->state  }}">{{ trans("order.state.{$order->state}") }}</span></td>
					<td><a href="{{URL::action('AccountController@getTransaction', [ 'id' => $order->id ]) }}" class="button button--small button--rounded button--grey">Vis</a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@endif
@endsection