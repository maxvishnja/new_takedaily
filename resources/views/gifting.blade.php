@extends('layouts.app')

@section('pageClass', 'gifting')

@section('title', trans('gifting.title'))
{{-- todo transalte --}}
@section('content')
	<div class="container text-center">
		<div class="gifting-block">
			<h1>{{ trans('gifting.title-element') }}</h1>
			<h2>{{ trans('gifting.subtitle') }}</h2>
			<form action="{{ url()->action('CheckoutController@getCheckout') }}" id="giftingForm" method="get">
				<div class="gifting-selectors">
					<label class="gifting-selector" for="months_input_1">
						<input type="radio" name="product_name" value="giftcard_1" id="months_input_1"/>
						<strong class="gifting-price">149 kr.</strong>{{-- todo get price from DB --}}
						<span class="gifting-months">{{ trans('gifting.giftcard_1') }}</span>

						<button class="button button--green button--full" type="button">{{ trans('gifting.select') }}</button>
					</label>

					<label class="gifting-selector" for="months_input_3">
						<input type="radio" name="product_name" value="giftcard_3" id="months_input_3"/>
						<strong class="gifting-price">447 kr.</strong>{{-- todo get price from DB --}}
						<span class="gifting-months">{{ trans('gifting.giftcard_3') }}</span>

						<button class="button button--green button--full" type="button">{{ trans('gifting.select') }}</button>
					</label>

					<label class="gifting-selector" for="months_input_6">
						<input type="radio" name="product_name" value="giftcard_6" id="months_input_6"/>
						<strong class="gifting-price">894 kr.</strong>{{-- todo get price from DB --}}
						<span class="gifting-months">{{ trans('gifting.giftcard_6') }}</span>

						<button class="button button--green button--full" type="button">{{ trans('gifting.select') }}</button>
					</label>
				</div>
			</form>
		</div>

		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 text-center"><img height="110"
																	 src="/images/gifting/step_1.png"
																	 alt="{{ trans('gifting.steps.one.title') }}">
				<h3>{{ trans('gifting.steps.one.title') }}</h3>
				<p>{{ trans('gifting.steps.one.text') }}</p>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 text-center"><img height="110"
																	 src="/images/gifting/step_2.png"
																	 alt="{{ trans('gifting.steps.two.title') }}">
				<h3>{{ trans('gifting.steps.two.title') }}</h3>
				<p>{{ trans('gifting.steps.two.text') }}</p>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 text-center"><img height="110"
																	 src="/images/gifting/step_3.png"
																	 alt="{{ trans('gifting.steps.three.title') }}">
				<h3>{{ trans('gifting.steps.three.title') }}</h3>
				<p>{{ trans('gifting.steps.three.text') }}</p>
			</div>
		</div>
	</div>
@endsection

@section('footer_scripts')
	<script>
		$(".gifting-selector").click(function () {
			$("#giftingForm").submit();
		});
	</script>
@endsection
