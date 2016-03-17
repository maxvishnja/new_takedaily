@extends('layouts.app')

@section('pageClass', 'page-checkout')

@section('mainClasses', 'm-b-50 m-t-50')
@section('title', 'Betaling - Take Daily')

@section('content')
	<div class="container" id="app">
		<div class="row">
			<div class="col-md-4 col-md-push-8">
				<h3 class="m-b-35">Ordreoversigt</h3>
				<hr class="hr--double"/>

				<table v-cloack>
					<tbody>
					<tr>
						<td>Take Daily abonnement</td>
						<td>@{{ price | currency '' }} kr.</td>
					</tr>
					<tr>
						<td>Fragt</td>
						<td>
							<span v-show="shipping == 0">Gratis</span>
							<span v-show="shipping > 0">@{{ shipping | currency '' }} kr.</span>
						</td>
					</tr>
					<tr>
						<td>Subtotal</td>
						<td>@{{ total_sub | currency '' }} kr.</td>
					</tr>
					<tr>
						<td>- heraf moms</td>
						<td>@{{ total_taxes | currency '' }} kr.</td>
					</tr>
					<tr v-show="discount.applied">
						<td>@{{ discount.code }}: @{{ discount.description }}</td>
						<td>-@{{ total_discount | currency '' }} kr.</td>
					</tr>
					<tr class="row--total">
						<td>Total</td>
						<td>@{{ total | currency '' }} kr.</td>
					</tr>
					</tbody>
				</table>

				<div class="m-t-20 m-b-20">
					<a href="#coupon-form" id="toggle-coupon-form">Har du en rabatkode?</a>
				</div>

				<form method="post" action="{{ URL::action('CheckoutController@applyCoupon') }}" id="coupon-form" style="display: none;">
					<div class="row">
						<div class="col-md-7">
							<input type="text" name="coupon" maxlength="20" placeholder="Din kuponkode" data-validate="true" class="input input--regular input--uppercase input--spacing input--full input--semibold" required="required"/>
						</div>
						<div class="col-md-5">
							<button type="submit" class="button button--regular button--full button--green">Anvend</button>
						</div>
					</div>
					{{ csrf_field() }}

					<div id="coupon-form-successes" class="m-t-10"></div>
					<div id="coupon-form-errors" class="m-t-10"></div>
				</form>

				<hr/>

				<p class="checkout_description">Dette er et abonnement, vi trækker derfor <span v-show="price === total_subscription">@{{ total_subscription }}
						DKK</span><strong v-show="price !== total_subscription">@{{ total_subscription }} DKK</strong> på dit kort hver 28 dage.
				</p>

				<p class="checkout_description">Du kan til enhver tid stoppe abonnementet, eller sætte det midlertidligt på pause.</p>

			</div><!-- /Totals-->

			<div class="col-md-8 col-md-pull-4">
				<h1>Bestilling</h1>

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
							<legend class="card_title">Dine oplysninger</legend>
							<hr class="hr--dashed hr--small-margin"/>

							<div class="row m-b-50">
								<div class="col-md-12">
									<label class="label label--full checkout--label" for="input_info_name">Dit fulde navn</label>
									<input class="input input--medium input--semibold input--full" id="input_info_name" data-validate="true" placeholder="Lars Jensen" name="info[name]" required="required" aria-required="true"/>
								</div>
							</div>

							<div class="row m-b-50">
								<div class="col-md-4">
									<label class="label label--full checkout--label" for="input_info_address_street">Din adresse</label>
									<input class="input input--medium input--semibold input--full" id="input_info_address_street" data-validate="true" placeholder="Søndre Skovvej 123" name="info[address_street]" required="required" aria-required="true"/>
								</div>
								<div class="col-md-4">
									<div class="visible-xs visible-sm m-t-50"></div>
									<label class="label label--full checkout--label" for="input_info_address_zipcode">Postnummer</label>
									<input class="input input--medium input--semibold input--full" id="input_info_address_zipcode" data-validate="true" placeholder="9400" name="info[address_zipcode]" required="required" aria-required="true"/>
								</div>
								<div class="col-md-4">
									<div class="visible-xs visible-sm m-t-50"></div>
									<label class="label label--full checkout--label" for="input_info_address_city">By</label>
									<input class="input input--medium input--semibold input--full" id="input_info_address_city" data-validate="true" placeholder="Aalborg" name="info[address_city]" required="required" aria-required="true"/>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<label class="label label--full checkout--label" for="input_info_email">Din e-mail adresse</label>
									<input class="input input--medium input--semibold input--full" id="input_info_email" data-validate="true" placeholder="lars-jensen@gmail.com" name="info[email]" required="required" aria-required="true"/>
								</div>
							</div>
							<input name="info[address_country]" type="hidden" value="Denmark"/>
						</fieldset>
					</div>

					<div class="card card--large">
						<fieldset id="payment-fieldset">
							<legend class="card_title pull-left">Kortoplysninger</legend>
							<div class="pull-right secured_server">
								<span class="icon icon-lock"></span> Sikret forbindelse
							</div>
							<div class="clear"></div>
							<hr class="hr--dashed hr--small-margin"/>

							<span id="payment-errors"></span>

							<div class="row m-b-50">
								<div class="col-md-7">
									<!-- Card Number -->
									<label class="label label--full checkout--label" for="cc-number">Kortnummer</label>
									<input type="tel" class="input input--medium input--spacing input--semibold input--full" id="cc-number" autocomplete="cc-number" size="20" maxlength="20" placeholder="4111 1111 1111 1111" class="card-number form-control" data-stripe="number" pattern="\d*" required="required"/>
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
									<label class="label label--full checkout--label" for="cc-month">Måned</label>
									<select class="select select--full select--semibold select--spacing select--medium" id="cc-month" data-stripe="exp-month">
										<option value="-1" selected="selected" disabled="disabled">Måned</option>
										@for($i = 1; $i<=12; $i++)
											<option value="{{ $i }}">{{ str_pad($i, 2, 0, STR_PAD_LEFT) }}</option>
										@endfor
									</select>
								</div>
								<div class="col-md-4">
									<div class="visible-xs visible-sm m-t-50"></div>
									<!-- Expiry Year -->
									<label class="label label--full checkout--label" for="cc-year">År</label>
									<select class="select select--full select--semibold select--spacing select--medium" id="cc-year" data-stripe="exp-year">
										<option value="-1" selected="selected" disabled="disabled">Årstal</option>
										@for($i = date('Y'); $i<=date('Y', strtotime('+20 years')); $i++)
											<option value="{{ $i }}">{{ $i }}</option>
										@endfor
									</select>
								</div>
								<div class="col-md-4">
									<div class="visible-xs visible-sm m-t-50"></div>
									<!-- CVV/CVC -->
									<label class="label label--full checkout--label" for="cc-cvc" title="CVV/CVC">Kontrolnummer</label>
									<input type="tel" class="input input--medium input--spacing input--semibold input--full" id="cc-cvc" autocomplete="off" size="4" maxlength="4" placeholder="123" class="card-cvc form-control" data-stripe="cvc" required="required" pattern="\d*"/>
								</div>
							</div>

						</fieldset>
					</div>

					<button class="button button--huge button--green button--rounded pull-right m-t-20" type="submit" id="button-submit">Bestil nu</button>

					{{ csrf_field() }}

					<div class="hidden">
						<input type="hidden" name="coupon" v-model="discount.code" autocomplete="off" />
						<textarea name="combinations">{{ json_encode(Session::get('my_combination', [])) }}</textarea>
						<textarea name="user_data">{{ json_encode(Session::get('user_data', [])) }}</textarea>
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

				switch ($(element).attr('id'))
				{
					case 'cc-number':
						if (!$.payment.validateCardNumber($(element).val()))
						{
							$error = true;
						}

						break;

					case 'cc-cvc':
						if (!$.payment.validateCardCVC($(element).val()))
						{
							$error = true;
						}

						break;
				}
			});

			$("#checkout-form button#button-submit").prop('disabled', $error);
		}

		$("#cc-number").on('change', function ()
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

			$("#input-cardtype").val($.payment.cardType($(this).val()));

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

		checkErrors();
	</script>

	<script>
		var app = new Vue({
			'el': '#app',
			data: {
				shipping: 0,
				price: 149,
				discount: {
					applied: false,
					type: null,
					amount: 0,
					applies_to: null,
					description: '',
					code: ''
				}
			},
			computed: {
				total_taxes: function ()
				{
					return this.total_sub * 0.2;
				},
				total_sub: function ()
				{
					return this.price;
				},
				total_discount: function ()
				{
					if (!this.discount.applied)
					{
						return 0;
					}

					if (this.discount.type == 'percentage')
					{
						var discount = this.total_sub * (this.discount.amount / 100);
					}
					else if (this.discount.type == 'amount')
					{
						var discount = (this.discount.amount / 100);
					}

					return discount;
				},
				total: function ()
				{
					return this.total_sub - this.total_discount;
				},
				total_subscription: function ()
				{
					var amount = this.total_sub;

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

			if (!validateFormInput(form))
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
				}
			});
		});
	</script>

	<script>
		$("input#cc-number").payment("formatCardNumber");
		$("input#cc-cvc").payment("formatCardCVC");
	</script>
@endsection
