@extends('layouts.app')

@section('pageClass', 'page-checkout')

@section('mainClasses', 'm-b-50 m-t-50')
@section('title', trans('checkout.index.title'))

@section('content')
	<script>
		window.fbAsyncInit = function() {
			FB.init({
				appId      : '{{ env('FACEBOOK_APP_ID') }}',
				xfbml      : true,
				version    : 'v2.6'
			});

			FB.getLoginStatus(function(response) {
				statusChangeCallback(response);
			});

			function checkLoginState() {
				FB.getLoginStatus(function(response) {
					statusChangeCallback(response);
				});
			}
		};

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/da_DK/sdk.js"; // todo set locale
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>

	<div class="container" id="app">
		<div class="row">
			<div class="col-md-4 visible-sm visible-xs text-center">
				<div class="mobile-total-text">{{ trans('checkout.index.total.total') }}</div>
				<div class="mobile-total">{{ trans('general.money-vue', ['amount' => 'total']) }}</div>

				@if ( ! $giftcard )
					<div class="m-t-20 m-b-20">
						<a href="#coupon-form-mobile" id="toggle-coupon-form-mobile">{{ trans('checkout.index.coupon.link') }}</a>
					</div>
					<form method="post" action="{{ URL::action('CheckoutController@applyCoupon') }}" id="coupon-form-mobile" style="@if(!Request::old('coupon')) display: none; @endif">
						<div class="row">
							<div class="col-md-7">
								<input type="text" name="coupon" maxlength="20" placeholder="{{ trans('checkout.index.coupon.input-placeholder') }}" data-validate="true" class="input input--regular input--uppercase input--spacing input--full input--semibold" value="{{ Request::old('coupon', Session::get('applied_coupon')) }}" required="required"/>
							</div>
							<div class="col-md-5">
								<button type="submit" class="button button--regular button--full button--green">{{ trans('checkout.index.coupon.button-text') }}</button>
							</div>
						</div>
						{{ csrf_field() }}

						<div id="coupon-form-successes-mobile" class="m-t-10"></div>
						<div id="coupon-form-errors-mobile" class="m-t-10"></div>
					</form>
					<hr/>
				@endif
			</div>
			<div class="col-md-8">
				<h1 style="margin-top: 0;">{{ trans('checkout.index.order.title') }}</h1>

				<form method="post" action="{{ URL::action('CheckoutController@postCheckout') }}" id="checkout-form" autocomplete="on" class="form" novalidate="novalidate">
					<div class="spinner" id="form-loader">
						<div class="rect1"></div>
						<div class="rect2"></div>
						<div class="rect3"></div>
						<div class="rect4"></div>
						<div class="rect5"></div>
					</div>

					<div class="card card--large m-b-30">
						<fb:login-button
							scope="public_profile,email,user_birthday"
							onlogin="checkLoginState();">
						</fb:login-button>

						<fieldset>
							<legend class="card_title">{{ trans('checkout.index.order.info.title') }}</legend>
							<hr class="hr--dashed hr--small-margin"/>

							<div class="row m-b-50 m-sm-b-20">
								<div class="col-md-12">
									<label class="label label--full checkout--label" for="input_info_name">{{ trans('checkout.index.order.info.name') }}
										<span class="required">*</span></label>
									<input type="text" class="input input--medium input--semibold input--full @if($errors->has('name')) input--error @endif" id="input_info_name" data-validate="true" placeholder="{{ trans('checkout.index.order.info.name-placeholder') }}" name="name" required="required" aria-required="true" value="{{ Request::old('name', (Auth::user() ? Auth::user()->name: '')) }}"/>
								</div>
							</div>

							<div class="row m-b-50 m-sm-b-20">
								<div class="col-md-12">
									<label class="label label--full checkout--label" for="input_info_email">{{ trans('checkout.index.order.info.email') }}
										<span class="required">*</span></label>
									<input type="email" class="input input--medium input--semibold input--full @if($errors->has('email')) input--error @endif" id="input_info_email" data-validate="true" placeholder="{{ trans('checkout.index.order.info.email-placeholder') }}" name="email" required="required" aria-required="true" value="{{ Request::old('email', (Auth::user() ? Auth::user()->email : '')) }}"/>
								</div>
							</div>

							<div class="row m-b-50 m-sm-b-20">
								<div class="col-md-4">
									<label class="label label--full checkout--label" for="input_info_address_street">{{ trans('checkout.index.order.info.address.street') }}
										<span class="required">*</span></label>
									<input type="text" class="input input--medium input--semibold input--full @if($errors->has('address_street')) input--error @endif" id="input_info_address_street" data-validate="true" placeholder="{{ trans('checkout.index.order.info.address.street-placeholder') }}" name="address_street" required="required" aria-required="true" value="{{ Request::old('address_street', (Auth::user() ? Auth::user()->getCustomer()->getCustomerAttribute('address_line1') : '')) }}"/>
								</div>
								<div class="col-md-4">
									<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
									<label class="label label--full checkout--label" for="input_info_address_zipcode">{{ trans('checkout.index.order.info.address.zipcode') }}
										<span class="required">*</span></label>
									<input type="text" class="input input--medium input--semibold input--full @if($errors->has('address_zipcode')) input--error @endif" id="input_info_address_zipcode" data-validate="true" placeholder="{{ trans('checkout.index.order.info.address.zipcode-placeholder') }}" name="address_zipcode" required="required" aria-required="true" value="{{ Request::old('address_zipcode', (Auth::user() ? Auth::user()->getCustomer()->getCustomerAttribute('address_postal') : '')) }}"/>
								</div>
								<div class="col-md-4">
									<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
									<label class="label label--full checkout--label" for="input_info_address_city">{{ trans('checkout.index.order.info.address.city') }}
										<span class="required">*</span></label>
									<input type="text" class="input input--medium input--semibold input--full @if($errors->has('address_city')) input--error @endif" id="input_info_address_city" data-validate="true" placeholder="{{ trans('checkout.index.order.info.address.city-placeholder') }}" name="address_city" required="required" aria-required="true" value="{{ Request::old('address_city', (Auth::user() ? Auth::user()->getCustomer()->getCustomerAttribute('address_city') : '')) }}"/>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<label class="label label--full checkout--label" for="input_info_address_country">{{ trans('checkout.index.order.info.address.country') }}
										<span class="required">*</span></label>
									<select name="address_country" id="country-selector" class="select select--medium select--semibold select--full" required="required" aria-required="true" data-validate="true">
										@foreach(\App\TaxZone::all() as $zone)
											<option @if( Request::old('address_country', (Auth::user() ? Auth::user()->getCustomer()->getCustomerAttribute('address_country', 'denmark') : 'denmark')) == $zone->name ) selected="selected" @endif value="{{ $zone->name }}">{{ trans("countries.{$zone->name}") }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-6">
									<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
									<label class="label label--full checkout--label" for="input_info_company">{{ trans('checkout.index.order.info.company') }}
										<span class="optional pull-right">{{ trans('checkout.index.order.info.optional') }}</span></label>
									<input type="text" class="input input--medium input--semibold input--full" id="input_info_company" placeholder="{{ trans('checkout.index.order.info.company-placeholder') }}" name="company" value="{{ Request::old('company', (Auth::user() ? Auth::user()->getCustomer()->getCustomerAttribute('company') : '')) }}"/>
								</div>
							</div>
						</fieldset>
					</div>

					@include('includes.payment.method')

					<div class="visible-xs">
						<div class="form-button-submit-holder">
							<button class="button button--huge button--green button--full button--rounded" type="submit" id="button-submit">{{ trans('checkout.index.order.button-submit-text') }}</button>

							<div class="clear"></div>
						</div>
					</div>

					<div class="hidden-xs">
						<div class="form-button-submit-holder pull-right">
							<button class="button button--huge button--green button--rounded" type="submit" id="button-submit">{{ trans('checkout.index.order.button-submit-text') }}</button>

							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>

					@if($product->is_subscription == 1)
						<div class="clear"></div>
						<div class="visible-sm visible-xs">
							{!! trans('checkout.index.disclaimer', ['date' => \Jenssegers\Date\Date::now()->addMonths($giftcard ? (round($giftcard->worth / $product->price) + 1) : 1)->format('j. M Y')]) !!}
						</div>
					@endif

					{{ csrf_field() }}

					<div class="hidden">
						<input type="hidden" name="product_name" value="{{ Request::old('product_name', Request::get('product_name', session('product_name', 'subscription'))) }}" autocomplete="off"/>
						<input type="hidden" name="coupon" v-bind:value="discount.code" value="{{ Request::old('coupon') }}" autocomplete="off"/>
						<textarea name="user_data">{{ $user_data }}</textarea>
					</div>
				</form>
			</div><!-- /Form-->
			<div class="visible-sm visible-xs m-b-50"></div>
			<div class="col-md-4">
				<h3 style="margin-top: 0;" class="m-b-35">{{ trans('checkout.index.total.title') }}</h3>
				<hr class="hr--double"/>

				<table v-cloack>
					<tbody>
					<tr>
						<td>{{ trans("products.{$product->name}") }}</td>
						<td>{{ trans('general.money-vue', ['amount' => 'sub_price']) }}</td>
					</tr>
					@if($product->is_subscription == 1)
						<tr>
							<td>{{ trans('checkout.index.total.shipping') }}</td>
							<td>
								<span v-show="shipping == 0">{{ trans('checkout.index.total.free') }}</span>
								<span v-show="shipping > 0">{{ trans('general.money-vue', ['amount' => 'shipping']) }}</span>
							</td>
						</tr>
					@endif
					@if($giftcard)
						<tr>
							<td>{{ trans('checkout.index.total.giftcard') }}</td>
							<td>{{ trans('general.money', ['amount' => \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($giftcard->worth, true, 2, '.')]) }}</td>
						</tr>
					@endif
					<tr v-show="discount.applied">
						<td>@{{ discount.code }}: @{{ discount.description }}</td>
						<td>-{{ trans('general.money-vue', ['amount' => 'total_discount']) }}</td>
					</tr>
					<tr v-show="giftcard">
						<td>@{{ discount.code }}: @{{ discount.description }}</td>
						<td>-{{ trans('general.money-vue', ['amount' => 'total_discount']) }}</td>
					</tr>
					<tr>
						<td>{{ trans('checkout.index.total.taxes') }}</td>
						<td>{{ trans('general.money-vue', ['amount' => 'total_taxes']) }}</td>
					</tr>
					<tr class="row--total">
						<td>{{ trans('checkout.index.total.total') }}</td>
						<td>{{ trans('general.money-vue', ['amount' => 'total']) }}</td>
					</tr>
					</tbody>
				</table>

				<div class="hidden-sm hidden-xs">
					@if ( ! $giftcard )
						<div class="m-t-20 m-b-20">
							<a href="#coupon-form" id="toggle-coupon-form">{{ trans('checkout.index.coupon.link') }}</a>
						</div>

						<form method="post" action="{{ URL::action('CheckoutController@applyCoupon') }}" id="coupon-form" style="@if(!Request::old('coupon')) display: none; @endif">
							<div class="row">
								<div class="col-md-7">
									<input type="text" name="coupon" maxlength="20" placeholder="{{ trans('checkout.index.coupon.input-placeholder') }}" data-validate="true" class="input input--regular input--uppercase input--spacing input--full input--semibold" value="{{ Request::old('coupon', Session::get('applied_coupon')) }}" required="required"/>
								</div>
								<div class="col-md-5">
									<button type="submit" class="button button--regular button--full button--green">{{ trans('checkout.index.coupon.button-text') }}</button>
								</div>
							</div>
							{{ csrf_field() }}

							<div id="coupon-form-successes" class="m-t-10"></div>
							<div id="coupon-form-errors" class="m-t-10"></div>
						</form>

						<hr/>
					@endif

					@if($product->is_subscription == 1)
						{!! trans('checkout.index.disclaimer', ['date' => \Jenssegers\Date\Date::now()->addMonths($giftcard ? (round($giftcard->worth / $product->price) + 1) : 1)->format('j. M Y')]) !!}
					@endif
				</div>

			</div><!-- /Totals-->

		</div>
	</div>
@endsection

@section('footer_scripts')
	<script>
		var app = new Vue({
			el: '#app',
			data: {
				company: '',
				shipping: {{ $shippingPrice }},
				price: {{ $giftcard ? 0 : \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price) }},
				sub_price: {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price) }},
				tax_rate: 0.2,
				discount: {
					applied: false,
					type: null,
					amount: 0,
					applies_to: null,
					description: '',
					code: '{{ Request::old('coupon') }}'
				}
			},
			computed: {
				total_taxes: function ()
				{
					return this.total_sub * this.tax_rate;
				},
				subtotal: function ()
				{
					return this.price;
				},
				total_sub: function ()
				{
					return this.price - this.total_discount;
				},
				total_discount: function ()
				{
					if (!this.discount.applied)
					{
						return 0;
					}

					if (this.discount.type == 'percentage')
					{
						var discount = this.subtotal * (this.discount.amount / 100);
					}
					else if (this.discount.type == 'amount')
					{
						var discount = (this.discount.amount / 100);
					}

					return discount;
				},
				total: function ()
				{
					return this.subtotal - this.total_discount + this.shipping;
				},
				total_subscription: function ()
				{
					var amount = this.sub_price + this.shipping;

					if (this.discount.applied)
					{
						if (this.discount.applies_to == 'plan')
						{
							var discount = 0;
							if (this.discount.type == 'percentage')
							{
								discount = this.total_sub * (this.discount.amount / 100);
							}
							else if (this.discount.type == 'amount')
							{
								discount = (this.discount.amount / 100);
							}

							amount -= discount;
						}
					}

					return amount;
				}
			}
		});
	</script>

	@if ( ! $giftcard )
		<script>
			/*
			 * Coupon
			 */
			$("#toggle-coupon-form").click(function (e)
			{
				e.preventDefault();

				$("#coupon-form").toggle();
			});

			$("#toggle-coupon-form-mobile").click(function (e)
			{
				e.preventDefault();

				$("#coupon-form-mobile").toggle();
			});

			$("#coupon-form").submit(function (e)
			{
				e.preventDefault();
				var form = $(this);
				var button = form.find('button');

				if (!validateFormInput(form, false))
				{
					return false;
				}

				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					headers: {
						'X-CSRF-TOKEN': form.find('[name="_token"]').val()
					},
					dataType: 'JSON',
					beforeSend: function ()
					{
						button.text('Vent...').prop('disabled', true); // todo translate
					},
					complete: function ()
					{
						button.text('Anvend').prop('disabled', false); // todo translate
					},
					success: function (response)
					{
						$("#coupon-form-successes-mobile").text(response.message);
						$("#coupon-form-errors-mobile").text('');
						$("#coupon-form-successes").text(response.message);
						$("#coupon-form-errors").text('');

						app.discount.applied = true;
						app.discount.type = response.coupon.discount_type;
						app.discount.amount = response.coupon.discount;
						app.discount.applies_to = response.coupon.applies_to;
						app.discount.description = response.coupon.description;
						app.discount.code = response.coupon.code;
					},
					error: function (response)
					{
						$("#coupon-form-errors-mobile").text(response.responseJSON.message);
						$("#coupon-form-successes-mobile").text('');
						$("#coupon-form-errors").text(response.responseJSON.message);
						$("#coupon-form-successes").text('');

						app.discount.applied = false;
						app.discount.code = '';
					}
				});
			});


			$("#coupon-form-mobile").submit(function (e)
			{
				e.preventDefault();
				var form = $(this);
				var button = form.find('button');

				if (!validateFormInput(form, false))
				{
					return false;
				}

				$.ajax({
					url: form.attr('action'),
					method: form.attr('method'),
					data: form.serialize(),
					headers: {
						'X-CSRF-TOKEN': form.find('[name="_token"]').val()
					},
					dataType: 'JSON',
					beforeSend: function ()
					{
						button.text('Vent...').prop('disabled', true); // todo translate
					},
					complete: function ()
					{
						button.text('Anvend').prop('disabled', false); // todo translate
					},
					success: function (response)
					{
						$("#coupon-form-successes-mobile").text(response.message);
						$("#coupon-form-errors-mobile").text('');
						$("#coupon-form-successes").text(response.message);
						$("#coupon-form-errors").text('');

						app.discount.applied = true;
						app.discount.type = response.coupon.discount_type;
						app.discount.amount = response.coupon.discount;
						app.discount.applies_to = response.coupon.applies_to;
						app.discount.description = response.coupon.description;
						app.discount.code = response.coupon.code;
					},
					error: function (response)
					{
						$("#coupon-form-errors-mobile").text(response.responseJSON.message);
						$("#coupon-form-successes-mobile").text('');
						$("#coupon-form-errors").text(response.responseJSON.message);
						$("#coupon-form-successes").text('');

						app.discount.applied = false;
						app.discount.code = '';
					}
				});
			});

			if (validateFormInput($("#coupon-form"), false))
			{
				$("#coupon-form").submit();
			}

			if (validateFormInput($("#coupon-form-mobile"), false))
			{
				$("#coupon-form-mobile").submit();
			}
		</script>
	@endif

	<script>
		$("#country-selector").change(function ()
		{
			var country = $(this).val();

			$.ajax({
				url: '{{ URL::action('CheckoutController@getTaxRate') }}',
				method: 'GET',
				dataType: 'JSON',
				data: {'zone': country},
				success: function (response)
				{
					app.tax_rate = response.rate;
				}
			});
		});

		$.ajax({
			url: '{{ URL::action('CheckoutController@getTaxRate') }}',
			method: 'GET',
			dataType: 'JSON',
			data: {'zone': $("#country-selector").val()},
			success: function (response)
			{
				app.tax_rate = response.rate;
			}
		});
	</script>

	<script>
		$("#checkout-form").validate({
			errorClass: 'input--error label--error',
			validClass: 'input--success',
			ignore: '[data-validate="false"]'
		});
	</script>
@endsection
