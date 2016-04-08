@extends('layouts.app')

@section('pageClass', 'page-checkout-success')

@section('mainClasses', 'm-b-50 m-t-50')
@section('title', trans('checkout.success.page-title'))

@section('content')
	<div class="container">

		@if(!isset($giftcardToken))
			<div class="text-center">
				<h2>Skal din familie eller ansatte have Take Daily?</h2>
				<form method="post" action="/flow-upsell">
					<button type="submit" class="button button--green button--medium button--rounded">Bestil Take Daily med 50% rabat</button>

					<input type="hidden" name="product_name" value="subscription_family"/>

					{{ csrf_field() }}
				</form>
			</div>
		@endif

		<hr/>

		@if( isset($combinations) )
			<div class="print_label print_label--shadow hidden-xs">
				<div class="print_label_left">

					@foreach($combinations as $combinationKey => $combinationValue)
						<div class="print_label_line">
							<div class="print_label_line_full">
								{{ \App\Apricot\Libraries\PillLibrary::getPillCode(\App\Apricot\Libraries\PillLibrary::getPill($combinationKey, $combinationValue)) }}
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
					<div class="print_label_info_line">{{ Auth::user()->getCustomer()->getCustomerAttribute('address_country') }}</div>


					<div class="m-t-50">
						@foreach($combinations as $combinationKey => $combinationValue)
							<div style="display: inline-block;" class="m-t-15 icon pill-{{ \App\Apricot\Libraries\PillLibrary::getPill($combinationKey, $combinationValue) }}"></div>
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
