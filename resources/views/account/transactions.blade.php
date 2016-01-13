@extends('layouts.account')

@section('pageClass', 'account account-transactions')

@section('content')
	<h1>Dine ordre</h1>
	@if($orders->count() == 0 )
		<h3>Ingen ordre fundet</h3>
	@else
		@foreach($orders as $order)
			<span># {{ $order->getPaddedId() }}</span>
			<a href="{{URL::action('AccountController@getTransaction', [ 'id' => $order->id ]) }}">Vis</a>
			<strong>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true) }} kr.</strong>
			<hr/>
		@endforeach
	@endif
@endsection