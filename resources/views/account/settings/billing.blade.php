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

		<a href="#" id="update_btn" class="button button--medium button--green">{{ trans('account.settings_billing.update') }}</a>

		<form action="{{ url()->action('AccountController@updatePaymentMethod') }}" id="checkout-form" method="post" class="m-t-20" style="display: none;">
			@include('includes.payment.method', ['giftcard' => false, 'paymentMethods' => \App\Apricot\Helpers\PaymentMethods::getAcceptedMethodsForCountry( \App::getLocale() )])

			<button id="button-submit" class="button button--green button--large">{{ trans('account.settings_billing.update') }}</button>

			{{csrf_field()}}
		</form>
	@endif
@endsection

@section('footer_scripts')
	<script>
		$("#update_btn").click(function(e)
		{
			e.preventDefault();

			$("#checkout-form").stop().slideToggle(200);
		});
	</script>
@endsection