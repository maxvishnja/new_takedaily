<div class="payment_method_card">
	<h3>{{ $source->method }}</h3>{{-- todo translate this (directdebit = card, or something) --}}
	@foreach($source->details as $detail)
		<p>{{ $detail }}</p>
	@endforeach

	<div class="m-t-30">
		<a href="{{ URL::action('AccountController@getSettingsBillingRemove') }}"
		   class="button button--small button--light button--rounded">{{ trans('account.settings_billing.button-remove-text') }}</a>
	</div>
</div>