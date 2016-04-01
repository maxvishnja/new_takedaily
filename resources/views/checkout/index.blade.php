@extends('layouts.app')

@section('pageClass', 'page-checkout')

@section('mainClasses', 'm-b-50 m-t-50')
@section('title', trans('checkout.index.title'))

@section('content')
	<div class="container" id="app">
		<div class="row">
			<div class="col-md-4 col-md-push-8">
				<h3 class="m-b-35">{{ trans('checkout.index.total.title') }}</h3>
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
							<td>{{ trans('checkout.index.total.giftcard	') }}</td>
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

				@if ( ! $giftcard )
					<div class="m-t-20 m-b-20">
						<a href="#coupon-form" id="toggle-coupon-form">{{ trans('checkout.index.coupon.link') }}</a>
					</div>

					<form method="post" action="{{ URL::action('CheckoutController@applyCoupon') }}" id="coupon-form" style="@if(!Request::old('coupon')) display: none; @endif">
						<div class="row">
							<div class="col-md-7">
								<input type="text" name="coupon" maxlength="20" placeholder="{{ trans('checkout.index.coupon.input-placeholder') }}" data-validate="true" class="input input--regular input--uppercase input--spacing input--full input--semibold" value="{{ Request::old('coupon') }}" required="required"/>
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

			</div><!-- /Totals-->

			<div class="col-md-8 col-md-pull-4">
				<h1>{{ trans('checkout.index.order.title') }}</h1>

				<form method="post" action="{{ URL::action('CheckoutController@postCheckout') }}" id="checkout-form" autocomplete="on" class="form">
					<div class="spinner" id="form-loader">
						<div class="rect1"></div>
						<div class="rect2"></div>
						<div class="rect3"></div>
						<div class="rect4"></div>
						<div class="rect5"></div>
					</div>

					<div class="card card--large m-b-30">
						<fieldset>
							<legend class="card_title">{{ trans('checkout.index.order.info.title') }}</legend>
							<hr class="hr--dashed hr--small-margin"/>

							<div class="row m-b-50">
								<div class="col-md-12">
									<label class="label label--full checkout--label" for="input_info_name">{{ trans('checkout.index.order.info.name') }}
										<span class="required">*</span></label>
									<input class="input input--medium input--semibold input--full" id="input_info_name" data-validate="true" placeholder="{{ trans('checkout.index.order.info.name-placeholder') }}" name="info[name]" required="required" aria-required="true" value="{{ Request::old('info.name', (Auth::user() ? Auth::user()->name: '')) }}"/>
								</div>
							</div>

							<div class="row m-b-50">
								<div class="col-md-12">
									<label class="label label--full checkout--label" for="input_info_email">{{ trans('checkout.index.order.info.email') }}
										<span class="required">*</span></label>
									<input class="input input--medium input--semibold input--full" id="input_info_email" data-validate="true" placeholder="{{ trans('checkout.index.order.info.email-placeholder') }}" name="info[email]" required="required" aria-required="true" value="{{ Request::old('info.email', (Auth::user() ? Auth::user()->email : '')) }}"/>
								</div>
							</div>

							<div class="row m-b-50">
								<div class="col-md-4">
									<label class="label label--full checkout--label" for="input_info_address_street">{{ trans('checkout.index.order.info.address.street') }}
										<span class="required">*</span></label>
									<input class="input input--medium input--semibold input--full" id="input_info_address_street" data-validate="true" placeholder="{{ trans('checkout.index.order.info.address.street-placeholder') }}" name="info[address_street]" required="required" aria-required="true" value="{{ Request::old('info.address_street', (Auth::user() ? Auth::user()->getCustomer()->getCustomerAttribute('address_line1') : '')) }}"/>
								</div>
								<div class="col-md-4">
									<div class="visible-xs visible-sm m-t-50"></div>
									<label class="label label--full checkout--label" for="input_info_address_zipcode">{{ trans('checkout.index.order.info.address.zipcode') }} <span class="required">*</span></label>
									<input class="input input--medium input--semibold input--full" id="input_info_address_zipcode" data-validate="true" placeholder="{{ trans('checkout.index.order.info.address.zipcode-placeholder') }}" name="info[address_zipcode]" required="required" aria-required="true" value="{{ Request::old('info.address_zipcode', (Auth::user() ? Auth::user()->getCustomer()->getCustomerAttribute('address_postal') : '')) }}"/>
								</div>
								<div class="col-md-4">
									<div class="visible-xs visible-sm m-t-50"></div>
									<label class="label label--full checkout--label" for="input_info_address_city">{{ trans('checkout.index.order.info.address.city') }} <span class="required">*</span></label>
									<input class="input input--medium input--semibold input--full" id="input_info_address_city" data-validate="true" placeholder="{{ trans('checkout.index.order.info.address.city-placeholder') }}" name="info[address_city]" required="required" aria-required="true" value="{{ Request::old('info.address_city', (Auth::user() ? Auth::user()->getCustomer()->getCustomerAttribute('address_city') : '')) }}"/>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<label class="label label--full checkout--label" for="input_info_address_country">{{ trans('checkout.index.order.info.address.country') }}
										<span class="required">*</span></label>
									<select name="info[address_country]" class="select select--medium select--semibold select--full" required="required" aria-required="true" data-validate="true">
										@foreach(trans('checkout.index.order.info.address.countries') as $country)
											<option @if( Request::old('info.address_country', (Auth::user() ? Auth::user()->getCustomer()->getCustomerAttribute('address_country', 'Danmark') : 'Danmark')) == $country ) selected="selected" @endif value="{{ $country }}">
												{{ $country }}
											</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-6">
									<label class="label label--full checkout--label" for="input_info_company">{{ trans('checkout.index.order.info.company') }} <span class="optional pull-right">{{ trans('checkout.index.order.info.optional') }}</span></label>
									<input class="input input--medium input--semibold input--full" id="input_info_company" placeholder="{{ trans('checkout.index.order.info.company-placeholder') }}" name="info[company]" value="{{ Request::old('info.company', (Auth::user() ? Auth::user()->getCustomer()->getCustomerAttribute('company') : '')) }}"/>
								</div>
							</div>
						</fieldset>
					</div>

					<div class="card card--large">
						<fieldset id="payment-fieldset">
							<legend class="card_title pull-left">{{ trans('checkout.index.order.billing.title') }}</legend>
							<div class="pull-right secured_server">
								<span class="icon icon-lock"></span> {{ trans('checkout.index.order.billing.secure') }}
							</div>
							<div class="clear"></div>
							<hr class="hr--dashed hr--small-margin"/>

							<span id="payment-errors"></span>

							<div class="row m-b-50">
								<div class="col-md-7">
									<!-- Card Number -->
									<label class="label label--full checkout--label" for="cc-number">{{ trans('checkout.index.order.billing.card.number') }}</label>
									<input type="tel" class="input input--medium input--spacing input--semibold input--full" id="cc-number" autocomplete="cc-number" size="20" maxlength="20" placeholder="{{ trans('checkout.index.order.billing.card.number-placeholder') }}" class="card-number form-control" data-stripe="number" pattern="\d*" required="required"/>
								</div>
								<div class="col-md-5 hidden-xs hidden-sm">
									<label class="label label--full checkout--label">&nbsp;</label>
									<div style="padding: 15px 0">
										<span class="icon icon-card-mastercard m-r-5 v-a-m" title="Mastercard"></span>
										<span class="icon icon-card-visa m-l-5 v-a-m" title="Visa"></span>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-4">
									<!-- Expiry Month -->
									<label class="label label--full checkout--label" for="cc-month">{{ trans('checkout.index.order.billing.card.month') }}</label>
									<select class="select select--full select--semibold select--spacing select--medium" id="cc-month" data-stripe="exp-month">
										<option value="-1" selected="selected" disabled="disabled">{{ trans('checkout.index.order.billing.card.month') }}</option>
										@for($i = 1; $i<=12; $i++)
											<option value="{{ $i }}">{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
										@endfor
									</select>
								</div>
								<div class="col-md-4">
									<div class="visible-xs visible-sm m-t-50"></div>
									<!-- Expiry Year -->
									<label class="label label--full checkout--label" for="cc-year">{{ trans('checkout.index.order.billing.card.year') }}</label>
									<select class="select select--full select--semibold select--spacing select--medium" id="cc-year" data-stripe="exp-year">
										<option value="-1" selected="selected" disabled="disabled">{{ trans('checkout.index.order.billing.card.year') }}</option>
										@for($i = date('Y'); $i<=date('Y', strtotime('+20 years')); $i++)
											<option value="{{ $i }}">{{ $i }}</option>
										@endfor
									</select>
								</div>
								<div class="col-md-4">
									<div class="visible-xs visible-sm m-t-50"></div>
									<!-- CVV/CVC -->
									<label class="label label--full checkout--label" for="cc-cvc" title="{{ trans('checkout.index.order.billing.card.cvc-title') }}">{{ trans('checkout.index.order.billing.card.cvc') }}</label>
									<input type="tel" class="input input--medium input--spacing input--semibold input--full" id="cc-cvc" autocomplete="off" size="4" maxlength="4" placeholder="{{ trans('checkout.index.order.billing.card.cvc-placeholder') }}" class="card-cvc form-control" data-stripe="cvc" required="required" pattern="\d*"/>
								</div>
							</div>

						</fieldset>
					</div>

					<button class="button button--huge button--green button--rounded pull-right m-t-20" type="submit" id="button-submit">{{ trans('checkout.index.order.button-submit-text') }}</button>

					{{ csrf_field() }}

					<div class="hidden">
						<input type="hidden" name="product_name" value="{{ Request::old('product_name', Request::get('product_name', session('product_name', 'subscription'))) }}" autocomplete="off"/>
						<input type="hidden" name="coupon" v-bind:value="discount.code" value="{{ Request::old('coupon') }}" autocomplete="off"/>
						<textarea name="user_data">{{ json_encode(Session::get('user_data', Request::old('user_data', []))) }}</textarea>
					</div>
				</form>
			</div><!-- /Form-->
		</div>
	</div>
@endsection

@section('footer_scripts')
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

	<script>
		Stripe.setPublishableKey('{{ env('STRIPE_API_PUBLISHABLE_KEY') }}');

		function stripeResponseHandler(status, response)
		{
			var $form = $("#checkout-form");
			$form.removeClass('form--loading');

			if (response.error)
			{
				// Show the errors on the form
				$form.find('#payment-errors').text(response.error.message);
				$form.find('button#button-submit').prop('disabled', false);
			}
			else
			{
				// response contains id and card, which contains additional card details
				var token = response.id;
				// Insert the token into the form so it gets submitted to the server
				$form.append($('<input type="hidden" name="stripeToken" />').val(token));
				// and submit
				$form.get(0).submit();
			}
		}

		jQuery(function ($)
		{
			$("#checkout-form").submit(function (event)
			{
				var $form = $(this);

				if (!validateFormInput($form))
				{
					return false;
				}

				// Disable the submit button to prevent repeated clicks
				$form.find('button#button-submit').prop('disabled', true);
				$form.addClass('form--loading');

				Stripe.card.createToken($form, stripeResponseHandler);
				// Prevent the form from submitting with the default action
				event.preventDefault();
				return false;
			});
		});
	</script>

	<script>
		function checkErrors()
		{
			$error = false;

			$.each($("#checkout-form #payment-fieldset").find('input'), function (i, element)
			{
				if ($(element).val() == '')
				{
					$error = true;
				}
			});

			if (!$.payment.validateCardNumber($("#cc-number").val()))
			{
				$error = true;
			}

			if (!$.payment.validateCardCVC($("#cc-cvc").val()))
			{
				$error = true;
			}

			if (!$.payment.validateCardExpiry($("#cc-month").val(), $("#cc-year").val()))
			{
				$error = true;
			}

			$("#checkout-form button#button-submit").prop('disabled', $error);
		}

		$("#cc-number").on('change input', function ()
		{
			$validated = $.payment.validateCardNumber($(this).val());

			if ($validated)
			{
				$(this).removeClass('input--error').addClass('input--success');
			}
			else
			{
				$(this).addClass('input--error').removeClass('input--success');
			}

			checkErrors();
		});

		$("#cc-cvc").on('change input', function ()
		{
			$validated = $.payment.validateCardCVC($(this).val());

			if ($validated)
			{
				$(this).removeClass('input--error').addClass('input--success');
			}
			else
			{
				$(this).addClass('input--error').removeClass('input--success');
			}

			checkErrors();
		});

		$("#cc-month, #cc-year").on('change', function ()
		{
			$validated = $.payment.validateCardExpiry($("#cc-month").val(), $("#cc-year").val());

			if ($("#cc-month").val() !== null && $("#cc-year").val() !== null)
			{
				if ($validated)
				{
					$("#cc-month, #cc-year").removeClass('select--error').addClass('select--success');
				}
				else
				{
					$("#cc-month, #cc-year").addClass('select--error').removeClass('select--success');
				}
			}

			checkErrors();
		});

		$("#checkout-form button#button-submit").prop('disabled', true);
		checkErrors();
	</script>

	<script>
		var app = new Vue({
			'el': '#app',
			data: {
				shipping: 0,
				price: {{ $giftcard ? 0 : \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price) }},
				sub_price: {{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price) }},
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
					return this.total_sub * 0.2;
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
					return this.subtotal - this.total_discount;
				},
				total_subscription: function ()
				{
					var amount = this.sub_price;

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
						button.text('Vent...').prop('disabled', true);
					},
					complete: function ()
					{
						button.text('Anvend').prop('disabled', false);
					},
					success: function (response)
					{
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
		</script>
	@endif

	<script>
		$("input#cc-number").payment("formatCardNumber");
		$("input#cc-cvc").payment("formatCardCVC");
	</script>
@endsection
