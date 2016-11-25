@extends('layouts.account')

@section('pageClass', 'account page-account-home')

@section('title', trans('account.personal.title'))

@section('content')
	@foreach(Auth::user()->getCustomer()->getVitaminModels() as $vitamin)
		<span class="icon pill-{{ $vitamin->code }}"></span>
	@endforeach
@endsection