<script>
	var app = new Vue({
		el: '#app',
		data: {
			recommendation: {
				hasOil: false
			},
			save_request: null,
			step: 1,
			sub_step: 1,
			current_advise_one: null,
			current_advise_two: null,
			current_advise_three: null,
			temp_age: null,
			recommendation_token: '',
			result: {},
			totals: [],
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
				locale: '{{ App::getLocale() }}',
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
				custom: {},
				replacements: [],
				foods: {
					fruits: null,
					vegetables: null,
					bread: null,
					wheat: null,
					dairy: null,
					meat: null,
					fish: null,
					butter: null
				}
			}
		},
		watch: {
			'user_data.pregnancy.week': function (val, oldVal) {
				if (val != '0' && val != 0) {
					this.user_data.pregnancy.wish = 0;
				}
			},
			'user_data.pregnancy.wish': function (val, oldVal) {
				if (val != '0' && val != 0) {
					this.user_data.pregnancy.week = 0;
				}
			}
		},
		computed: {
			temp_age: function () {
				return this.getAge();
			},
			total_sum: function () {
				var sum = 0;

				$.each(this.totals, function (i, line) {
					sum += line.price;
				});

				if (app.discount.applied) {
					if (app.discount.type == 'amount') {
						sum -= app.discount.amount;
					}
					else if (app.discount.type == 'free_shipping') {
						sum *= (1 - (100 / 100));
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
				else if (this.discount.type == 'free_shipping') {
					total = '100%';
				}
				else if (this.discount.type == 'percentage') {
					total = this.discount.amount + '%';
				}

				return total;
			},
			total_subscription: function () {
				var amount = 0;

				$.each(this.totals, function (i, line) {
					amount += line.price;
				});

				if (this.discount.applied) {
					if (this.discount.applies_to == 'plan') {
						var discount = 0;
						if (this.discount.type == 'percentage') {
							discount = amount * (this.discount.amount / 100);
						}
						else if (this.discount.type == 'amount') {
							discount = this.discount.amount;
						}
						else if (this.discount.type == 'free_shipping') {
							discount = amount * (100 / 100);
						}

						amount -= discount;
					}
				}

				return amount;
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
				return this.total * this.tax_rate;
			},
			total: function () {
				return this.total_sum;
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
			},

			removeVitamin: function (vitamin) {
				if ($("#advises-label").find('.removePillButton').length == 2) {
					$("#advises-label").find('.removePillButton').remove();
				}

				$(".vitamin-item-for-recommendation[data-vitamin='" + vitamin + "']").fadeOut(350, function () {
					$(this).remove();
				});

				$("#advises-vitamins").find(".ingredient_item[data-vitamin='" + vitamin + "']").remove();
				$("#advises-content").find(".advise-paragraph[data-vitamin='" + vitamin + "']").remove();

				window.location.href = $("#link-to-change").attr('href').replace(vitamin, '');
			},

			nextStep: function (saveState) {

				saveState = saveState !== undefined ? saveState : true;


				setTimeout(function () {

					var currentStep = $(".step[data-step='" + app.step + "']");
					var nextStep = $(".step[data-step='" + (app.step + 1) + "']");
					var currentSubStep = currentStep.find(".sub_step[data-sub-step='" + app.sub_step + "']");
					var nextSubStep = currentStep.find(".sub_step[data-sub-step='" + (app.sub_step + 1) + "']");
					if(app.sub_step+1 == 11){
						ga('send', 'event', 'flow' , 'started', 'question.3-1');
					}
					if (nextSubStep[0]) {
						app.sub_step = nextSubStep.attr("data-sub-step") * 1;

						currentSubStep.removeClass("sub_step--active").removeClass('sub_step--active-animated').removeClass("sub_step--slideout-prev").removeClass("sub_step--prev").addClass("sub_step--out-animated");
						nextSubStep.addClass('sub_step--active').removeClass("sub_step--slideout-prev").removeClass("sub_step--prev").addClass('sub_step--active-animated').removeClass("sub_step--out-animated");

						if (nextSubStep.hasClass('sub_step--skip')) {
							app.nextStep(saveState);
						}
						var step = currentStep.find('.sub_step--active').not('.sub_step--skip').data('sub-step');

						if(step && step != "undefined"){
							ga('send', 'event', 'flow' , 'started', 'question.'+app.step+'-'+step);
						}
						if (saveState) {
							app.updateSavedState();
						}

						return true;
					}

					app.step++;
					app.sub_step = 1;

					currentStep.removeClass("step--active");
					nextStep.addClass("step--active");

					var newHeight = 1;
					nextStep.find(".sub_step").each(function () {
						if ($(this).height() > newHeight) {
							newHeight = $(this).height();
						}
					});

					nextStep.css("min-height", newHeight * 1.2);

					app.checkIfShouldGetCombinations();

					var curSubStep = nextStep.find(".sub_step[data-sub-step='" + app.sub_step + "']");

					if (curSubStep.hasClass('sub_step--skip')) {
						app.nextStep(saveState);
					}

					if (saveState) {
						app.updateSavedState();
					}

					return true;
				}, 5);

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

			goToStep: function (step, sub_steps) {
				var isDone = false;

				var theInterval = setInterval(function () {
					if ((app.step >= step && app.sub_step >= sub_steps) || app.step >= 4) {
						isDone = true;
						clearInterval(theInterval);
					}

					if (!isDone) {
						app.nextStep(false);
					}
				}, 25);
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
							$("#advises-label").html(response.label);
							$("#link-to-change").attr('href', ('{{ URL::route('pick-n-mix') }}?selected=' + response.selected_codes + '&flow_token=' + response.token));
							app.result = response.result;
							app.recommendation_token = response.token;

							$("#advises-loader").hide();
							$("#advises-block").fadeIn();
							app.getCart();

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
					$("#advises-label").html('');
				}
			},

			updateSavedState: function () {
				app.save_request = $.ajax({
					url: '{{ url()->route('save-flow-state') }}',
					method: 'POST',
					dataType: 'JSON',
					cache: false,
					data: {
						user_data: app.user_data,
						step: app.step,
						sub_step: app.sub_step
					},
					beforeSend: function () {
						if (app.save_request !== null) {
							app.save_request.abort();
						}
					},
					success: function () {
						app.save_request = null;
					}
				});
			},

			previousStep: function (saveState) {
				if (app.sub_step == 1 && app.step == 1) {
					return false;
				}

				saveState = saveState !== undefined ? saveState : true;

				setTimeout(function () {
					// resets some data
					if (app.step < 4) {
						$.each($("[name='step[" + app.step + "][" + app.sub_step + "]']"), function (i, input) {
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

					var currentStep = $(".step[data-step='" + app.step + "']");
					var previousStep = $(".step[data-step='" + (app.step - 1) + "']");

					if (app.sub_step > 1) {
						var currentSubStep = currentStep.find(".sub_step[data-sub-step='" + app.sub_step + "']");
						var previousSubStep = currentStep.find(".sub_step[data-sub-step='" + (app.sub_step - 1) + "']");

						if (previousSubStep[0]) {
							app.sub_step = previousSubStep.attr("data-sub-step") * 1;

							currentSubStep.removeClass("sub_step--active").removeClass('sub_step--active-animated').addClass("sub_step--slideout-prev").addClass("sub_step--out-animated").removeClass("sub_step--prev");
							previousSubStep.addClass('sub_step--active').addClass("sub_step--prev").addClass('sub_step--active-animated').removeClass("sub_step--out-animated");

							if (previousSubStep.hasClass('sub_step--skip')) {
								app.previousStep(saveState);
							}

							if (saveState) {
								app.updateSavedState();
							}

							return true;
						}
					}

					var numberOfSubStepsInPreviousStep = previousStep.find(".sub_step").length;

					app.step--;
					app.sub_step = numberOfSubStepsInPreviousStep;

					currentStep.removeClass("step--active");
					previousStep.addClass("step--active");

					app.checkIfShouldGetCombinations();

					var curSubStep = previousStep.find(".sub_step[data-sub-step='" + app.sub_step + "']");

					if (curSubStep.hasClass('sub_step--skip')) {
						app.previousStep();
					}

					if (saveState) {
						app.updateSavedState();
					}

					return true;
				}, 5);
			},

			moreInfo: function (element, event) {
				event.preventDefault();
				event.stopPropagation();
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

	if(app.step == 1 && app.sub_step == 1){
		ga('send', 'event', 'flow' , 'started', 'question.1-1');
	}

	@if(count($userData) > 0)
		app.user_data = JSON.parse('{!! json_encode($userData) !!}');

	// This part is only for securing that Vue has updated elements..
	// I've not found it necessary but rather safe than sorry.
	setTimeout(function () {
		app.goToRecommendations();
	}, 50);
	@endif

		@if($savedState !== null && count($userData) === 0)
		app.user_data = JSON.parse('{!! $savedState->user_data !!}');
		// This part is only for securing that Vue has updated elements..
		// I've not found it necessary but rather safe than sorry.
		setTimeout(function () {
			app.goToStep(parseInt("{{ $savedState->step }}"), parseInt("{{ $savedState->sub_step }}"));
		}, 50);
	@endif

	$("#advises-label").on('click', '.removePillButton', function () {
		app.removeVitamin($(this).data('vitamin'));
	});

	$("#advises-label").on('click', '.customVitaminButton', function (e) {
		if(app.user_data.replacements == undefined){
			app.user_data.replacements =[];
		}
		e.preventDefault();
		var vitamin = $(this).data('vitamin');
		var old_vitamin = $(this).data('oldvitamin');
		app.user_data.replacements.push({old_vitamin: old_vitamin, new_vitamin: vitamin});

		$('#new_vitamin_field').val(vitamin);

		app.getCombinations(false);
	});

	$("#advises-label").on('click', '.readMoreBtn', function (e) {
		e.preventDefault();

		$(this).hide();
		$(this).parent().find('.readLessBtn').show();
		$(this).parent().parent().find('.description').stop().slideToggle(200);
	});

	$("#advises-label").on('click', '.readLessBtn', function (e) {
		e.preventDefault();

		$(this).hide();
		$(this).parent().find('.readMoreBtn').show();
		$(this).parent().parent().find('.description').stop().slideToggle(200);
	});

	$("#advises-label").on('click', '.seeIngredientsBtn', function (e) {
		e.preventDefault();

		$(this).parent().parent().find('.ingredients').stop().slideToggle(200);
	});

	function forceUpdateAndSubmit() {

		var newVitamin = $('#new_vitamin_field').val();
		var form = $("#flow_form");
		form.append('<input type="hidden" name="update_only" value="1" />');
		form.append('<input name="new_vitamin" id="new_vitamin_field" type="hidden" value="'+newVitamin+'" style="display:none;">');
		form.submit();
	}


	function updateNewVitamin(){
		ga('send', 'event', 'flow', 'completed', 'all');
		var newVitamin = $('#new_vitamin_field').val();
		var form = $("#flow_form");
		form.append('<input name="new_vitamin" id="new_vitamin_field" type="hidden" value="'+newVitamin+'" style="display:none;">');
		form.submit();
	}
</script>