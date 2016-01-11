@extends('layouts.account')

@section('pageClass', 'account account-transactions')

@section('content')
	@foreach($orders as $order)
		<span># {{ $order->getPaddedId() }}</span>
		<a href="{{URL::action('AccountController@getTransaction', [ 'id' => $order->id ]) }}">Vis</a>
		<strong>{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true) }} kr.</strong>
		<hr/>
	@endforeach
@endsection