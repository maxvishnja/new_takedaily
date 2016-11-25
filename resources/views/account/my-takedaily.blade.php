@extends('layouts.account')

@section('pageClass', 'account page-account-home')

@section('title', trans('account.personal.title'))

@section('content')
	@if(Auth::user()->getCustomer()->hasNewRecommendations())
		<div class="card m-b-50">
			<div class="card-body">
				<h2 class="card_title">{{ trans('account.settings_subscription.new-recommendation.title') }}</h2>
				<hr>
				<p>{{ trans('account.settings_subscription.new-recommendation.text') }}</p>
				<a href="{{ URL::action('AccountController@updateVitamins') }}" class="button button--green button--large">{{ trans('account.settings_subscription.new-recommendation.btn') }}</a>
			</div>
		</div>
	@endif

	@foreach(Auth::user()->getCustomer()->getVitaminModels() as $vitamin)
		<span class="icon pill-{{ $vitamin->code }}"></span>
	@endforeach
@endsection