@extends('layouts.account')
{{-- todo fix this form; maybe use same code as from checkout (include) --}}
{{-- todo find a way to add Mollie method --}}
@section('pageClass', 'account account-settings account-settings-billing account-settings-billing-add')

@section('title', trans('account.settings_billing.add.title'))

@section('content')
	<h1>{{ trans('account.settings_billing.add.header') }}</h1>

	<form action="{{ URL::action('AccountController@postSettingsBillingAdd') }}" method="post" id="checkout-form">
		@include('includes.payment.method')

		<div class="row">
			<div class="col-md-6 m-b-10">
				<div class="form-button-submit-holder">
					<button class="button button--huge button--green button--full button--rounded" type="submit" id="button-submit">{{ trans('account.settings_billing.add.button-add-text') }}</button>

					<div class="clear"></div>
				</div>
			</div>

			<div class="col-md-6">
				<a href="{{ URL::action('AccountController@getSettingsBilling') }}" class="button button--huge button--white button--full button--rounded">{{ trans('account.settings_billing.add.button-cancel-text') }}</a>
			</div>
		</div>
	</form>

@endsection