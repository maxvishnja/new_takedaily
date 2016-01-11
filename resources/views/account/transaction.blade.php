@extends('layouts.account')

@section('pageClass', 'account account-transactions account-transaction')

@section('content')
	<h1>Ordre #{{ $order->getPaddedId() }}</h1>
	Total: {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($order->getTotal(), true) }}
@endsection