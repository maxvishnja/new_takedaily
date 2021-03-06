@if(in_array('mollie', $paymentMethods))
	<div class="card card--large m-b-30 card-padding-fixer" id="method-card">
		<legend class="card_title">{{ trans('checkout.index.method.title') }}</legend>
		<div class="clear"></div>

		<div class="payment-methods">
			@if(in_array('stripe', $paymentMethods))
				<label class="payment-method-icon payment-method-icon-mastercard" data-toggle="payment-method-cc">
					<input type="radio" name="payment_method" value="stripe" class="payment_method_input"/>
				</label>

				<label class="payment-method-icon payment-method-icon-visa" data-toggle="payment-method-cc">
					<input type="radio" name="payment_method" value="stripe" class="payment_method_input"/>
				</label>
			@endif

			@if(in_array('mollie', $paymentMethods))
				<label class="payment-method-icon payment-method-icon-ideal" data-toggle="-">
					<input type="radio" name="payment_method" value="mollie" class="payment_method_input"/>
				</label>
			@endif
		</div>
	</div>
@else
	<div class="hidden">
		<label class="payment-method-icon payment-method-icon--selected" data-toggle="payment-method-cc">
			<input type="radio" checked="checked" name="payment_method" value="stripe" class="payment_method_input"/>
		</label>
	</div>
@endif

<div class="card card--large @if(in_array('mollie', $paymentMethods)) hidden @endif payment-type-card m-b-30" id="payment-method-cc">
	<fieldset id="payment-fieldset">
		<legend class="card_title pull-left">{{ trans('checkout.index.order.billing.title') }}</legend>
		<div class="pull-right secured_server">
			<span class="icon icon-lock"></span> {{ trans('checkout.index.order.billing.secure') }}
		</div>
		<div class="clear"></div>
		<hr class="hr--dashed hr--small-margin"/>

		<span id="payment-errors"></span>

		<div class="row m-b-50 m-sm-b-20">
			<!-- NAME -->
			<div class="col-md-12">
				<label class="label label--full checkout--label" for="ccname">{{ trans('checkout.index.order.billing.card.name') }}</label>
				<input type="text" data-validate="false" class="input input--medium input--spacing input--semibold input--full" id="ccname"
					   placeholder="{{ trans('checkout.index.order.info.name-placeholder') }}" autocomplete="cc-name" data-stripe="name" required="required"/>
			</div>
		</div>

		<div class="row m-b-50 m-sm-b-20">
			<div class="col-md-7">
				<!-- Card Number -->
				<label class="label label--full checkout--label" for="ccnumber">{{ trans('checkout.index.order.billing.card.number') }}</label>
				<input type="text" data-validate="false" class="input input--medium input--spacing input--semibold input--full" id="ccnumber" autocomplete="cc-number" size="20"
					   maxlength="20" placeholder="{{ trans('checkout.index.order.billing.card.number-placeholder') }}" data-stripe="number" pattern="[\d ]*" required="required"/>
			</div>
			<div class="col-md-5 hidden-xs hidden-sm">
				<label class="label label--full checkout--label">&nbsp;</label>
				<div style="padding: 15px 0">
					<span class="icon icon-card-mastercard m-r-5 v-a-m" title="Mastercard"></span>
					<span class="icon icon-card-visa m-l-5 m-r-5 v-a-m" title="Visa"></span>
					@if(App::getLocale() == 'da')
						<span class="icon icon-card-dk m-l-5 v-a-m" title="Dankort"></span>
					@endif
				</div>
			</div>
		</div>

		<div class="row">

			<div class="col-md-4 col-xs-6">
				<!-- Expiry Month -->
				<label class="label label--full checkout--label" for="cc-exp-month">{{ trans('checkout.index.order.billing.card.month') }}</label>
				<select data-validate="false" class="select select--full select--semibold select--spacing select--medium" id="cc-exp-month" data-stripe="exp-month"
						autocomplete="cc-exp-month">
					<option value="-1" selected="selected" disabled="disabled">{{ trans('checkout.index.order.billing.card.month') }}</option>
					@foreach(range(1,12) as $month)
						<option value="{{ str_pad($month, 2, 0, STR_PAD_LEFT) }}">{{ str_pad($month, 2, 0, STR_PAD_LEFT) }}
							- {{ \Jenssegers\Date\Date::create(2016,$month, 1)->format('M') }}</option>
					@endforeach
				</select>

				<div class="m-sm-b-20 visible-xs"></div>
			</div>
			<div class="col-md-4 col-xs-6">
				<!-- Expiry Year -->
				<label class="label label--full checkout--label" for="cc-exp-year">{{ trans('checkout.index.order.billing.card.year') }}</label>
				<select data-validate="false" class="select select--full select--semibold select--spacing select--medium" id="cc-exp-year" data-stripe="exp-year"
						autocomplete="cc-exp-year">
					<option value="-1" selected="selected" disabled="disabled">{{ trans('checkout.index.order.billing.card.year') }}</option>
					@for($i = date('Y'); $i<=date('Y', strtotime('+20 years')); $i++)
						<option value="{{ $i }}">{{ $i }}</option>
					@endfor
				</select>

				<div style="margin-bottom: 50px" class="visible-sm"></div>
				<div style="margin-bottom: 20px" class="visible-xs"></div>
			</div>

			<div class="col-md-4 col-xs-12">
				<div class="visible-xs visible-sm m-t-50 m-sm-t-20"></div>
				<!-- CVV/CVC -->
				<label class="label label--full checkout--label" for="cc-csc"
					   title="{{ trans('checkout.index.order.billing.card.cvc-title') }}">{{ trans('checkout.index.order.billing.card.cvc') }}
					({{ trans('checkout.index.order.billing.card.cvc-title') }})</label>
				<div class="input-with-positioned-icon">
					<div class="positioned-icon cvr-info-icon hidden-xs">?</div>
					<input data-validate="false" type="password" class="input input--medium input--spacing input--semibold input--full" id="cc-csc" autocomplete="cc-csc" size="4"
						   maxlength="4" placeholder="{{ trans('checkout.index.order.billing.card.cvc-placeholder') }}" data-stripe="cvc" required="required" pattern="\d*"/>
				</div>
			</div>
		</div>

	</fieldset>
