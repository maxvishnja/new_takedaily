@extends('layouts.app')

@section('pageClass', 'gifting')

@section('title', trans('gifting.title'))

@section('mainClasses', 'm-b-50')

@section('content')
<main>
	<div class="header_image">
		<div class="container text-center p-t-50">
			<h1>{{ trans('gifting.title-element') }}</h1>
			<h2>{{ trans('gifting.subtitle') }}</h2>
		</div>
	</div>

	<div class="container text-center">
		<div class="gifting-block">
			<form action="{{ url()->route('buy-giftcard') }}" id="giftingForm" method="post">
				<div class="gifting-selectors">
					<label class="gifting-selector" for="months_input_1">
						<input type="radio" name="giftcard" value="1" id="months_input_1"/>
						<strong
							class="gifting-price">{{ trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Apricot\Checkout\ProductPriceGetter::getPrice('giftcard_1'))]) }}</strong>
						<span class="gifting-months">{{ trans('gifting.giftcard_1') }}</span>

						<span class="button button--green button--full">{{ trans('gifting.select') }}</span>
					</label>

					<label class="gifting-selector" for="months_input_3">
						<input type="radio" name="giftcard" value="3" id="months_input_3"/>
						<strong
							class="gifting-price">{{ trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Apricot\Checkout\ProductPriceGetter::getPrice('giftcard_3'))]) }}</strong>
						<span class="gifting-months">{{ trans('gifting.giftcard_3') }}</span>

						<span class="button button--green button--full">{{ trans('gifting.select') }}</span>
					</label>

					<label class="gifting-selector" for="months_input_6">
						<input type="radio" name="giftcard" value="6" id="months_input_6"/>
						<strong
							class="gifting-price">{{ trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Apricot\Checkout\ProductPriceGetter::getPrice('giftcard_6'))]) }}</strong>
						<span class="gifting-months">{{ trans('gifting.giftcard_6') }}</span>

						<span class="button button--green button--full">{{ trans('gifting.select') }}</span>
					</label>
				</div>

				{{ csrf_field() }}
			</form>
		</div>

		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 text-center">
				<img src="/images/gifting/step_1.png"
					 alt="{{ trans('gifting.steps.one.title') }}">
				<h3>{{ trans('gifting.steps.one.title') }}</h3>
				<p>{{ trans('gifting.steps.one.text') }}</p>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 text-center">
				<img src="/images/gifting/step_2.png"
					 alt="{{ trans('gifting.steps.two.title') }}">
				<h3>{{ trans('gifting.steps.two.title') }}</h3>
				<p>{{ trans('gifting.steps.two.text') }}</p>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 text-center">
				<img src="/images/gifting/step_3.png"
					 alt="{{ trans('gifting.steps.three.title') }}">
				<h3>{{ trans('gifting.steps.three.title') }}</h3>
				<p>{{ trans('gifting.steps.three.text') }}</p>
			</div>
		</div>
	</div>
</main>
@endsection

@section('footer_scripts')
	<script>
		$(".gifting-selector input").change(function () {
			$("#giftingForm").submit();
		});
	</script>
@endsection

<style>
	.row h3 {
		font-size: 1.6rem;
		margin-bottom: 0.2rem;
	}
	.row {
		font-size: 1.3rem;
	}
</style>
