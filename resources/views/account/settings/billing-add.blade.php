@extends('layouts.account')

@section('pageClass', 'account account-settings account-settings-billing account-settings-billing-add')

@section('title', trans('account.settings_billing.add.title'))

@section('content')
	<h1>{{ trans('account.settings_billing.add.header') }}</h1>

	<div class="card card--large">
		<form class="form" id="new-card-form" method="post" action="{{ URL::action('AccountController@postSettingsBillingAdd') }}" novalidate="novalidate" autocomplete="on">
			<div class="spinner" id="form-loader">
				<div class="rect1"></div>
				<div class="rect2"></div>
				<div class="rect3"></div>
				<div class="rect4"></div>
				<div class="rect5"></div>
			</div>

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

			<div class="m-t-40">
				<button type="submit" class="button button--green button--large button--rounded" id="button-submit">{{ trans('account.settings_billing.button-add-method-text') }}</button>
				<a href="{{ URL::action('AccountController@getSettingsBilling') }}" class="pull-right button button--white button--text-grey button--large m-l-20 button--rounded">{{ trans('account.settings_billing.add.button-cancel-text') }}</a>

				<div class="clear"></div>
			</div>

			{{ csrf_field() }}
		</form>
	</div>

@endsection

@section('footer_scripts')
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

	<script>
		Stripe.setPublishableKey('{{ env('STRIPE_API_PUBLISHABLE_KEY') }}');

		function stripeResponseHandler(status, response)
		{
			var $form = $("#new-card-form");
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
			$("#new-card-form").submit(function (event)
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

			$.each($("#new-card-form #payment-fieldset").find('input'), function (i, element)
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

			$("#new-card-form button#button-submit").prop('disabled', $error);
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

		$("#new-card-form button#button-submit").prop('disabled', true);
		checkErrors();
	</script>

	<script>
		$("input#cc-number").payment("formatCardNumber");
		$("input#cc-cvc").payment("formatCardCVC");
	</script>
@endsection