@extends('layouts.account')

@section('pageClass', 'account page-account-home')

@section('title', trans('account.personal.title'))

@section('content')
	<h1>{{ trans('account.home.header') }} - {{ trans('account.settings_subscription.plan.' . ( $plan->isActive() ? 'active' : 'cancelled' ) ) }}</h1>


	<h2>{!! trans('account.settings_subscription.total', [ 'amount' => trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($plan->getTotal(), true), 'currency' => $plan->currency])]) !!}</h2>


	@if( $plan->isActive() )
		<p>{{ trans('account.settings_subscription.next-date', ['date' => Date::createFromFormat('Y-m-d H:i:s', $plan->getRebillAt())->format('j. M Y H:i') ]) }}</p>
	@endif



	@foreach(Auth::user()->getCustomer()->getVitaminModels() as $vitamin)
		<div class="new_vitamin_item">

			<div class="pill_section">
				<span class="icon pill-{{ strtolower($vitamin->code) }}"></span>
			</div>

			<div class="content_section">
				<strong>
					{{ $vitamin->name }}
				</strong>
				<p>{!! trans('label-' . strtolower($vitamin->code) . '.web_description') !!}</p>
			</div>
		</div>
	@endforeach

	<div class="m-t-10"><a href="/flow" class="button button--green">{{ trans('account.home.button-change') }}</a></div>

	@if($orders->count() > 0 )
		<hr>
		<h1>{{ trans('account.transactions.header') }}</h1>
		<table class="table table--full table--striped text-left table--responsive">
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
					<td data-th="#">#{{ $order->getPaddedId() }}</td>
					<td data-th="{{ trans('account.transactions.table.date') }}">{{ \Jenssegers\Date\Date::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('j. M Y H:i') }}</td>
					<td data-th="{{ trans('account.transactions.table.amount') }}"><strong>{{ trans('general.money-fixed-currency', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true), 'currency' => $order->currency]) }}</strong></td>
					<td data-th="{{ trans('account.transactions.table.status') }}"><span class="state-label state-label--{{ $order->state  }}">{{ trans("order.state.{$order->state}") }}</span></td>
					<td data-th="&nbsp;"><a href="{{URL::action('AccountController@getTransaction', [ 'id' => $order->id ]) }}" class="button button--small button--rounded button--grey">{{ trans('account.transactions.button-show-text') }}</a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@endif
@endsection