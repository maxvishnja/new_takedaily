@extends('layouts.app')

@section('pageClass', 'page-checkout')

@section('mainClasses', 'm-b-50')
@section('title', trans('checkout.index.title'))

@section('content')
	@if(Auth::guest())
		<script>
			function statusChangeCallback(response) {
				if (response.status == 'connected') {
					$("#facebookloginbox").hide();

					FB.api('/me?fields=email,name', function (response) {
						$("#input_info_name").val(response.name);
						$("#input_info_email").val(response.email);
					});
				}
			}

			function loginFacebook() {
				FB.login(function (response) {
					statusChangeCallback(response);
				}, {scope: 'public_profile,email'});
			}

			function checkLoginState() {
				FB.getLoginStatus(function (response) {
					statusChangeCallback(response);
				});
			}

			window.fbAsyncInit = function () {
				FB.init({
					appId: '{{ env('FACEBOOK_APP_ID') }}',
					xfbml: true,
					version: 'v2.6'
				});

				FB.getLoginStatus(function (response) {
					statusChangeCallback(response);
				});
			};

			(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {
					return;
				}
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/{{ trans('general.locale') }}/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
	@endif

	<div class="container m-t-20">
		@if(Request::session()->has('flow-completion-token'))
			<a href="{{ url()->route('flow',['token' => Request::session()->get('flow-completion-token') ]) }}">{{ trans('checkout.back') }}</a>
		@endif

		@if(Request::session()->has('vitamins'))
			<a href="{{ url()->action('PickMixController@get') }}?selected={{ implode(',', session('vitamins')->toArray()) }}">{{ trans('checkout.back-pick') }}</a>
		@endif
	</div>

	<div class="container m-t-50" id="app">
		<div class="row">
			<div class="col-md-4 visible-sm visible-xs text-center">
				<div class="mobile-total-text">{{ trans('checkout.index.total.total') }}</div>
				<div class="mobile-total">{{ trans('general.money-vue', ['amount' => 'total']) }}</div>

				@if ( ! $giftcard && $product->isSubscription() )
					<div class="m-t-20 m-b-20">
						<a href="#coupon-form-mobile" id="toggle-coupon-form-mobile">{{ trans('checkout.index.coupon.link') }}</a>
					</div>
					<form method="post" action="{{ URL::action('CheckoutController@applyCoupon') }}" id="coupon-form-mobile"
						  style="@if(!Request::old('coupon')) display: none; @endif">
						<div class="row">
							<div class="col-md-7">
								<input type="text" name="coupon" maxlength="20" placeholder="{{ trans('checkout.index.coupon.input-placeholder') }}" data-validate="true"
									   class="input input--regular input--uppercase input--spacing input--full input--semibold"
									   value="{{ Request::old('coupon', Session::get('applied_coupon')) }}" required="required"/>
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

					@if(Auth::guest())
						<div class="card card--large m-b-30 card-padding-fixer">
							<fieldset>
								<div class="pull-right text-center">
									<a id="facebookloginbox" href="javascript:void(0);" onclick="loginFacebook()"
									   class="button button--blue button--medium m-b-5">{{ trans('checkout.fb-login') }}</a>
									<div><small>{{ trans('checkout.facebook_disclaimer') }}</small></div>
								</div>

								<div class="visible-xs clear"></div>
								<legend class="card_title pull-left">{{ trans('checkout.index.order.info.title') }}</legend>
								<div class="clear"></div>
								<label for="is_company">
									<input id="is_company" type="checkbox" v-model="is_company"/> {{ trans('checkout.index.order.info.is-company') }}
								</label>

								<div class="row">
									<div v-show="is_company">
										<div class="col-md-12">
											<div class="m-t-10"></div>
											<label class="label label--full checkout--label" for="input_info_company">{{ trans('checkout.index.order.info.company') }}</label>
											<input type="text" class="input input--medium input--semibold input--full" id="input_info_company"
												   placeholder="{{ trans('checkout.index.order.info.company-placeholder') }}" name="company"
												   value="{{ Request::old('company', (Auth::user() && Auth::user()->isUser() ? Auth::user()->getCustomer()->getCustomerAttribute('company') : '')) }}"/>
										</div>
									</div>
								</div>

								<div class="row m-t-50 m-sm-t-20 m-b-50 m-sm-b-20">
									<div class="col-md-12">
										<label class="label label--full checkout--label" for="input_info_name">{{ trans('checkout.index.order.info.name') }}
											<span class="required">*</span></label>
										<input type="text" class="input input--medium input--semibold input--full @if($errors->has('name')) input--error @endif"
											   id="input_info_name"
											   data-validate="true" placeholder="{{ trans('checkout.index.order.info.name-placeholder') }}" name="name" required="required"
											   aria-required="true" value="{{ Request::old('name', (Auth::user() && Auth::user()->isUser() ? Auth::user()->name: '')) }}"/>
									</div>
								</div>

								<div class="row m-b-50 m-sm-b-20">
									<div class="col-md-6">
										<label class="label label--full checkout--label" for="input_info_email">{{ trans('checkout.index.order.info.email') }}
											<span class="required">*</span></label>
										<input type="email" class="input input--medium input--semibold input--full @if($errors->has('email')) input--error @endif"
											   id="input_info_email"
											   data-validate="true" placeholder="{{ trans('checkout.index.order.info.email-placeholder') }}" name="email" required="required"
											   aria-required="true" value="{{ Request::old('email', (Auth::user() && Auth::user()->isUser() ? Auth::user()->email : '')) }}"/>
									</div>

									<div class="col-md-6">
										<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
										<label class="label label--full checkout--label" for="input_info_password">{{ trans('checkout.index.order.info.password') }}
											<span class="required">*</span></label>
										<input type="password" class="input input--medium input--semibold input--full @if($errors->has('password')) input--error @endif"
											   id="input_info_password"
											   data-validate="true" placeholder="{{ trans('checkout.index.order.info.password-placeholder') }}" name="password" required="required"
											   aria-required="true"/>
									</div>
								</div>

								<div class="row m-b-50 m-sm-b-20">
									<div class="col-md-6">
										<label class="label label--full checkout--label" for="input_info_phone">{{ trans('checkout.index.order.info.phone') }}</label>
										<input type="text" class="input input--medium input--semibold input--full @if($errors->has('phone')) input--error @endif"
											   id="input_info_phone"
											   placeholder="{{ trans('checkout.index.order.info.phone-placeholder') }}" name="phone"
											   value="{{ Request::old('phone', (Auth::user() && Auth::user()->isUser() ?Auth::user()->getCustomer()->getCustomerAttribute('phone') : '')) }}"/>
									</div>
								</div>

								<div class="row">
									<div class="col-md-5">
										<label class="label label--full checkout--label" for="input_info_address_street">{{ trans('checkout.index.order.info.address.street') }}
											<span class="required">*</span></label>
										<input type="text" class="input input--medium input--semibold input--full @if($errors->has('address_street')) input--error @endif"
											   id="input_info_address_street" data-validate="true" placeholder="{{ trans('checkout.index.order.info.address.street-placeholder') }}"
											   name="address_street" required="required" aria-required="true"
											   value="{{ Request::old('address_street', (Auth::user() && Auth::user()->isUser() ? Auth::user()->getCustomer()->getCustomerAttribute('address_line1') : '')) }}"/>
									</div>
									<div class="col-md-3 col-xs-6">
										<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
										<label class="label label--full checkout--label" for="input_info_address_zipcode">{{ trans('checkout.index.order.info.address.zipcode') }}
											<span class="required">*</span></label>
										<input type="text" class="input input--medium input--semibold input--full @if($errors->has('address_zipcode')) input--error @endif"
											   id="input_info_address_zipcode" data-validate="true"
											   placeholder="{{ trans('checkout.index.order.info.address.zipcode-placeholder') }}"
											   name="address_zipcode" required="required" aria-required="true"
											   value="{{ Request::old('address_zipcode', (Auth::user() && Auth::user()->isUser() ? Auth::user()->getCustomer()->getCustomerAttribute('address_postal') : '')) }}"/>
									</div>
									<div class="col-md-4 col-xs-6">
										<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
										<label class="label label--full checkout--label" for="input_info_address_city">{{ trans('checkout.index.order.info.address.city') }}
											<span class="required">*</span></label>
										<input type="text" class="input input--medium input--semibold input--full @if($errors->has('address_city')) input--error @endif"
											   id="input_info_address_city" data-validate="true" placeholder="{{ trans('checkout.index.order.info.address.city-placeholder') }}"
											   name="address_city" required="required" aria-required="true"
											   value="{{ Request::old('address_city', (Auth::user() && Auth::user()->isUser() ? Auth::user()->getCustomer()->getCustomerAttribute('address_city') : '')) }}"/>
									</div>
								</div>
								<select style="display: none !important" name="address_country" id="country-selector" class="select select--medium select--semibold select--full"
										required="required"
										readonly="readonly"
										aria-required="true" data-validate="true">
									@foreach(\App\TaxZone::all() as $zone)
										<option
											@if( Request::old('address_country', (Auth::user() && Auth::user()->isUser() ? Auth::user()->getCustomer()->getCustomerAttribute('address_country', trans('general.tax_zone')) : trans('general.tax_zone'))) == $zone->name ) selected="selected"
											@endif value="{{ $zone->name }}">{{ trans("countries.{$zone->name}") }}</option>
									@endforeach
								</select>
							</fieldset>
						</div>
					@endif

					@include('includes.payment.method')

					<div class="pull-left m-b-20 m-t-20">
						<span class="icon icon-check"></span> {!! trans('checkout.terms-agree') !!}
					</div>

					<div class="visible-xs">
						<div class="form-button-submit-holder">
							<button class="button button--huge button--green button--full button--rounded" type="submit"
									id="button-submit">{{ trans('checkout.index.order.button-submit-text') }}</button>

							<div class="clear"></div>
						</div>
					</div>

					<div class="hidden-xs">
						<div class="form-button-submit-holder pull-right">
							<button class="button button--huge button--green button--rounded" type="submit"
									id="button-submit">{{ trans('checkout.index.order.button-submit-text') }}</button>

							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>

					@if($product->is_subscription == 1)
						<div class="clear"></div>
						<div class="visible-sm visible-xs">
							{!! trans('checkout.index.disclaimer') !!}
						</div>
					@endif

					{{ csrf_field() }}

					<div class="hidden">
						<input type="hidden" name="product_name" value="{{ Request::old('product_name', Request::get('product_name', session('product_name', 'subscription'))) }}"
							   autocomplete="off"/>
						<input type="hidden" name="coupon" v-bind:value="discount.code" value="{{ Request::old('coupon') }}" autocomplete="off"/>
						<textarea name="user_data">{{ $user_data }}</textarea>
					</div>
				</form>
			</div><!-- /Form-->
			<div class="visible-sm visible-xs m-b-50"></div>
			<div class="col-md-4">
				<h3 style="margin-top: 0;" class="m-b-35">{{ trans('checkout.index.total.title') }}</h3>
				<hr class="hr--double"/>

				<table v-cloak class="m-b-40">
					<tbody>
					<tr v-for="item in totals">
						<td>
							<span v-show="!item.showPrice" style="margin-right: 30px"></span>
							@{{ item.name }}
						</td>
						<td>
							<span v-show="!item.showPrice">-</span>
							<span v-show="item.showPrice">
								<span v-show="item.price > 0">{{ trans('general.money-vue', ['amount' => 'item.price']) }}</span>
								<span v-show="item.price === 0">{{ trans('products.free_shipping') }}</span>
							</span>
						</td>
					</tr>
					<tr v-show="discount.applied">
						<td>@{{ discount.code }}</td>
						<td>
							<div v-show="discount.type == 'amount'">-{{ trans('general.money-vue', ['amount' => 'total_discount']) }}</div>
							<div v-show="discount.type == 'percentage'">-@{{ total_discount }}</div>
						</td>
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
					@if ( ! $giftcard && $product->isSubscription()  )
						<div class="m-t-20 m-b-20">
							<a href="#coupon-form" id="toggle-coupon-form">{{ trans('checkout.index.coupon.link') }}</a>
						</div>

						<form method="post" action="{{ URL::action('CheckoutController@applyCoupon') }}" id="coupon-form"
							  style="@if(!Request::old('coupon')) display: none; @endif">
							<div class="row">
								<div class="col-md-7">
									<input type="text" name="coupon" maxlength="20" placeholder="{{ trans('checkout.index.coupon.input-placeholder') }}" data-validate="true"
										   class="input input--regular input--uppercase input--spacing input--full input--semibold"
										   value="{{ Request::old('coupon', Session::get('applied_coupon')) }}" required="required"/>
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
						<div class="m-b-10">
							{!! trans('checkout.index.disclaimer') !!}
						</div>
					@endif

						<div class="clear"></div>
					<div class="m-t-40">
						<div class="clear"></div>
						@include('includes.promo')

						@include('flow-includes.views.help')
					</div>
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
				tax_rate: parseFloat("0.2"), // todo get from locale/country on load.
				totals: [],
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
				total_taxes: function () {
					return this.total * this.tax_rate;
				},
				required_totals: function () {
					var total = 0;

					$.each(this.totals, function (i, line) {
						if (line.name == '{{ trans('products.minimum') }}') {
							total += line.price;
						}
					});

					return total;
				},
				total: function () {
					return this.total_sum + this.required_totals;
				},
				total_subscription: function () {
					var amount = parseFloat("{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat(\App\Apricot\Checkout\Cart::getTotal()) }}");

					if (this.discount.applied) {
						if (this.discount.applies_to == 'plan') {
							var discount = 0;
							if (this.discount.type == 'percentage') {
								discount = amount * (this.discount.amount / 100);
							}
							else if (this.discount.type == 'amount') {
								discount = this.discount.amount;
							}

							amount -= discount;
						}
					}

					return amount;
				},
				total_sum: function () {
					var sum = 0;

					$.each(this.totals, function (i, line) {
						if (line.name !== '{{ trans('products.minimum') }}') {
							sum += line.price;
						}
					});

					if (app.discount.applied) {
						if (app.discount.type == 'amount') {
							sum -= app.discount.amount;
						}
						else if (app.discount.type == 'percentage') {
							sum *= (1 - (app.discount.amount / 100));
						}
					}

					sum = sum > 0 ? sum : 0;

					return sum;
				},
				total_discount: function () {
					var total = 0;

					if (this.discount.type == 'amount') {
						total = this.discount.amount;
					}
					else if (this.discount.type == 'percentage') {
						total = this.discount.amount + '%';
					}

					return total;
				}
			},
			methods: {
				getCart: function () {
					$.get('/cart').done(function (response) {
						app.totals = [];

						$.each(response.lines, function (i, line) {
							app.totals.push({
								name: line.name,
								price: line.amount,
								showPrice: line.hidePrice === undefined
							});
						});

						if (response.coupon !== undefined && response.coupon.applied !== undefined) {
							app.discount.applied = response.coupon.applied;
							app.discount.type = response.coupon.type;
							app.discount.amount = response.coupon.amount;
							app.discount.applies_to = response.coupon.applies_to;
							app.discount.description = response.coupon.description;
							app.discount.code = response.coupon.code;
						}

						if (response.giftcard !== undefined && response.giftcard.worth !== undefined) {
							app.totals.push({
								name: "{!! trans('checkout.index.total.giftcard') !!}",
								price: parseFloat(response.giftcard.worth) * -1,
								showPrice: true
							})
						}
					});
				}
			}
		});

		app.getCart();
	</script>

	@if ( ! $giftcard )
		<script>
			/*
			 * Coupon
			 */
			$("#toggle-coupon-form").click(function (e) {
				e.preventDefault();

				$("#coupon-form").toggle();
			});

			$("#toggle-coupon-form-mobile").click(function (e) {
				e.preventDefault();

				$("#coupon-form-mobile").toggle();
			});

			$("#coupon-form").submit(function (e) {
				e.preventDefault();
				var form = $(this);
				var button = form.find('button');

				if (!validateFormInput(form, false)) {
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
					beforeSend: function () {
						button.text('{{ trans('checkout.wait') }}').prop('disabled', true);
					},
					complete: function () {
						button.text('{{ trans('checkout.apply') }}').prop('disabled', false);
					},
					success: function (response) {
						$("#coupon-form-successes-mobile").text(response.message);
						$("#coupon-form-errors-mobile").text('');
						$("#coupon-form-successes").text(response.message);
						$("#coupon-form-errors").text('');

//						app.discount.applied = true;
//						app.discount.type = response.coupon.discount_type;
//						app.discount.amount = response.coupon.discount;
//						app.discount.applies_to = response.coupon.applies_to;
//						app.discount.description = response.coupon.description;
//						app.discount.code = response.coupon.code;
						app.getCart();
					},
					error: function (response) {
						$("#coupon-form-errors-mobile").text(response.responseJSON.message);
						$("#coupon-form-successes-mobile").text('');
						$("#coupon-form-errors").text(response.responseJSON.message);
						$("#coupon-form-successes").text('');

						app.discount.applied = false;
						app.discount.code = '';
						app.getCart();
					}
				});
			});


			$("#coupon-form-mobile").submit(function (e) {
				e.preventDefault();
				var form = $(this);
				var button = form.find('button');

				if (!validateFormInput(form, false)) {
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
					beforeSend: function () {
						button.text('{{ trans('checkout.wait') }}').prop('disabled', true);
					},
					complete: function () {
						button.text('{{ trans('checkout.apply') }}').prop('disabled', false);
					},
					success: function (response) {
						$("#coupon-form-successes-mobile").text(response.message);
						$("#coupon-form-errors-mobile").text('');
						$("#coupon-form-successes").text(response.message);
						$("#coupon-form-errors").text('');

//						app.discount.applied = true;
//						app.discount.type = response.coupon.discount_type;
//						app.discount.amount = response.coupon.discount;
//						app.discount.applies_to = response.coupon.applies_to;
//						app.discount.description = response.coupon.description;
//						app.discount.code = response.coupon.code;

						app.getCart();
					},
					error: function (response) {
						$("#coupon-form-errors-mobile").text(response.responseJSON.message);
						$("#coupon-form-successes-mobile").text('');
						$("#coupon-form-errors").text(response.responseJSON.message);
						$("#coupon-form-successes").text('');

						app.discount.applied = false;
						app.discount.code = '';

						app.getCart();
					}
				});
			});

			if (validateFormInput($("#coupon-form"), false)) {
				$("#coupon-form").submit();
			}

			if (validateFormInput($("#coupon-form-mobile"), false)) {
				$("#coupon-form-mobile").submit();
			}
		</script>
	@endif

	<script>
		$("#country-selector").change(function () {
			var country = $(this).val();

			$.ajax({
				url: '{{ URL::action('CheckoutController@getTaxRate') }}',
				method: 'GET',
				dataType: 'JSON',
				data: {'zone': country},
				success: function (response) {
					app.tax_rate = response.rate;
				}
			});
		});

		$.ajax({
			url: '{{ URL::action('CheckoutController@getTaxRate') }}',
			method: 'GET',
			dataType: 'JSON',
			data: {'zone': $("#country-selector").val()},
			success: function (response) {
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

@section('tracking-scripts')
	<script>
		fbq('track', 'AddToCart');
	</script>
@endsection
