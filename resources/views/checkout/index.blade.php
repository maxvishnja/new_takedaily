@extends('layouts.app')

@section('pageClass', 'page-checkout')

@section('mainClasses', 'm-b-50 m-t-50')
@section('title', 'Betaling - Take Daily')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-push-8">
				<h3>Ordreoversigt</h3>
				<hr class="hr--double"/>

				<table>
					<tbody>
					<tr>
						<td>Take Daily abonnement</td>
						<td>149,00 kr.</td>
					</tr>
					<tr>
						<td>Fragt</td>
						<td>Gratis</td>
					</tr>
					<tr>
						<td>Subtotal</td>
						<td>149,00 kr.</td>
					</tr>
					<tr>
						<td>- heraf moms</td>
						<td>29,80 kr.</td>
					</tr>
					<tr class="row--total">
						<td>Total</td>
						<td>149,00 kr.</td>
					</tr>
					</tbody>
				</table>

				<p class="checkout_description">Dette er et abonnement, vi trækker derfor 149 DKK på dit kort hver 28 dage.</p>

				<p class="checkout_description">Du kan til enhver tid stoppe abonnementet, eller sætte det midlertidligt på pause.</p>

			</div><!-- /Totals-->

			<div class="col-md-8 col-md-pull-4">
				<h1>Bestilling</h1>

				<form method="post" action="{{ URL::action('CheckoutController@postCheckout') }}" id="checkout-form" autocomplete="on">
					<div class="card card--large m-b-30">
						<fieldset name="info">
							<legend class="card_title">Dine oplysninger</legend>
							<hr class="hr--dashed hr--small-margin"/>

							<div class="row m-b-50">
								<div class="col-md-12">
									<label class="label label--full checkout--label" for="input_info_name">Dit fulde navn</label>
									<input class="input input--regular input--semibold input--full" id="input_info_name" placeholder="Lars Jensen" name="name"/>
								</div>
							</div>

							<div class="row m-b-50">
								<div class="col-md-4">
									<label class="label label--full checkout--label" for="input_info_address_street">Din adresse</label>
									<input class="input input--regular input--semibold input--full" id="input_info_address_street" placeholder="Søndre Skovvej 123" name="address_street"/>
								</div>
								<div class="col-md-4">
									<label class="label label--full checkout--label" for="input_info_address_zipcode">Postnummer</label>
									<input class="input input--regular input--semibold input--full" id="input_info_address_zipcode" placeholder="9400" name="address_zipcode"/>
								</div>
								<div class="col-md-4">
									<label class="label label--full checkout--label" for="input_info_address_city">By</label>
									<input class="input input--regular input--semibold input--full" id="input_info_address_city" placeholder="Aalborg" name="address_city"/>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<label class="label label--full checkout--label" for="input_info_email">Din e-mail adresse</label>
									<input class="input input--regular input--semibold input--full" id="input_info_email" placeholder="lars-jensen@gmail.com" name="email"/>
								</div>
							</div>
						</fieldset>
					</div>

					<div class="card card--large">
						<fieldset name="card">
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
								<div class="col-md-5">
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
											<option value="{{ $i }}">{{ $i }}</option>
										@endfor
									</select>
								</div>
								<div class="col-md-4">
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
									<!-- CVV/CVC -->
									<label class="label label--full checkout--label" for="cc-cvc">Kontrolnummer (CVV /
										CVC)</label>
									<input type="tel" class="input input--medium input--spacing input--semibold input--full" id="cc-cvc" autocomplete="off" size="4" maxlength="4" placeholder="123" class="card-cvc form-control" data-stripe="cvc" required="required" pattern="\d*"/>
								</div>
							</div>

						</fieldset>
					</div>

					<button class="button button--huge button--green button--rounded pull-right m-t-20" type="submit">Bestil nu</button>


					{{ csrf_field() }}
				</form>
			</div><!-- /Form-->
		</div>
	</div>
@endsection

@section('footer_scripts')
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

	<script>
		Stripe.setPublishableKey('{{ App::environment() == 'production' ? env('STRIPE_PUBLISHABLE_KEY') : env('STRIPE_TEST_PUBLISHABLE_KEY') }}');

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
				if ($("#payment_source").val() == "-1")
				{
					var $form = $(this);

					// Disable the submit button to prevent repeated clicks
					$form.find('button#button-submit').prop('disabled', true);
					$form.addClass('form--loading');

					Stripe.card.createToken($form, stripeResponseHandler);
					// Prevent the form from submitting with the default action
					event.preventDefault();
					return false;
				}
			});
		});
	</script>

	<script>
		function checkErrors()
		{
			$error = false;

			if ($("#payment_source").val() == "-1")
			{
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

						case 'cc-expiry':
							$expire = $.payment.cardExpiryVal($(element).val());
							if (!$.payment.validateCardExpiry($expire.month, $expire.year))
							{
								$error = true;
							}

							break;
					}
				});
			}
			else
			{
				error = false;
			}

			$("button#button-submit").prop('disabled', $error);
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

		$("#cc-expiry").on('input', function ()
		{
			$expire = $.payment.cardExpiryVal($(this).val());
			$validated = $.payment.validateCardExpiry($expire.month, $expire.year);

			if ($validated)
			{
				$(this).removeClass('input--error').addClass('input--success');
			}
			else
			{
				$(this).addClass('input--error').removeClass('input--success');
			}

			$("#input-cc-month").val($expire.month);
			$("#input-cc-year").val($expire.year);

			checkErrors();
		});

		checkErrors();
	</script>

	<script>
		$("input#cc-number").payment("formatCardNumber");
		$("input#cc-expiry").payment("formatCardExpiry");
		$("input#cc-cvc").payment("formatCardCVC");
	</script>
@endsection
