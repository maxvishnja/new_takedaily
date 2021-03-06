<div class="promo-section">
	{{--<div>--}}
		{{--<h4>{{ trans('promo.customer_service') }}</h4>--}}
		{{--<p>{{ trans('promo.need-help') }}</p>--}}
		{{--<p>{{ trans('promo.contact') }}<br/>--}}
			{{--{{ trans('promo.opening-hours') }}</p>--}}
	{{--</div>--}}

	<div class="m-b-20" style="margin-top: -20px">
		<h4>{{ trans('promo.advantages') }}</h4>
		<ul style="line-height: 2">
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

	<div class="m-b-40">
		<h4>{{ trans('promo.trustpilot') }}</h4>
		<a target="_blank" rel="nofollow" href="https://trustpilot.com/review/{{ Request::getHost() }}"><img src="{{ asset('/images/tp/5.png') }}" height="24" alt="Trustpilot"></a>
	</div>
</div>