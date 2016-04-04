@extends('layouts.account')

@section('pageClass', 'account account-transactions')

@section('title', trans('account.transactions.title'))

@section('content')
	<h1>{{ trans('account.transactions.header') }}</h1>
	@if($orders->count() == 0 )
		<h3>{{ trans('account.transactions.no-results') }}</h3>
	@else
		<table class="table table--full table--striped text-left">
			<thead>
				<tr>
					<th>#</th>
					<th>{{ trans('account.transactions.table.date') }}</th>
					<th>{{ trans('account.transactions.table.amount') }}</th>
					<th>{{ trans('account.transactions.table.status') }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($orders as $order)
				<tr>
					<td>#{{ $order->getPaddedId() }}</td>
					<td>{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y H:i') }}</td>
					<td><strong>{{ trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true)]) }}</strong></td>
					<td><span class="state-label state-label--{{ $order->state  }}">{{ trans("order.state.{$order->state}") }}</span></td>
					<td><a href="{{URL::action('AccountController@getTransaction', [ 'id' => $order->id ]) }}" class="button button--small button--rounded button--grey">{{ trans('account.transactions.button-show-text') }}</a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@endif
@endsection