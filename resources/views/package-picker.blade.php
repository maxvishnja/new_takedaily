@extends('layouts.app')

@section('pageClass', 'page-flow page-package-pick')

@section('mainClasses', 'm-b-50')

@section('title', trans('pick-package.title'))

@section('content')
	<div class="header_image">
		<div class="container text-center">
			<h1>{{ trans('pick-package.title') }}</h1>
			<h2>{{ trans('pick-package.sub-title') }}</h2>
		</div>
	</div>

	<div class="container flow-container" id="app">
		<form action="{{ url()->route('pick-package-post')}}" method="post">
			<div style="position: relative; z-index: 2; margin-bottom: -50px" v-show="step <= 1">
				<div class="container">
					<div class="flow-step-back" v-bind:class="{ 'clickable': step > 1 || sub_step > 1}" style="margin-bottom: 0;">
						<a href="javascript: void(0);" v-on:click="previousStep();">{{ trans('flow.back') }}</a>
					</div>

					@include('flow-includes.views.steps.one')
				</div>
			</div>

			<div class="clear"></div>


			<div v-cloak="" class="packages" v-bind:class="{ 'packages--blurred': step <= 1}">
				<div v-for="package in packages" class="package">
					<strong v-html="package.name"></strong>

					<div class="promise_icons">
						<span v-for="icon in package.icons" v-bind:class="'icon icon-' + icon + '-flow'"></span>
					</div>

					<div v-html="package.description"></div>

					<div class="package_bottom">
						<a v-bind:href="'{{ url()->route('pick-package-select', ['id' => '']) }}/' + package.id"
						   class="button button--green">{{ trans('pick-package.select-btn') }}</a>
						<a href="#" class="button button--light">{{ trans('pick-package.read-btn') }}</a>
					</div>
				</div>


				{{ csrf_field() }}
				<input type="hidden" name="package_id" v-model="selected_package"/>
				<textarea name="user_data" style="display: none">@{{ user_data | json }}</textarea>
			</div>
		</form>
	</div>
@endsection

@section('footer_scripts')
	@include('flow-includes.scripts.window')
	@include('flow-includes.scripts.toggles')

	<script>
		var app = new Vue({
			el: '#app',
			data: {
				step: 1,
				sub_step: 1,
				current_advise_one: null,
				current_advise_two: null,
				current_advise_three: null,
				temp_age: null,
				user_data: {
					gender: null,
					birthdate: null,
					age: null,
					skin: null,
					outside: null,
					custom: {
						one: "",
						two: "",
						three: ""
					}
				},
				packages: [@foreach($packages as $package) {
					name: "{{ trans("pick-package.packages.{$package->identifier}.name") }}",
					description: "{{ nl2br(str_replace ("\n", "", trans("pick-package.packages.{$package->identifier}.description"))) }}",
					id: parseInt("{{ $package->id }}"),
					icons: [
						@if(is_array(trans("pick-package.packages.{$package->identifier}.icons")))
							@foreach(trans("pick-package.packages.{$package->identifier}.icons") as $icon)
							"{{ $icon }}",
						@endforeach
						@endif
					]
				}, @endforeach]
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
				}
			},
			methods: {
				submitTheForm: function () {
					setTimeout(function () {
						$("#package-form").submit();
					}, 150);
				},

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

					if (this.step == 2) {
						@if(!$package->hasChoice($package->group_three))
							this.submitTheForm();
						@endif
					}

					currentStep.removeClass("step--active");
					nextStep.addClass("step--active");

					var newHeight = 1;
					nextStep.find(".sub_step").each(function () {
						if ($(this).height() > newHeight) {
							newHeight = $(this).height();
						}
					});

					nextStep.css("min-height", newHeight * 1.2);


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

				previousStep: function () {
					if (this.sub_step == 1 && this.step == 1) {
						return false;
					}

					// resets some data
					if (this.step < 4) {
						$.each($("[name='step[" + this.step + "][" + this.sub_step + "]']"), function (i, input) {
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


					var curSubStep = previousStep.find(".sub_step[data-sub-step='" + this.sub_step + "']");

					if (curSubStep.hasClass('sub_step--skip')) {
						this.previousStep();
					}

					return true;
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
	</script>
@endsection