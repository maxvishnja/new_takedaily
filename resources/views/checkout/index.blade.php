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
						var names = response.name.split(" ");
						var f_name = names[0];
						var l_name = names[names.length - 1];
						$("#input_info_f_name").val(f_name);
						$("#input_info_l_name").val(l_name);
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

	<div class="container m-t-20 checkout-step-back">
		@if(Request::session()->has('flow-completion-token'))
			<a href="{{ url()->route('flow',['token' => Request::session()->get('flow-completion-token') ]) }}">{{ trans('checkout.back') }}</a>
		@endif

		@if(Request::session()->has('vitamins'))
			<a href="{{ url()->action('PickMixController@get') }}?selected={{ implode(',', session('vitamins')->toArray()) }}">{{ trans('checkout.back-pick') }}</a>
		@endif
	</div>

	<div class="container m-t-50" id="app">
		<div class="row" style="margin-top: 6.6rem">
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
								<div id="facebookloginbox" class="pull-right text-center">
									<a href="javascript:void(0);" onclick="loginFacebook()"
									   class="button button--blue button--medium m-b-5">{{ trans('checkout.fb-login') }}</a>
									<div>
										<small style="font-size: 90%">{{ trans('checkout.facebook_disclaimer') }}</small>
									</div>
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
									<div class="col-md-6 m-t-">
										<label class="label label--full checkout--label" for="input_info_f_name">{{ trans('checkout.index.order.info.first_name') }}
											<span class="required">*</span></label>
										<input type="text" class="input input--medium input--semibold input--full @if($errors->has('first_name')) input--error @endif"
											   id="input_info_f_name"
											   data-validate="true" placeholder="{{ App::getLocale() != 'nl' ? trans('checkout.index.order.info.first-name-placeholder') : '' }}" name="first_name" required="required"
											   aria-required="true" value="{{ Request::old('first_name', (Auth::user() && Auth::user()->isUser() ? Auth::user()->customer->getFirstname() : '')) }}"/>
									</div>

									<div class="col-md-6">
										<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
										<label class="label label--full checkout--label" for="input_info_l_name">{{ trans('checkout.index.order.info.last_name') }}
											<span class="required">*</span></label>
										<input type="text" class="input input--medium input--semibold input--full @if($errors->has('last_name')) input--error @endif"
											   id="input_info_l_name"
											   data-validate="true" placeholder="{{ App::getLocale() != 'nl' ? trans('checkout.index.order.info.last-name-placeholder') : '' }}" name="last_name" required="required"
											   aria-required="true" value="{{ Request::old('last_name', (Auth::user() && Auth::user()->isUser() ? Auth::user()->customer->getLastName() : '')) }}"/>
									</div>
								</div>

								<div class="row m-t-50 m-sm-t-20 m-b-50 m-sm-b-20">
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
										<label class="label label--full checkout--label" for="input_info_email">{{ trans('checkout.index.order.info.repeat-email') }}
											<span class="required">*</span></label>
										<input type="email" class="input input--medium input--semibold input--full @if($errors->has('repeat-email')) input--error @endif"
											   id="input_info_repeat_email"
											   data-validate="false" placeholder="{{ trans('checkout.index.order.info.email-placeholder') }}" name="repeat-email" required="required"
											   aria-required="false"/>
										<label id="input_info_repeat_email-error" class="input--error label--error" for="input_info_repeat_email"></label>
									</div>
								</div>

								<div class="row m-b-50 m-sm-b-20">
									<div class="col-md-6">
										<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
										<label class="label label--full checkout--label" for="input_info_password">{{ trans('checkout.index.order.info.password') }}
											<span class="required">*</span></label>
										<input type="password" class="input input--medium input--semibold input--full @if($errors->has('password')) input--error @endif"
											   id="input_info_password"
											   data-validate="true" placeholder="{{ App::getLocale() != 'nl' ? trans('checkout.index.order.info.password-placeholder') : '' }}" name="password" required="required"
											   aria-required="true"/>
									</div>
									<div class="col-md-6">

										<label class="label label--full checkout--label" for="input_info_phone">{{ trans('checkout.index.order.info.phone-text') }}</label>
										
										<input type="number" data-validate="true"  @if(\App::getLocale()=="nl") maxlength="10" minlength="10" data-pattern="[0-9]{10}" data-validation="number" @else maxlength="8" minlength="8" data-pattern="[0-9]{8}" data-validation="number" @endif class="input input_info_phone input--medium input--semibold input--full @if($errors->has('phone')) input--error @endif"
											   id="input_info_phone"  aria-required="true"

											   placeholder="{{ trans('checkout.index.order.info.phone-placeholder') }}" name="phone"
											   value="{{ Request::old('phone', (Auth::user() && Auth::user()->isUser() ?Auth::user()->getCustomer()->getCustomerAttribute('phone') : '')) }}"/>
									</div>



								</div>

								<div class="row">
									@if(App::getLocale() == "nl")
									<h3 class="require-text">{{ trans('checkout.index.order.info.address.require') }}</h3>
									@endif
								</div>
								<div class="row  m-b-20">
									<div class="col-md-12" id="locationField">
										<label class="label label--full checkout--label" for="input_info_address_street">{{ trans('checkout.index.order.info.address.start') }}
											</label>
										<input type="text" class="input input--medium input--semibold input--full"
											   id="autocomplete" placeholder=""

											   value=""/>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label class="label label--full checkout--label" for="input_info_address_street">{{ trans('checkout.index.order.info.address.street') }}
											<span class="required">*</span></label>
										<input type="text" class="input input--medium input--semibold input--full @if($errors->has('address_street')) input--error @endif"
											   id="route" data-validate="true" placeholder="{{ trans('checkout.index.order.info.address.street-placeholder') }}"
											   name="address_street" required="required" aria-required="true"
											   value="{{ Request::old('address_street', (Auth::user() && Auth::user()->isUser() ? Auth::user()->getCustomer()->getCustomerAttribute('address_line1') : '')) }}"/>
									</div>

										<div class="col-md-3">
											<label class="label label--full checkout--label" for="input_info_address_street">{{ trans('checkout.index.order.info.address.number') }}
												<span class="required">*</span></label>
											<input  class="input input--medium input--semibold input--full @if($errors->has('address_number')) input--error @endif"
												   id="street_number" data-validate="true" placeholder="{{ trans('checkout.index.order.info.address.number-placeholder') }}"
												   name="address_number" required="required" type="text" aria-required="true"
												   value="{{ Request::old('address_number', (Auth::user() && Auth::user()->isUser() ? Auth::user()->getCustomer()->getCustomerAttribute('address_number') : '')) }}"/>
										</div>
										<div class="col-md-3 col-xs-6">
											<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
											<label class="label label--full checkout--label" for="input_info_address_city">{{ trans('checkout.index.order.info.address.city') }}
												<span class="required">*</span></label>
											<input type="text" class="input input--medium input--semibold input--full @if($errors->has('address_city')) input--error @endif"
												   id="locality" data-validate="true" placeholder="{{ App::getLocale() != 'nl' ? trans('checkout.index.order.info.address.city-placeholder') : '' }}"
												   name="address_city" required="required" aria-required="true"
												   value="{{ Request::old('address_city', (Auth::user() && Auth::user()->isUser() ? Auth::user()->getCustomer()->getCustomerAttribute('address_city') : '')) }}"/>
										</div>
										<div class="col-md-3 col-xs-6">
											<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
											<label class="label label--full checkout--label" for="input_info_address_city">{{ trans('checkout.index.order.info.address.zipcode') }}
												<span class="required">*</span></label>
											<input class="input input_info_address_zip input--medium input--semibold input--full @if($errors->has('address_zip')) input--error @endif"
												   id="postal_code"   data-validate="true" placeholder="{{ trans('checkout.index.order.info.address.zipcode-placeholder') }}"
												   name="address_zip" required="required" aria-required="true" @if(App::getLocale() != 'nl') type="number" data-pattern="[0-9]{4}" data-validation="number"  maxlength="4" minlength="4"  @else type="text" @endif
												   value="{{ Request::old('address_zip', (Auth::user() && Auth::user()->isUser() ? Auth::user()->getCustomer()->getCustomerAttribute('address_postal') : '')) }}"/>
										</div>


								</div>
								@if(App::getLocale() == "nl")
									<div class="row m-t-20 m-sm-t-20 m-b-20 m-sm-b-20" >
										<div class="col-md-3 col-xs-6">
											<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
											<label class="label label--full checkout--label" for="input_info_address_city">{{ trans('checkout.index.order.info.address.country') }}
												<span class="required">*</span></label>
											<select  name="address_country" id="country-selector" class="select select--medium select--semibold select--full"
													required="required"
													readonly="readonly"
													aria-required="true" data-validate="true">
												<option selected="selected" value="netherlands">{{ trans("countries.netherlands") }}</option>
												<option value="belgium">{{ trans("countries.belgium") }}</option>
											</select>
										</div>
									</div>
									@endif
								@if(App::getLocale() == "da")
									<div class="row m-t-20 m-sm-t-20 m-b-20 m-sm-b-20" style="display: none!important">
										<div class="col-md-3 col-xs-6">
											<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
											<label class="label label--full checkout--label" for="input_info_address_city">{{ trans('checkout.index.order.info.address.country') }}
												<span class="required">*</span></label>
											<select  name="address_country" id="country-selector" class="select select--medium select--semibold select--full"
													 required="required"
													 readonly="readonly"
													 aria-required="true" data-validate="true">
												@foreach(\App\TaxZone::all() as $zone)
													<option
															@if( Request::old('address_country', (Auth::user() && Auth::user()->isUser() ? Auth::user()->getCustomer()->getCustomerAttribute('address_country', trans('general.tax_zone')) : trans('general.tax_zone'))) == $zone->name ) selected="selected"
															@endif value="{{ $zone->name }}">{{ trans("countries.{$zone->name}") }}</option>
												@endforeach
											</select>
										</div>
									</div>
								@endif
							</fieldset>
						</div>
					@endif


					@include('includes.payment.method')

					<div class="m-b-20 terms_container_box">
						<label class="terms-label">
							<input name="terms_accept" type="checkbox" aria-required="true" data-validate="true" required="required" id="terms_checkbox"  />
							@if ( !$product->isSubscription() && App::getLocale() == 'nl')
								<div>{!! trans('checkout.terms-agree-gift') !!}</div>
							@else
							<div>{!! trans('checkout.terms-agree') !!}</div>
							@endif
						</label>
					</div>

					<div class="visible-xs">
						<div class="form-button-submit-holder">
							<button onsubmit="ga('send', 'event', 'order', 'completed');" class="button button--huge button--green button--full button--rounded" type="submit"
									id="button-submit">{{ trans('checkout.index.order.button-submit-text') }}</button>
							<div class="clear"></div>
						</div>
					</div>

					<div class="hidden-xs">
						<div class="form-button-submit-holder">
							<button onsubmit="ga('send', 'event', 'order', 'completed');" class="button button--huge button--green button--rounded" type="submit"
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
							<span v-show="!item.showPrice && item.price === 0">-</span>
							<span v-show="item.showPrice || item.price !== 0">
								<span v-show="item.price !== 0 && discount.type != 'fixed'">{{ trans('general.money-vue', ['amount' => 'item.price']) }}</span>
								<span v-show="item.price !== 0 && discount.type == 'fixed'">{{ trans('general.money-vue', ['amount' => 'total']) }}</span>
								<span v-show="item.price === 0">{{ trans('products.free_shipping') }}</span>
							</span>
						</td>
					</tr>
					<tr v-show="discount.applied">
						<td>@{{ discount.code }}</td>
						<td>
							<div v-show="discount.type == 'amount'">-{{ trans('general.money-vue', ['amount' => 'total_discount']) }}</div>
							<div v-show="discount.type == 'percentage'">-@{{ total_discount }}</div>
							<div v-show="discount.type == 'free_shipping'">-100%</div>
							<div v-show="discount.type == 'fixed'">{{ trans('general.money-vue', ['amount' => 'total_discount']) }} x @{{ total_month }} {{ trans('general.month')}}</div>
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
									<button type="submit"  class="button button--regular button--full button--green">{{ trans('checkout.index.coupon.button-text') }}</button>
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
					length: 0,
					amount: 0,
					applies_to: null,
					description: '',
					code: '{{ Request::old('coupon') }}'
				}
			},
			computed: {
				total_taxes: function () {
                    if (this.discount.type == 'fixed') {
                        return this.total * 0;
                    } else{
                        return this.total * this.tax_rate;
                    }
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
                                amount -= discount;
							}
							else if (this.discount.type == 'amount') {
								discount = this.discount.amount;
                                amount -= discount;
							}
							else if (this.discount.type == 'free_shipping') {
								discount = amount * (100 / 100);
                                amount -= discount;
							}
                            else if (this.discount.type == 'fixed') {
                                discount = this.discount.amount * this.discount.length;
                                amount = discount;
                            }


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
						else if (app.discount.type == 'free_shipping') {
							sum *= (1 - (100 / 100));
						}
                        else if (app.discount.type == 'fixed') {
                            sum = this.discount.amount * this.discount.length;
                        }
					}

					sum = sum > 0 ? sum : 0;

					return sum;
				},
                total_month: function () {
                    var month = 0;

                    if (this.discount.type == 'fixed') {
                        month = this.discount.length;
                    }

                    return month;
                },
				total_discount: function () {
					var total = 0;

					if (this.discount.type == 'amount') {
						total = this.discount.amount;
					}
					else if (this.discount.type == 'percentage') {
						total = this.discount.amount + '%';
					}
                    else if (this.discount.type == 'fixed') {
                        total = this.discount.amount;
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
							app.discount.length = response.coupon.length;
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
		@if(App::getLocale()=="da")
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
		@endif


		function validateEmail(){

			if($("#input_info_email").val() != $("#input_info_repeat_email").val()) {

				$('#input_info_repeat_email').addClass('input--error label--error');
				$('#input_info_repeat_email-error').html('{{trans('checkout.index.order.info.email-check')}}').show();
			} else {
				$('#input_info_repeat_email').removeClass('input--error label--error');
				$('#input_info_repeat_email-error').hide();

			}
		}

		$('#input_info_repeat_email-error').hide();

		$("#input_info_repeat_email").on('change', function() {
			validateEmail();
		});

		$("#input_info_email").on('change', function(){
			validateEmail();
			$.ajax({
				url: '{{ URL::action('CheckoutController@setAlmostCustomer') }}',
				method: 'POST',
				data: {email: $(this).val(), location: '{{App::getLocale()}}', name: $('#input_info_f_name').val(), token: '{{Request::session()->get("flow-completion-token")}}' },
				headers: {
					'X-CSRF-TOKEN': $("#coupon-form").find('[name="_token"]').val()
				},
				success: function (response) {
					console.log(response);
				}
			});
		});
	</script>

	<script src="{{ asset('js/validation_messages_' . App::getLocale() . '.js') }}"></script>

	<script>
		history.pushState(null, null, 'checkout');

		window.onload=function(){
			window.setTimeout(
					function()
					{
						window.addEventListener(
								"popstate",
								function(e) {
									var years=confirm('Are you sure you want to leave the page?',"");
									if(years){
										window.history.back();
									}
								}
						);
					},
					1);
		}

		$("#checkout-form").validate({
			errorClass: 'input--error label--error',
			validClass: 'input--success',
			ignore: '[data-validate="false"]'
		});


		@if(App::getLocale()=="da")
			$.validator.addMethod('checkPhone', function (value) {
				return /^[0-9]{8}$/.test(value);
			}, '{{ trans('checkout.index.order.info.address.postal.error') }}' );

			$.validator.addClassRules({
				input_info_phone: {
					required: true,
					checkPhone: true
				}
			});

		@endif

        @if(App::getLocale()=="nl")


			$("#country-selector").on('change', function(){
			if($("#country-selector").val() == "netherlands"){
				$.validator.addMethod('postalCode', function (value) {
					return /^[1-9][0-9]{3}\s?[a-zA-Z]{2}$/.test(value);
				}, '{{ trans('checkout.index.order.info.address.postal.error') }}' );

				$.validator.addClassRules({
					input_info_address_zip: {
						required: true,
						postalCode: true
					}
				});
			} else{
				$('#input_info_address_zip-error').hide();
				$('.input_info_address_zip').removeClass('input--error label--error');
				$.validator.addMethod('postalCode', function (value) {
					return /^[1-9][0-9]{3}$/.test(value);
				}, '{{ trans('checkout.index.order.info.address.postal.error') }}' );

				$.validator.addClassRules({
					input_info_address_zip: {
						required: true,
						postalCode: true
					}
				});
			}
		});



			$.validator.addMethod('postalCode', function (value) {
				return /^[1-9][0-9]{3}\s?[a-zA-Z]{2}$/.test(value);
			}, '{{ trans('checkout.index.order.info.address.postal.error') }}' );

			$.validator.addClassRules({
				input_info_address_zip: {
					required: true,
					postalCode: true
				}
			});


		@endif
	</script>

	<style>
		.terms_container_box {
			max-width: 50%
		}

		@media all and (max-width: 767px)
		{
			.terms_container_box {
				max-width: none
			}
		}
	</style>


	<script>
        // This example displays an address form, using the autocomplete feature
        // of the Google Places API to help users fill in the information.

        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

        var placeSearch, autocomplete;
        var componentForm = {
            street_number: 'short_name',
            route: 'short_name',
            locality: 'long_name',
            postal_code: 'short_name'
        };

//        for (var component in componentForm) {
//            document.getElementById(component).disabled = true;
//        }

        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['geocode']});

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);

        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();

            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            // Get each component of the address from the place details
            // and fill the corresponding field on the form.
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
            //$('#postal_code').attr('readonly','readonly');

        }

	</script>

	@if(Config::get('app.debug') == 0)
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLPa4ebv6W_V4vFmD4CLd5MkLW1tXFWrk&libraries=places&callback=initAutocomplete" async defer></script>

	@else
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMjNmcrNKsKPb3kfsJHhgDgr_PrnBtW9Y&libraries=places&callback=initAutocomplete" async defer></script>
	@endif
@endsection

@section('tracking-scripts')
	<script>
		fbq('track', 'AddToCart');
	</script>
@endsection
