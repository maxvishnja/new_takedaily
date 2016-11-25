@extends('layouts.account')

@section('pageClass', 'account page-account-home')

@section('title', trans('account.personal.title'))

@section('content')
	<h1>{{ trans('account.home.header') }}</h1>

	@foreach(Auth::user()->getCustomer()->getVitaminModels() as $vitamin)
		<span class="icon pill-{{ $vitamin->code }}"></span>
	@endforeach
	<div class="m-t-10"><a href="/flow" class="button button--green">{{ trans('account.home.button-change') }}</a></div>
@endsection