</div>

@section('footer_scripts')
	@parent

	<script>
		$(".payment-method-icon").click(function () {
			$(this).parent().find('.payment-method-icon--selected').removeClass('payment-method-icon--selected');
			$(this).addClass('payment-method-icon--selected');

			$(".payment-type-card[id!='" + $(this).data('toggle') + "']").addClass('hidden');

			if ($(this).data('toggle') != '-') {
				$newCard = $(".payment-type-card[id='" + $(this).data('toggle') + "']");

				if ($newCard !== undefined && $newCard) {
					$newCard.removeClass('hidden');

					$("body, html").stop().animate({
						scrollTop: $newCard.offset().top
					}, 250);
				}
			}

			usesStripe = ($(".payment_method_input:checked").val() == 'stripe');

			@if($giftcard)
			if ($(".payment_method_input:checked").val() == 'mollie') {
				var hasMinimumOrderLine = false;
				for (var i = 0; i < app.totals.length; i++) {
					if (app.totals[i].name == '{{ trans('products.minimum') }}') {
						hasMinimumOrderLine = true;
						break;
					}
				}

				if (!hasMinimumOrderLine) {
					app.totals.push({
						name: '{{ trans('products.minimum') }}',
						price: parseFloat("{{ config('app.minimum_orders.mollie') }}"),
						showPrice: true
					});
				}
			}
			else {
				for (var i = 0; i < app.totals.length; i++) {
					if (app.totals[i].name == '{{ trans('products.minimum') }}') {
						app.totals.splice(i, 1);
						break;
					}
				}
			}
			@endif

			checkErrors();
		});

		@if(!in_array('mollie', $paymentMethods))
			usesStripe = true;
		@endif
	</script>
	<script>
		$(".form-button-submit-holder").click(function () {
			if ($("input[name='payment_method']:checked").length == 0) {
				$methodCard = $("#method-card");

				alert('{!! trans('checkout.index.method.errors.no-method') !!}');

				$("body, html").stop().animate({
					scrollTop: $methodCard.offset().top
				}, 250);

				$methodCard.addClass('card-focus');

				setTimeout(function () {
					$methodCard.removeClass('card-focus');
				}, 800);
			}
		});
	</script>
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script>
		Stripe.setPublishableKey('{{ env('STRIPE_API_PUBLISHABLE_KEY') }}');
		var usesStripe = true;

		function stripeResponseHandler(status, response) {
			var $form = $("#checkout-form");
			$form.removeClass('form--loading');

			if (response.error) {
				swal.close();
				// Show the errors on the form
				$form.find('#payment-errors').text(response.error.message);
				$form.find('button#button-submit').prop('disabled', false);
			}
			else {
				// response contains id and card, which contains additional card details
				var token = response.id;
				// Insert the token into the form so it gets submitted to the server
				$form.append($('<input type="hidden" name="stripeToken" />').val(token));
				// and submit
				$form.get(0).submit();
			}
		}

		jQuery(function ($) {
			$("#checkout-form").submit(function (event) {
				if (usesStripe) {

					var $form = $(this);


					if (!validateFormInput($form)) {
						return false;
					}

					swal({
						title: he.decode("{{ trans('checkout.index.wait-text') }}"),
						showCancelButton: false,
						showConfirmButton: false,
						imageUrl: "/images/35.gif"
					});

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
		function checkErrors() {
			$error = false;

			if (usesStripe) {
				$.each($("#checkout-form #payment-fieldset").find('input'), function (i, element) {
					if ($(element).val() == '') {
						$error = true;
					}
				});

				if (!$.payment.validateCardNumber($("#ccnumber").val())) {
					$error = true;
				}

				if (!$.payment.validateCardCVC($("#cc-csc").val())) {
					$error = true;
				}

				if (!$.payment.validateCardExpiry($("#cc-exp-month").val() ? $("#cc-exp-month").val() : '', $("#cc-exp-year").val() ? $("#cc-exp-year").val() : '')) {
					$error = true;
				}
			}

			$("#checkout-form button#button-submit").prop('disabled', $error);
		}

		$("#ccnumber").on('change input', function () {
			$validated = $.payment.validateCardNumber($(this).val());

			if ($validated) {
				$(this).removeClass('input--error').addClass('input--success');
			}
			else {
				$(this).addClass('input--error').removeClass('input--success');
			}

			checkErrors();
		});

		$("#cc-csc").on('change input', function () {
			$validated = $.payment.validateCardCVC($(this).val());

			if ($validated) {
				$(this).removeClass('input--error').addClass('input--success');
			}
			else {
				$(this).addClass('input--error').removeClass('input--success');
			}

			checkErrors();
		});

		$("#cc-exp-month, #cc-exp-year").on('change', function () {
			$validated = $.payment.validateCardExpiry($("#cc-exp-month").val(), $("#cc-exp-year").val());

			if ($("#cc-exp-month").val() !== null && $("#cc-exp-year").val() !== null) {
				if ($validated) {
					$("#cc-exp-month, #cc-exp-year").removeClass('select--error').addClass('select--success');
				}
				else {
					$("#cc-exp-month, #cc-exp-year").addClass('select--error').removeClass('select--success');
				}
			}

			checkErrors();
		});

		$("#checkout-form button#button-submit").prop('disabled', true);
		checkErrors();
	</script>
	<script>
		$("input#ccnumber").payment("formatCardNumber");
		$("input#cc-cvc").payment("formatCardCVC");
	</script>

	<script>
		(function () {
			var tip = new Tooltip('{{ trans('checkout.cvv-information') }}', { auto: true });
			tip.position(document.querySelector('.cvr-info-icon'));

			$(".cvr-info-icon").on('mouseover', function()
			{
				tip.show();
			});

			$(".cvr-info-icon").on('mouseout', function()
			{
				tip.hide();
			});
		})();
	</script>
@endsection