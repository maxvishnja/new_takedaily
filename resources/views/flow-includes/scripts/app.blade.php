<script>
	var app = new Vue({
		el: '#app',
		data: {
			recommendation: {
				hasOil: false
			},
			step: 1,
			sub_step: 1,
			current_advise_one: null,
			current_advise_two: null,
			current_advise_three: null,
			temp_age: null,
			recommendation_token: '',
			extra_totals: [],
			result: {},
			shipping: parseFloat("{{ (new \App\Apricot\Helpers\Money($shippingPrice))->toCurrency(trans('general.currency')) }}"),
			price: parseFloat("{{ $giftcard ? 0 : (new \App\Apricot\Helpers\Money(\App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price)))->toCurrency(trans('general.currency')) }}"),
			sub_price: parseFloat("{{ (new \App\Apricot\Helpers\Money(\App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price)))->toCurrency(trans('general.currency')) }}"),
			tax_rate: parseFloat("{{ $taxRate }}"),
			discount: {
				applied: false,
				type: null,
				amount: 0,
				applies_to: null,
				description: '',
				code: '{{ Request::old('coupon', !is_null($coupon) ? $coupon->code : '') }}'
			},
			user_data: {
				gender: null,
				birthdate: null,
				age: null,
				skin: null,
				outside: null,
				pregnant: null,
				pregnancy: {
					date: null,
					week: 0,
					wish: null
				},
				diet: null,
				sports: null,
				lacks_energy: null,
				smokes: null,
				immune_system: null,
				supplements: null,
				vegetarian: null,
				joints: null,
				stressed: null,
				foods: {
					fruits: null,
					vegetables: null,
					bread: null,
					wheat: null,
					dairy: null,
					meat: null,
					fish: null,
					butter: null,
				}
			}
		},
		watch: {
			'user_data.pregnancy.week': function(val, oldVal)
			{
				if(val != '0' && val != 0)
				{
					this.user_data.pregnancy.wish = 0;
				}
			},
			'user_data.pregnancy.wish': function(val, oldVal)
			{
				if(val != '0' && val != 0)
				{
					this.user_data.pregnancy.week = 0;
				}
			},
		},
		computed: {
			temp_age: function () {
				return this.getAge();
			},
			birthday: function () {
				var newDate = new Date(this.user_data.birthdate);

				var months = [
					@foreach(trans('flow.datepicker.months_long') as $month)
						"{{ $month }}",
					@endforeach
				];

				return newDate.getDate() + " " + months[newDate.getMonth()] + " " + newDate.getFullYear();
			},
			total_taxes: function () {
				return this.total_sub * this.tax_rate;
			},
			subtotal: function () {
				var price_addition = 0;

				for (var extra_price in this.extra_totals) {
					price_addition += parseFloat(app.extra_totals[extra_price].price);
				}

				return this.price + price_addition;
			},
			total_sub: function () {
				var price_addition = 0;

				for (var extra_price in this.extra_totals) {
					price_addition += parseFloat(app.extra_totals[extra_price].price);
				}

				return this.price + price_addition - this.total_discount;
			},
			total_discount: function () {
				if (!this.discount.applied) {
					return 0;
				}

				if (this.discount.type == 'percentage') {
					var discount = this.subtotal * (this.discount.amount / 100);
				}
				else if (this.discount.type == 'amount') {
					var discount = (this.discount.amount / 100);
				}

				return discount;
			},
			total: function () {
				return this.subtotal - this.total_discount + this.shipping;
			},
			total_subscription: function () {
				var amount = this.sub_price + this.shipping;

				if (this.discount.applied) {
					if (this.discount.applies_to == 'plan') {
						var discount = 0;
						if (this.discount.type == 'percentage') {
							discount = this.total_sub * (this.discount.amount / 100);
						}
						else if (this.discount.type == 'amount') {
							discount = (this.discount.amount / 100);
						}

						amount -= discount;
					}
				}

				return amount;
			}
		},
		methods: {
			nextStep: function () {
				var currentStep = $(".step[data-step='" + this.step + "']");
				var nextStep = $(".step[data-step='" + (this.step + 1) + "']");
				var currentSubStep = currentStep.find(".sub_step[data-sub-step='" + this.sub_step + "']");
				var nextSubStep = currentStep.find(".sub_step[data-sub-step='" + (this.sub_step + 1) + "']");

				if (nextSubStep[0]) {
					this.sub_step = nextSubStep.attr("data-sub-step") * 1;

					currentSubStep.removeClass("sub_step--active").removeClass('sub_step--active-animated').removeClass("sub_step--slideout-prev").removeClass("sub_step--prev").addClass("sub_step--out-animated");
					nextSubStep.addClass('sub_step--active').removeClass("sub_step--slideout-prev").removeClass("sub_step--prev").addClass('sub_step--active-animated').removeClass("sub_step--out-animated");

					if (nextSubStep.hasClass('sub_step--skip')) {
						this.nextStep();
					}

					return true;
				}

				this.step++;
				this.sub_step = 1;

				currentStep.removeClass("step--active");
				nextStep.addClass("step--active");

				var newHeight = 1;
				nextStep.find(".sub_step").each(function () {
					if ($(this).height() > newHeight) {
						newHeight = $(this).height();
					}
				});

				nextStep.css("min-height", newHeight * 1.2);

				this.checkIfShouldGetCombinations();

				var curSubStep = nextStep.find(".sub_step[data-sub-step='" + this.sub_step + "']");

				if (curSubStep.hasClass('sub_step--skip')) {
					this.nextStep();
				}

				return true;
			},

			getSubStepsForStep: function (step) {
				step = step || this.step;
				return $(".step[data-step='" + step + "']:not(.sub_step--skip)").find(".sub_step").length;
			},

			goToRecommendations: function () {
				var steps = $(".sub_step:not(.sub_step--skip)").length;
				for (var i = 1; i <= steps; i++) {
					this.nextStep();
				}
			},

			getCombinations: function (useTimeout) {
				var time = 0;
				var app = this;
				var delay = parseInt("{{ $delay }}");

				combinationAjax = $.ajax({
					url: '{{ URL::route('flow-recommendations') }}',
					method: 'POST',
					dataType: 'JSON',
					cache: true,
					data: {user_data: JSON.stringify(app.user_data)},
					beforeSend: function () {
						time = new Date();
					},
					success: function (response) {
						var curTime = new Date();

						var timeout = curTime.getTime() - time.getTime();

						if (timeout >= delay || !useTimeout) {
							timeout = delay - 1;
						}

						combinationTimeout = setTimeout(function () {
							$("#advises-content").html(response.advises);
							$("#advises-label").html(response.label);
							$("#link-to-change").attr('href', ('{{ URL::route('pick-n-mix') }}?selected=' + response.selected_codes));
							app.result = response.result;
							app.extra_totals = response.totals;
							app.recommendation_token = response.token;

							$("#advises-loader").hide();
							$("#advises-block").fadeIn();
						}, delay - timeout);
					}
				});
			},

			checkIfShouldGetCombinations: function () {
				if (this.step == 4) {
					if (combinationAjax) {
						combinationAjax.abort();
					}

					if (combinationTimeout) {
						clearTimeout(combinationTimeout);
					}

					this.getCombinations(true);
				}
				else {
					$("#advises-block").hide();
					$("#advises-loader").show();
					$("#advises-content").html('');
					$("#advises-label").html('');
				}
			},

			previousStep: function () {
				if (this.sub_step == 1 && this.step == 1) {
					return false;
				}

				// resets some data
				if (this.step < 4) {
					$.each($("[name='step[" + this.step + "][" + this.sub_step + "]']"), function(i, input)
					{
						var model = $(input).data('model');

						var modelParts = model.split('.');

						if (modelParts.length == 1) {
							app.user_data[modelParts[0]] = $(input).data('default') !== undefined ? $(input).data('default') : null;
						}
						else {
							app.user_data[modelParts[0]][modelParts[1]] = $(input).data('default') !== undefined ? $(input).data('default') : null;
						}
					});
				}

				var currentStep = $(".step[data-step='" + this.step + "']");
				var previousStep = $(".step[data-step='" + (this.step - 1) + "']");

				if (this.sub_step > 1) {
					var currentSubStep = currentStep.find(".sub_step[data-sub-step='" + this.sub_step + "']");
					var previousSubStep = currentStep.find(".sub_step[data-sub-step='" + (this.sub_step - 1) + "']");

					if (previousSubStep[0]) {
						this.sub_step = previousSubStep.attr("data-sub-step") * 1;

						currentSubStep.removeClass("sub_step--active").removeClass('sub_step--active-animated').addClass("sub_step--slideout-prev").addClass("sub_step--out-animated").removeClass("sub_step--prev");
						previousSubStep.addClass('sub_step--active').addClass("sub_step--prev").addClass('sub_step--active-animated').removeClass("sub_step--out-animated");

						if (previousSubStep.hasClass('sub_step--skip')) {
							this.previousStep();
						}

						return true;
					}
				}

				var numberOfSubStepsInPreviousStep = previousStep.find(".sub_step").length;

				this.step--;
				this.sub_step = numberOfSubStepsInPreviousStep;

				currentStep.removeClass("step--active");
				previousStep.addClass("step--active");

				this.checkIfShouldGetCombinations();

				var curSubStep = previousStep.find(".sub_step[data-sub-step='" + this.sub_step + "']");

				if (curSubStep.hasClass('sub_step--skip')) {
					this.previousStep();
				}

				return true;
			},

			moreInfo: function (element, event) {
				event.preventDefault();
				event.stopPropagation();

				switch (element) {
					@foreach(trans('flow.info') as $infoKey => $info)
					case "{{ $infoKey }}":
						swal("{!! $info !!}");
						break;
					@endforeach
				}
			},

			getAge: function () {
				if (this.user_data.birthdate === null) {
					return null;
				}

				var today = new Date();
				var birthDate = new Date(this.user_data.birthdate);
				var age = today.getFullYear() - birthDate.getFullYear();
				var m = today.getMonth() - birthDate.getMonth();
				if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
					age--;
				}

				if (age !== undefined && age > 0) {
					this.user_data.age = age;

					return this.user_data.age;
				}

				return false;
			},

			shouldJumpToNext: function (elementId, length, event) {
				if (length === false || event.target.value.length >= length) {
					$("#" + elementId).select();
					return true;
				}

				return false;
			}
		},
		filters: {
			base64: function (value) {
				return btoa(value);
			}
		}
	});

	@if(count($userData) > 0)
		app.user_data = JSON.parse('{!! json_encode($userData) !!}');

		// This part is only for securing that Vue has updated elements..
		// I've not found it necessary but rather safe than sorry.
		setTimeout(function () {
			app.goToRecommendations();
		}, 50);
	@endif

</script>