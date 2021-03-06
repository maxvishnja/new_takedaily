@extends('layouts.app')

@section('pageClass', 'page-flow page-package-pick page-package-pick-select')

@section('mainClasses', 'm-b-50 m-t-50')

@section('title', trans('pick-package.title'))

@section('content')
	<div class="container flow-container" id="app">
		<h1 class="text-center">{{ trans('pick-package.select.title') }}</h1>
		<div>
			<form action="{{ url()->route('pick-package-post')}}" id="package-form" method="post">
				<div style="position: relative">
					<div class="container">
						<div class="flow-step-back" v-bind:class="{ 'clickable': step > 1 || sub_step > 1}">
							<a href="javascript: void(0);" v-on:click="previousStep();">{{ trans('flow.back') }}</a>
						</div>

						@if($package->hasChoice($package->group_three))
							<div class="step" data-step="1">
								<div class="sub_step sub_step--active" data-sub-step="1">
									<h3 class="substep-title">{{ trans('pick-package.custom-pill') }}</h3>
									<div class="sub_step_answers">
										@foreach($package->getChoices($package->group_three) as $choice)
											<label>
												<input type="radio" name="step[3][{{ $choice }}]" value="{{ $choice }}" v-model="user_data.custom.three" data-model="custom.three"
													   v-on:click="submitTheForm();"/>
												<span class="icon pill-3{{ $choice }}"></span>
												<br/>{{ \App\Apricot\Libraries\PillLibrary::$codes["3{$choice}"] }}
												<br/><span style="font-weight: normal; font-size: 12px;">{{ trans("pick-package.pills.3{$choice}") }}</span></label>
										@endforeach
									</div>
									<p class="substep-explanation">{{ trans('flow.questions.3-1.text') }}</p>
								</div>
							</div>
						@endif
					</div>
				</div>

				<input type="hidden" name="package_id" value="{{ $package->id }}"/>
				{{ csrf_field() }}
				<textarea name="user_data" style="display: none">@{{ user_data | json }}</textarea>
			</form>
		</div>
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
					@if($package->hasChoice($package->group_one))
						gender: null,
						birthdate: null,
						age: null,
						skin: null,
						outside: null,
					@endif
					custom: {
						@if(!$package->hasChoice($package->group_one))
							one: "{{ $package->group_one }}",
						@endif

						@if(!$package->hasChoice($package->group_two))
							two: "{{ $package->group_two }}",
						@endif

						@if(!$package->hasChoice($package->group_three))
							three: "{{ $package->group_three }}",
						@endif
					}
				}
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

					if(this.step == 2)
					{
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