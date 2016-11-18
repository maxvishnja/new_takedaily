@if(!$giftcard)
<script>
	$("#toggle-coupon-form").click(function (e) {
		e.preventDefault();

		$("#coupon-field").toggle();
	});

	$("#coupon-button").click(function () {
		var button = $(this);

		$.ajax({
			url: "{{ URL::action('CheckoutController@applyCoupon') }}",
			method: "POST",
			data: {"coupon": $("#coupon-input").val()},
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			},
			dataType: 'JSON',
			beforeSend: function () {
				button.text('{{ trans('flow.coupon.wait') }}').prop('disabled', true);
			},
			complete: function () {
				button.text('{{ trans('flow.coupon.apply') }}').prop('disabled', false);
			},
			success: function (response) {
				$("#coupon-form-successes").text(response.message);
				$("#coupon-form-errors").text('');

//				app.discount.applied = true;
//				app.discount.type = response.coupon.discount_type;
//				app.discount.amount = response.coupon.discount;
//				app.discount.applies_to = response.coupon.applies_to;
//				app.discount.description = response.coupon.description;
//				app.discount.code = response.coupon.code;

				app.getCart();
			},
			error: function (response) {
				$("#coupon-form-errors").text(response.responseJSON.message);
				$("#coupon-form-successes").text('');

				app.discount.applied = false;
				app.discount.code = '';
				app.getCart();
			}
		});
	});

	if ($("#coupon-input").val().length > 0) {
		$("#coupon-button").click();
	}
</script>
@endif