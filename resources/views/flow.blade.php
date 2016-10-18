@extends('layouts.app')

@section('pageClass', 'page-flow')

@section('mainClasses', 'm-b-50')

@section('title', trans('flow.title'))

@section('content')
	<noscript>
		<style>
			#app {
				display: none !important;
			}
		</style>

		<h1 class="text-center">{{ trans('flow.scripts') }}</h1>
	</noscript>

	<div id="app" class="flow-container">
		<div class="flow-progress flow-progress--closed">

			<div id="flow-toggler"><span class="icon-arrow-down-lines"></span></div>

			<div>
				<div class="flow-step" step="1"
					 v-bind:class="{ 'flow-step--inactive': step !== 1, 'flow-step--completed': step > 1 }">
					<div class="flow-step-progress">
						<span class="flow-step-progress-bar"
							  v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
					<div class="flow-step-check">
						<div class="icon icon-check"></div>
					</div>
					<div class="flow-step-title">{{ trans('flow.steps.one') }}</div>
				</div>
				<div class="flow-step flow-step--inactive" step="2"
					 v-bind:class="{ 'flow-step--inactive': step !== 2, 'flow-step--completed': step > 2 }">
					<div class="flow-step-progress">
						<span class="flow-step-progress-bar"
							  v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
					<div class="flow-step-check">
						<div class="icon icon-check"></div>
					</div>
					<div class="flow-step-title">{{ trans('flow.steps.two') }}</div>
				</div>
				<div class="flow-step flow-step--inactive" step="3"
					 v-bind:class="{ 'flow-step--inactive': step !== 3, 'flow-step--completed': step > 3 }">
					<div class="flow-step-progress">
						<span class="flow-step-progress-bar"
							  v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
					<div class="flow-step-check">
						<div class="icon icon-check"></div>
					</div>
					<div class="flow-step-title">{{ trans('flow.steps.three') }}</div>
				</div>
				<div class="flow-step flow-step--inactive" step="4"
					 v-bind:class="{ 'flow-step--inactive': step !== 4 }">
					<div class="flow-step-title">{{ trans('flow.steps.four') }}</div>
				</div>
			</div>
		</div>

		<div class="container">

			<div class="flow-step-back" v-bind:class="{ 'clickable': step > 1 || sub_step > 1}">
				<a href="javascript: void(0);" v-on:click="previousStep();">{{ trans('flow.back') }}</a>
			</div>

			<form method="post" action="">
				<div data-step="1" class="step step--active">
					<div data-sub-step="1" class="sub_step sub_step--active">
						<h3 class="substep-title">{{ trans('flow.questions.1-1.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[1][1]" value="1" v-model="user_data.gender"
									   v-on:click="nextStep();"/>
								<span class="icon icon-gender-male"></span>
								<br/>{{ trans('flow.questions.1-1.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[1][1]" value="2" v-model="user_data.gender"
									   v-on:click="nextStep();"/>
								<span class="icon icon-gender-female"></span>
								<br/>{{ trans('flow.questions.1-1.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.1-1.text') }}</p>
					</div>

					<div data-sub-step="2" class="sub_step">
						<h3 class="substep-title"
							v-show="user_data.gender == 1">{{ trans('flow.questions.1-2.title') }}</h3>
						<h3 class="substep-title"
							v-show="user_data.gender == 2">{{ trans('flow.questions.1-2.title-alt') }}</h3>

						<div class="datepicker-container-block">
							<label for="birthdate-picker" class="text-center flow_label_noclick" id="openPicker">
								<span class="icon calendar-icon"
									  style="vertical-align: middle; margin-right: 6px;"></span>
								<span>{{ trans('flow.questions.1-2.button-text') }}</span>
							</label>

							<input type="text" name="step[1][1]" v-model="user_data.birthdate" id="birthdate-picker"
								   style="display: none;"/>
						</div>

						<template v-if="temp_age">
							<br/>
							<button v-on:click="nextStep();" type="button"
									class="button button--rounded button--medium button--green">{!! trans('flow.questions.1-2.button-submit-text') !!}</button>
						</template>

						<p class="substep-explanation">{{ trans('flow.questions.1-2.text') }}</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.1-3.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[1][3]" value="1" v-model="user_data.skin"
									   v-on:click="nextStep();"/>
								<span class="icon icon-skin-white"></span>
								<br/>{{ trans('flow.questions.1-3.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[1][3]" value="2" v-model="user_data.skin"
									   v-on:click="nextStep();"/>
								<span class="icon icon-skin-mediterranean"></span>
								<br/>{{ trans('flow.questions.1-3.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[1][3]" value="3" v-model="user_data.skin"
									   v-on:click="nextStep();"/>
								<span class="icon icon-skin-dark"></span>
								<br/>{{ trans('flow.questions.1-3.options.3') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.1-3.text') }}</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.1-4.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[1][4]" value="1" v-model="user_data.outside"
									   v-on:click="nextStep();"/>
								<span class="icon icon-sun-yes"></span>
								<br/>{{ trans('flow.questions.1-4.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[1][4]" value="2" v-model="user_data.outside"
									   v-on:click="nextStep();"/>
								<span class="icon icon-sun-no"></span>
								<br/>{{ trans('flow.questions.1-4.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.1-4.text') }}</p>
					</div>
				</div>

				<div data-step="2" class="step">
					<div data-sub-step="1" class="sub_step sub_step--active" v-bind:class="{ 'sub_step--skip': temp_age > 50 || user_data.gender == 1 }">
						<h3 class="substep-title">{{ trans('flow.questions.2-1.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][1]" value="1" v-model="user_data.pregnant"
									   v-on:click="nextStep();"/>
								<span class="icon icon-pregnant-yes"></span>
								<br/>{{ trans('flow.questions.2-1.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][1]" value="2" v-model="user_data.pregnant"
									   v-on:click="nextStep();"/>
								<span class="icon icon-pregnant-no"></span>
								<br/>{{ trans('flow.questions.2-1.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{!! trans('flow.questions.2-1.text') !!}</p>
					</div>

					<div data-sub-step="2" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-2.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][2]" value="1" v-model="user_data.diet"
									   v-on:click="nextStep();"/>
								<span class="icon icon-diet-pear"></span>
								<br/>{{ trans('flow.questions.2-2.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][2]" value="2" v-model="user_data.diet"
									   v-on:click="nextStep();"/>
								<span class="icon icon-diet-burger"></span>
								<br/>{{ trans('flow.questions.2-2.options.2') }}
							</label>
						</div>
						<p class="substep-explanation">{{ trans('flow.questions.2-2.text') }}</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-3.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][3]" value="1" v-model="user_data.sports"
									   v-on:click="nextStep();"/>
								<span class="icon icon-activity-seldom"></span>
								<br/>{{ trans('flow.questions.2-3.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][3]" value="2" v-model="user_data.sports"
									   v-on:click="nextStep();"/>
								<span class="icon icon-activity-once"></span>
								<br/>{{ trans('flow.questions.2-3.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[2][3]" value="3" v-model="user_data.sports"
									   v-on:click="nextStep();"/>
								<span class="icon icon-activity-twice"></span>
								<br/>{{ trans('flow.questions.2-3.options.3') }}
							</label>
							<label>
								<input type="radio" name="step[2][3]" value="4" v-model="user_data.sports"
									   v-on:click="nextStep();"/>
								<span class="icon icon-activity-more"></span>
								<br/>{{ trans('flow.questions.2-3.options.4') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-3.text') }}</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-4.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][4]" value="1" v-model="user_data.stressed"
									   v-on:click="nextStep();"/>
								<span class="icon icon-stress"></span>
								<br/>{{ trans('flow.questions.2-4.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][4]" value="2" v-model="user_data.stressed"
									   v-on:click="nextStep();"/>
								<span class="icon icon-joy"></span>
								<br/>{{ trans('flow.questions.2-4.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-4.text') }}</p>
					</div>

					<div data-sub-step="5" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-5.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][5]" value="1" v-model="user_data.lacks_energy"
									   v-on:click="nextStep();"/>
								<span class="icon icon-tired"></span>
								<br/>{{ trans('flow.questions.2-5.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][5]" value="2" v-model="user_data.lacks_energy"
									   v-on:click="nextStep();"/>
								<span class="icon icon-awake"></span>
								<br/>{{ trans('flow.questions.2-5.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[2][5]" value="3" v-model="user_data.lacks_energy"
									   v-on:click="nextStep();"/>
								<span class="icon icon-fresh"></span>
								<br/>{{ trans('flow.questions.2-5.options.3') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-5.text') }}</p>
					</div>

					<div data-sub-step="6" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-6.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][6]" value="1" v-model="user_data.immune_system"
									   v-on:click="nextStep();"/>
								<span class="icon icon-immune-boost"></span>
								<br/>{{ trans('flow.questions.2-6.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][6]" value="2" v-model="user_data.immune_system"
									   v-on:click="nextStep();"/>
								<span class="icon icon-immune-ignore"></span>
								<br/>{{ trans('flow.questions.2-6.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-6.text') }}
						</p>
					</div>

					<div data-sub-step="7" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-7.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][7]" value="1" v-model="user_data.smokes"
									   v-on:click="nextStep();"/>
								<span class="icon icon-smoke"></span>
								<br/>{{ trans('flow.questions.2-7.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][7]" value="2" v-model="user_data.smokes"
									   v-on:click="nextStep();"/>
								<span class="icon icon-smoke-no"></span>
								<br/>{{ trans('flow.questions.2-7.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-7.text') }}</p>
					</div>

					<div data-sub-step="8" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-8.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][8]" value="1" v-model="user_data.vegetarian"
									   v-on:click="nextStep();"/>
								<span class="icon icon-vegetarian-yes"></span>
								<br/>{{ trans('flow.questions.2-8.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][8]" value="2" v-model="user_data.vegetarian"
									   v-on:click="nextStep();"/>
								<span class="icon icon-meat"></span>
								<br/>{{ trans('flow.questions.2-8.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-8.text') }}</p>
					</div>

					<div data-sub-step="9" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-9.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][9]" value="1" v-model="user_data.joints"
									   v-on:click="nextStep();"/>
								<span class="icon icon-joint-yes"></span>
								<br/>{{ trans('flow.questions.2-9.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][9]" value="2" v-model="user_data.joints"
									   v-on:click="nextStep();"/>
								<span class="icon icon-joint-no"></span>
								<br/>{{ trans('flow.questions.2-9.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-9.text') }}</p>
					</div>

					<div data-sub-step="10" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.2-10.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][10]" value="1" v-on:click="nextStep();"
									   v-model="user_data.supplements"/>
								<span class="icon icon-supplement-yes"></span>
								<br/>{{ trans('flow.questions.2-10.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][10]" value="2" v-on:click="nextStep();"
									   v-model="user_data.supplements"/>
								<span class="icon icon-supplement-no"></span>
								<br/>{{ trans('flow.questions.2-10.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-10.text') }}</p>
					</div>
				</div>

				<div data-step="3" class="step">
					<div data-sub-step="1" class="sub_step sub_step--active">
						<h3 class="substep-title">{{ trans('flow.questions.3-1.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][1]" value="1" v-model="user_data.foods.vegetables"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-1"></span>
								<br/>{{ trans('flow.questions.3-1.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="2" v-model="user_data.foods.vegetables"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-2"></span>
								<br/>{{ trans('flow.questions.3-1.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="3" v-model="user_data.foods.vegetables"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-3"></span>
								<br/>{{ trans('flow.questions.3-1.options.3') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="4" v-model="user_data.foods.vegetables"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-4"></span>
								<br/>{{ trans('flow.questions.3-1.options.4') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="5" v-model="user_data.foods.vegetables"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-5"></span>
								<br/>{{ trans('flow.questions.3-1.options.5') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-1.text') }}</p>
					</div>

					<div data-sub-step="2" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-2.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="1"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-fruit-1"></span>
								<br/>{{ trans('flow.questions.3-2.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="2"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-fruit-2"></span>
								<br/>{{ trans('flow.questions.3-2.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="3"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-fruit-3"></span>
								<br/>{{ trans('flow.questions.3-2.options.3') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-2.text') }}</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-3.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][3]" value="1" v-model="user_data.foods.bread"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-1"></span>
								<br/>{{ trans('flow.questions.3-3.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="2" v-model="user_data.foods.bread"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-2"></span>
								<br/>{{ trans('flow.questions.3-3.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="3" v-model="user_data.foods.bread"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-3"></span>
								<br/>{{ trans('flow.questions.3-3.options.3') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="4" v-model="user_data.foods.bread"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-4"></span>
								<br/>{{ trans('flow.questions.3-3.options.4') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="5" v-model="user_data.foods.bread"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-5"></span>
								<br/>{{ trans('flow.questions.3-3.options.5') }}</label>
						</div>

						<p class="substep-explanation">{!! trans('flow.questions.3-3.text') !!}</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-4.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][4]" value="1" v-model="user_data.foods.butter"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-butter-yes"></span>
								<br/>{{ trans('flow.questions.3-4.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[3][4]" value="2" v-model="user_data.foods.butter"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-butter-no"></span>
								<br/>{{ trans('flow.questions.3-4.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[3][4]" value="3" v-model="user_data.foods.butter"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-butter-sometimes"></span>
								<br/>{{ trans('flow.questions.3-4.options.3') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-4.text') }}</p>
					</div>

					<div data-sub-step="5" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-5.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][5]" value="1" v-model="user_data.foods.wheat"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-1"></span>
								<br/>{{ trans('flow.questions.3-5.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][5]" value="2" v-model="user_data.foods.wheat"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-2"></span>
								<br/>{{ trans('flow.questions.3-5.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][5]" value="3" v-model="user_data.foods.wheat"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-3"></span>
								<br/>{{ trans('flow.questions.3-5.options.3') }}</label>
							<label>
								<input type="radio" name="step[3][5]" value="4" v-model="user_data.foods.wheat"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-4"></span>
								<br/>{{ trans('flow.questions.3-5.options.4') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-5.text') }}</p>
					</div>

					<div data-sub-step="6" class="sub_step"
						 v-bind:class="{'sub_step--skip': user_data.vegetarian == 1 }">
						<h3 class="substep-title">{{ trans('flow.questions.3-6.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][6]" value="1" v-model="user_data.foods.meat"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-meat-1"></span>
								<br/>{{ trans('flow.questions.3-6.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][6]" value="2" v-model="user_data.foods.meat"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-meat-2"></span>
								<br/>{{ trans('flow.questions.3-6.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][6]" value="3" v-model="user_data.foods.meat"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-meat-3"></span>
								<br/>{{ trans('flow.questions.3-6.options.3') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-6.text') }}</p>
					</div>

					<div data-sub-step="7" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-7.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][7]" value="1" v-model="user_data.foods.fish"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-fish-1"></span>
								<br/>{{ trans('flow.questions.3-7.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[3][7]" value="2" v-model="user_data.foods.fish"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-fish-2"></span>
								<br/>{{ trans('flow.questions.3-7.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[3][7]" value="3" v-model="user_data.foods.fish"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-fish-3"></span>
								<br/>{{ trans('flow.questions.3-7.options.3') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-7.text') }}</p>
					</div>

					<div data-sub-step="8" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-8.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][8]" value="1" v-model="user_data.foods.dairy"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-milk-1"></span>
								<br/>{{ trans('flow.questions.3-8.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[3][8]" value="2" v-model="user_data.foods.dairy"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-milk-2"></span>
								<br/>{{ trans('flow.questions.3-8.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[3][8]" value="3" v-model="user_data.foods.dairy"
									   v-on:click="nextStep();"/>
								<span class="icon icon-portion-milk-3"></span>
								<br/>{{ trans('flow.questions.3-8.options.3') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-8.text') }}</p>
					</div>

					<div data-sub-step="9" class="sub_step"
						 v-bind:class="{'sub_step--skip': user_data.vegetarian > 1 && user_data.foods.fish == 1 }">
						<h3 class="substep-title">{{ trans('flow.questions.3-9.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][9]" value="chiaoil" v-model="user_data.foods.oil"
									   v-on:click="nextStep();"/>
								<span class="icon pill-3g"></span>
								<br/>{{ trans('flow.questions.3-9.options.1') }}
								<a class="more-info-link" href="#" v-on:click="moreInfo('chiaoil', $event);">Mere
									info</a>
							</label>
							<label>
								<input type="radio" name="step[3][9]" value="fishoil" v-model="user_data.foods.oil"
									   v-on:click="nextStep();"/>
								<span class="icon pill-3e"></span>
								<br/>{{ trans('flow.questions.3-9.options.2') }}
								<a class="more-info-link" href="#" v-on:click="moreInfo('fishoil', $event);">Mere
									info</a>
							</label>
							<label>
								<input type="radio" name="step[3][9]" value="null" v-model="user_data.foods.oil"
									   v-on:click="nextStep();"/>
								<span class="icon icon-no-pill"></span>
								<br/>{{ trans('flow.questions.3-9.options.3') }}
								<div class="more-info-link">&nbsp;</div>
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-9.text') }}</p>
					</div>
				</div>

				<div data-step="4" class="step">
					<div id="advises-loader" class="text-center">
						<div class="spinner" style="display: inline-block;">
							<div class="rect1"></div>
							<div class="rect2"></div>
							<div class="rect3"></div>
							<div class="rect4"></div>
							<div class="rect5"></div>
						</div>

						<h2>Vent venligst..</h2> {{-- todo translate --}}
						<p>Vent et øjeblik mens vi sammensætter den ideelle Takedaily pakke til
							dig</p> {{-- todo translate --}}
					</div>

					<div id="advises-block" class="text-left" style="display: none;">
						<h2>Dine anbefalinger</h2> {{-- todo translate --}}
						<button type="submit"
								class="button button--green button--large visible-xs button--full-mobile m-t-30 m-b-30">{{ trans('flow.button-order-text') }}</button>

						<div class="row">
							<div class="col-md-7">
								<div class="tabs m-b-30">
									<div class="options">
										<div data-tab="#advises-label" class="tab tab-toggler tab--active">
											Supplementer
										</div>
										<div data-tab="#advises-content" class="tab tab-toggler">Beskrivelse</div>

										<div class="clear"></div>
									</div>

									<div id="advises-label" class="tab-block tab-block--active"></div>
									<div id="advises-content" class="tab-block"></div>
								</div>

								<p>Ønsker du at ændre dine vitaminer? <a href="/pick-n-mix" id="link-to-change">Tryk
										her</a></p>

								@include('includes.disclaimer')
							</div>
							<div class="col-md-5">
								<div class="card">
									<table class="order_table">
										<tbody>
										<tr>
											<td>{{ trans("products." . (Session::get('force_product_name', false) ? ( Session::get('product_name', 'subscription')) : 'subscription')) }}</td>
											<td>{{ trans('general.money-vue', ['amount' => 'sub_price']) }}</td>
										</tr>
										@if($product->is_subscription == 1)
											<tr>
												<td>{{ trans('checkout.index.total.shipping') }}</td>
												<td>
													<span
														v-show="shipping == 0">{{ trans('checkout.index.total.free') }}</span>
													<span
														v-show="shipping > 0">{{ trans('general.money-vue', ['amount' => 'shipping']) }}</span>
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

									<button type="submit"
											class="button button--green button--huge button--full-mobile m-t-30">{{ trans('flow.button-order-text') }}</button>

									<div class="m-t-20 m-b-20">
										<a href="#coupon-field"
										   id="toggle-coupon-form">{{ trans('checkout.index.coupon.link') }}</a>
									</div>

									<div id="coupon-field" style="display: none;" class="m-t-20">
										<!-- todo make the coupon part work -->
										<div class="row">
											<div class="col-md-8">
												<input type="text" id="coupon-input" maxlength="20"
													   placeholder="{{ trans('checkout.index.coupon.input-placeholder') }}"
													   class="input input--regular input--uppercase input--spacing input--full input--semibold"
													   value="{{ Request::old('coupon', Session::get('applied_coupon')) }}"/>
											</div>

											<div class="col-md-4">
												<button type="button"
														class="button button--regular button--green button--full"
														id="coupon-button">{{ trans('checkout.index.coupon.button-text') }}</button>
											</div>
										</div>

										<div id="coupon-form-successes" class="m-t-10"></div>
										<div id="coupon-form-errors" class="m-t-10"></div>
									</div>
								</div>
							</div>
						</div>

						<div class="m-b-20">
							<button type="button" class="link-button" id="send-by-mail-button">Send et link til mine
								anbefalinger
							</button>{{-- todo translate --}}
						</div>
					</div>

					<textarea name="user_data" id="user_data_field" type="hidden"
							  style="display: none;">@{{ $data.user_data | json }}</textarea>
				</div>

				{{ csrf_field() }}
				<input type="hidden" name="product_name"
					   value="{{ Session::get('force_product_name', false) ? ( Session::get('product_name', 'subscription')) : 'subscription' }}"/>

			</form>
		</div>
	</div>

	@if( ! isset($_COOKIE['call-me-hidden'])  )
		<style>
			body {
				padding-bottom: 190px;
			}

			.call-cta {
				z-index: 99999999999 !important; /* eeeeeeeeww */
			}
		</style>
		<div class="call-cta" id="call-me-form-toggler">
			<div class="container">
				<span title="{{ trans('flow.call-me.deny') }}" id="call-me-form-hider"
					  class="icon icon-cross-large pull-right"></span>
				<strong>{{ trans('flow.call-me.title') }}</strong>
				<span>{{ trans('flow.call-me.text') }}</span>
				<form method="post" action="{{ URL::route('ajax-call-me') }}" id="call-me-form">
					<input type="number" pattern="\d." maxlength="14" name="phone"
						   class="input input--regular input--plain input--no-number input--spacing input--full-mobile m-t-10"
						   placeholder="12 34 56 78" required="required"/>
					<select class="select select--regular select--spacing select--plain select--full-mobile m-t-10"
							name="period">
						@foreach(trans('flow.call-me.options') as $option)
							<option value="{{ $option }}">{{ $option }}</option>
						@endforeach
					</select>
					<div class="m-t-10">
						<button type="submit"
								class="button button--white button--large button--full-mobile">{{ trans('flow.call-me.button-text') }}</button>
					</div>
				</form>
			</div>
		</div>
	@endif
@endsection

@section('footer_scripts')
	<script type="text/javascript">
		var firstStep = $(".step.step--active"),
			combinationAjax,
			combinationTimeout;

		var newHeight = 1;
		firstStep.find(".sub_step").each(function () {
			if ($(this).height() > newHeight) {
				newHeight = $(this).height();
			}
		});

		firstStep.css("min-height", newHeight * 1.2);

		$("window").resize(function () {
			var firstStep = $(".step.step--active");

			var newHeight = 1;
			firstStep.find(".sub_step").each(function () {
				if ($(this).height() > newHeight) {
					newHeight = $(this).height();
				}
			});

			firstStep.css("min-height", newHeight * 1.2);
		});

		var app = new Vue({
			el: '#app',
			data: {
				step: 1,
				sub_step: 1,
				current_advise_one: null,
				current_advise_two: null,
				current_advise_three: null,
				temp_age: null,
				shipping: {{ $shippingPrice }},
				price: "{{ $giftcard ? 0 : \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price) }}",
				sub_price: "{{ \App\Apricot\Libraries\MoneyLibrary::toMoneyFormat($product->price) }}",
				tax_rate: "{{ $taxRate }}",
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
					diet: null,
					sports: null,
					lacks_energy: null,
					smokes: null,
					immune_system: null,
					supplements: null,
					vegetarian: null,
					joints: null,
					stressed: null,
					oil: null,
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
					return this.price;
				},
				total_sub: function () {
					return this.price - this.total_discount;
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

				getSubStepsForStep: function () {
					return $(".step[data-step='" + this.step + "']:not(.sub_step--skip)").find(".sub_step").length;
				},

				checkIfShouldGetCombinations: function () {
					if (this.step == 4) {
						var time = 0;

						if (combinationAjax) {
							combinationAjax.abort();
						}

						if (combinationTimeout) {
							clearTimeout(combinationTimeout);
						}

						combinationAjax = $.ajax({
							url: '{{ URL::route('flow-recommendations') }}',
							method: 'POST',
							dataType: 'JSON',
							cache: true,
							data: {user_data: $("#user_data_field").val()},
							beforeSend: function () {
								time = new Date();
							},
							success: function (response) {
								var curTime = new Date();

								var timeout = curTime.getTime() - time.getTime();

								if (timeout >= 3200) {
									timeout = 3199;
								}

								combinationTimeout = setTimeout(function () {
									$("#advises-loader").hide();
									$("#advises-block").fadeIn();
									$("#advises-content").html(response.advises);
									$("#advises-label").html(response.label);
									$("#link-to-change").attr('href', ('{{ URL::route('pick-n-mix') }}?selected=' + response.selected_codes));
								}, 3200 - timeout);
							}
						});
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

		$('#openPicker').datepicker({
			startDate: "-100y",
			endDate: "-18y",
			startView: 2,
			weekStart: 1,
			autoclose: true,
			language: "{{ App::getLocale() }}"
		}).on("changeDate", function () {
			app.user_data.birthdate = $('#openPicker').datepicker('getDate');
		});

		$("#openPicker").click(function (e) {
			e.preventDefault();
			$('#openPicker').datepicker('show');
		});

		$("#flow-toggler").click(function (e) {
			$(".flow-progress").toggleClass('flow-progress--closed');
			$(this).toggleClass('toggled');
		});

		$(".tab-toggler").click(function () {
			$(this).parent().find('.tab--active').removeClass('tab--active');
			$(this).parent().parent().find('.tab-block--active').removeClass('tab-block--active');
			$(this).addClass('tab--active');
			$($(this).data('tab')).addClass('tab-block--active');
		});
	</script>
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
					button.text('Vent...').prop('disabled', true); // todo translate
				},
				complete: function () {
					button.text('Anvend').prop('disabled', false); // todo translate
				},
				success: function (response) {
					$("#coupon-form-successes").text(response.message);
					$("#coupon-form-errors").text('');

					app.discount.applied = true;
					app.discount.type = response.coupon.discount_type;
					app.discount.amount = response.coupon.discount;
					app.discount.applies_to = response.coupon.applies_to;
					app.discount.description = response.coupon.description;
					app.discount.code = response.coupon.code;
				},
				error: function (response) {
					$("#coupon-form-errors").text(response.responseJSON.message);
					$("#coupon-form-successes").text('');

					app.discount.applied = false;
					app.discount.code = '';
				}
			});
		});

		if ($("#coupon-input").val().length > 0) {
			$("#coupon-button").click();
		}
	</script>


	<script>{{-- todo translate --}}
	$("#send-by-mail-button").click(function () {
			swal({
				title: "Send anbefaling",
				text: "Indtast din e-mail adresse:",
				type: "input",
				showCancelButton: true,
				confirmButtonColor: "#3AAC87",
				confirmButtonText: "Send",
				cancelButtonText: "Annuller",
				closeOnConfirm: false,
				inputPlaceholder: "navn@email.dk",
				showLoaderOnConfirm: true
			}, function (inputValue) {
				if (inputValue === false || inputValue === "") {
					swal.showInputError("Du skal indtaste din e-mail!");
					return false;
				}

				setTimeout(function () {
					swal({
						title: "{{ trans('message.success-title') }}",
						text: "Anbefalingen blev sendt!",
						type: "success",
						html: true,
						allowOutsideClick: true,
						confirmButtonText: "{{ trans('popup.button-close') }}",
						confirmButtonColor: "#3AAC87",
						timer: 6000
					});
				}, 2000);
			});
		});
	</script>
@endsection
