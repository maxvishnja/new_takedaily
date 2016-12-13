<div class="payment_method_card">
	<span class="icon icon-card-{{ strtolower($source->brand) }}"></span>
	<h3>···· ···· ···· {{ $source->last4 }}</h3>
	<p>{{ trans('account.settings_billing.card-exp') }} {{ str_pad($source->exp_month, 2, 0, STR_PAD_LEFT) }}
		/{{ $source->exp_year }}</p>
</div>