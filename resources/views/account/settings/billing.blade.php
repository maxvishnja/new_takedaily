@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-billing')

@section('title', trans('account.settings_billing.title'))

@section('content')
	<h1>{{ trans('account.settings_billing.header') }}</h1>
	@if(count($sources) > 0)
		@foreach($sources as $source)
			@include("account.settings.payment_methods.{$method}", [$source])
		@endforeach
	@endif

	@if($plan->payment_method === 'stripe')
		<div class="clear"></div>

		<a href="#" class="button button--medium button--green">Skift betalingsmetode</a>

		<form action="{{ url()->action('AccountController@updatePaymentMethod') }}" id="checkout-form" method="post" class="m-t-20">
			@include('includes.payment.method', ['giftcard' => false, 'paymentMethods' => \App\Apricot\Helpers\PaymentMethods::getAcceptedMethodsForCountry( \App::getLocale() )])

			<button id="button-submit" class="button button--green button--large">GO!</button>
		</form>
	@endif
@endsection