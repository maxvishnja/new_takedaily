<div class="promo-section">
	<div>
		<h4>{{ trans('promo.customer_service') }}</h4>
		<p>{{ trans('promo.need-help') }}</p>
		<p>{{ trans('promo.contact') }}<br/>
			{{ trans('promo.opening-hours') }}</p>
	</div>

	<div class="m-t-30">
		<h4>{{ trans('promo.advantages') }}</h4>
		<ul>
			@if(trans('promo.custom-fit') != '')
				<li><span class="icon icon-check"></span> {{ trans('promo.custom-fit') }}</li>
			@endif

			@if(trans('promo.custom-fit') != '')
				<li><span class="icon icon-check"></span> {{ trans('promo.free-shipping') }}</li>
			@endif

			@if(trans('promo.custom-fit') != '')
				<li><span class="icon icon-check"></span> {{ trans('promo.no-cuffs') }}</li>
			@endif

			@if(trans('promo.custom-fit') != '')
				<li><span class="icon icon-check"></span> {{ trans('promo.direct-delivery') }}</li>
			@endif
		</ul>
	</div>

	<div class="m-t-20">
		<p>Vores kunder elsker os!</p>
		<a target="_blank" rel="nofollow" href="https://trustpilot.com/review/{{ Request::getHost() }}"><img src="{{ asset('/images/tp/4.png') }}" height="24" alt="Trustpilot"></a>
	</div>
</div>