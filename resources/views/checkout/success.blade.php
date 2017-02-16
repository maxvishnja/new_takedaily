@extends('layouts.app')

@section('pageClass', 'page-checkout-success')

@section('mainClasses', 'm-b-50 m-t-50')
@section('title', trans('checkout.success.page-title'))

@section('content')
	<div class="container">

		@if(session('upsell', false) && Session::has('upsell_token'))
			<div class="text-center">
				<h2>{{ trans('success.upsell') }}</h2>
				<form method="post" action="{{ URL::route('flow-upsell') }}">
					<button type="submit" class="button button--green button--medium button--rounded">{{ trans('success.upsell-btn') }}</button>

					<input type="hidden" name="upsell_token" value="{{ Session::get('upsell_token') }}"/>
					{{ csrf_field() }}
				</form>
			</div>

			<hr/>
		@endif

		@if( isset($vitamins) )
			<div class="print_label print_label--shadow hidden-xs">
				<div class="print_label_left">

					@foreach($vitamins as $vitamin)
						<div class="print_label_line">
							<div class="print_label_line_full">
								{{ $vitamin->name }}
							</div>
						</div>
					@endforeach

					<div class="text-center">
						<span class="logo logo-color m-t-50"></span>
					</div>
				</div>
				<div class="print_label_right text-right">
					<div class="print_label_info_line"><strong>{{ Auth::user()->getName() }}</strong></div>
					<div class="print_label_info_line">{{ Auth::user()->getCustomer()->getCustomerAttribute('address_line1') }}</div>
					<div class="print_label_info_line">{{ Auth::user()->getCustomer()->getCustomerAttribute('address_postal') }}
						, {{ Auth::user()->getCustomer()->getCustomerAttribute('address_city') }}</div>
					<div class="print_label_info_line">{{ trans('countries.' . Auth::user()->getCustomer()->getCustomerAttribute('address_country')) }}</div>


					<div class="m-t-50">
						@foreach($vitamins as $vitamin)
							<div style="display: inline-block;" class="m-t-15 icon pill-{{ $vitamin->code }}"></div>
						@endforeach
					</div>
				</div>

				<div class="clear"></div>
			</div>

			<div class="text-center">
				<h1>{{ trans('checkout.success.title') }}</h1>
				<p>{{ trans('checkout.success.text') }}</p>

				<a href="/account" class="button button--green button--rounded button--medium">{{ trans('checkout.success.button-text') }}</a>
			</div>
		@endif

		@if(isset($giftcardToken))
			<div class="text-center">
				<h3>{{ trans('checkout.success.giftcard.title') }}</h3>
				<h1>{{ $giftcardToken }}</h1>
				<p>{{ trans('checkout.success.giftcard.text') }}</p>
			</div>
		@endif
	</div>

@endsection
@section('footer_scripts')
	@if(App::getLocale() == 'nl')
		<img src="http://oa1.nl/m/5824/19fa5023ff43b6545d455e24a6a475f880acd6a1/?transactie_id={{$user_email}}" style="width: 1px; height: 1px; border: 0px;">
	@endif
@endsection

@section('tracking-scripts')
	<script>
		fbq('track', 'Purchase', {value: '{{ session('order_price', '0.00') }}', currency: '{{ session('order_currency', 'EUR') }}'});

		@if(Auth::check())
			fbq('track', 'CompleteRegistration');
		@endif
	</script>

<noscript>

	<img src="//dk.cpdelivery.com/sad/m/takedaily_track_2017_01/track.php" width="1" height="1" border="0" alt="" />

		</noscript>

	<script src="https://online.adservicemedia.dk/cgi-bin/API/ConversionService/js?camp_id=6123&order_id={{$order_id}}" type="text/javascript"></script>
	<noscript>
		<img src="https://online.adservicemedia.dk/cgi-bin/API/ConversionService/p?camp_id=6123" width="1" height="1" border="0">
	</noscript>
@endsection