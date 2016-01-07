@extends('layouts.account')

@section('pageClass', 'account account-transactions')

@section('content')
	@foreach($orders as $order)
		{{ $order }}
		<hr/>
	@endforeach
@endsection