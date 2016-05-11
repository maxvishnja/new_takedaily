@extends('layouts.app')

@section('pageClass', 'page-flow')

@section('mainClasses', 'm-b-50')

@section('title', trans('flow.title'))

@section('content')
	<noscript>
		<style>
			#app { display: none !important; }
		</style>

		<h1 class="text-center">{{ trans('flow.scripts') }}</h1>
	</noscript>

	<div id="app" class="flow-container">
		<div class="flow-progress flow-progress--closed">
			<span class="hamburger" id="flow-toggler">
				<span class="meat"></span>
				<span class="meat"></span>
				<span class="meat meat--last"></span>
			</span>

			<div class="flow-step" step="1" v-bind:class="{ 'flow-step--inactive': step !== 1, 'flow-step--completed': step > 1 }">
				<div class="flow-step-progress">
					<span class="flow-step-progress-bar" v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
				<div class="flow-step-check">
					<div class="icon icon-check"></div>
				</div>
				<div class="flow-step-title">{{ trans('flow.steps.one') }}</div>
			</div>
			<div class="flow-step flow-step--inactive" step="2" v-bind:class="{ 'flow-step--inactive': step !== 2, 'flow-step--completed': step > 2 }">
				<div class="flow-step-progress">
					<span class="flow-step-progress-bar" v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
				<div class="flow-step-check">
					<div class="icon icon-check"></div>
				</div>
				<div class="flow-step-title">{{ trans('flow.steps.two') }}</div>
			</div>
			<div class="flow-step flow-step--inactive" step="3" v-bind:class="{ 'flow-step--inactive': step !== 3, 'flow-step--completed': step > 3 }">
				<div class="flow-step-progress">
					<span class="flow-step-progress-bar" v-bind:style="{ width: ( sub_step / getSubStepsForStep() * 100 ) + '%' }"></span></div>
				<div class="flow-step-check">
					<div class="icon icon-check"></div>
				</div>
				<div class="flow-step-title">{{ trans('flow.steps.three') }}</div>
			</div>
			<div class="flow-step flow-step--inactive" step="4" v-bind:class="{ 'flow-step--inactive': step !== 4 }">
				<div class="flow-step-title">{{ trans('flow.steps.four') }}</div>
			</div>
		</div>

		<div class="container">

			<div class="flow-step-back" v-bind:class="{ 'clickable': step > 1 || sub_step > 1}">
				<a href="javascript: void(0);" v-on:click="previousStep();">{{ trans('flow.back') }}</a>
			</div>

			<form method="post" action="">
				<div data-step="1" data-first-sub-step="1" class="step step--active">
					<div data-sub-step="1" class="sub_step sub_step--active">
						<h3 class="substep-title">{{ trans('flow.questions.1-1.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[1][1]" value="1" v-model="user_data.gender" v-on:click="nextStep();"/>
								<span class="icon icon-gender-male"></span>
								<br/>{{ trans('flow.questions.1-1.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[1][1]" value="2" v-model="user_data.gender" v-on:click="nextStep();"/>
								<span class="icon icon-gender-female"></span>
								<br/>{{ trans('flow.questions.1-1.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.1-1.text') }}</p>
					</div>

					<div data-sub-step="2" class="sub_step">
						<h3 class="substep-title" v-show="user_data.gender == 1">{{ trans('flow.questions.1-2.title') }}</h3>
						<h3 class="substep-title" v-show="user_data.gender == 2">{{ trans('flow.questions.1-2.title-alt') }}</h3>

						<div class="datepicker-container-block">
							<label for="birthdate-picker" class="text-center flow_label_noclick">
								<span class="icon calendar-icon" style="vertical-align: middle; margin-right: 6px;"></span>
								<span>{{ trans('flow.questions.1-2.button-text') }}</span>
							</label>
						</div>

						<template v-if="temp_age">
							<br/>
							<button v-on:click="nextStep();" type="button" class="button button--rounded button--medium button--green">{!! trans('flow.questions.1-2.button-submit-text') !!}</button>
						</template>

						<p class="substep-explanation">{{ trans('flow.questions.1-2.text') }}</p>
					</div>

					<input type="text" name="step[1][1]" v-model="user_data.birthdate" id="birthdate-picker" style="visibility: hidden; height: 0px !important;"/>
					<div id="datepicker-container"></div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.1-3.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[1][3]" value="1" v-model="user_data.skin" v-on:click="nextStep();"/>
								<span class="icon icon-skin-white"></span>
								<br/>{{ trans('flow.questions.1-3.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[1][3]" value="2" v-model="user_data.skin" v-on:click="nextStep();"/>
								<span class="icon icon-skin-mediterranean"></span>
								<br/>{{ trans('flow.questions.1-3.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[1][3]" value="3" v-model="user_data.skin" v-on:click="nextStep();"/>
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
								<input type="radio" name="step[1][4]" value="1" v-model="user_data.outside" v-on:click="nextStep();"/>
								<span class="icon icon-sun-yes"></span>
								<br/>{{ trans('flow.questions.1-4.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[1][4]" value="2" v-model="user_data.outside" v-on:click="nextStep();"/>
								<span class="icon icon-sun-no"></span>
								<br/>{{ trans('flow.questions.1-4.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.1-4.text') }}</p>
					</div>
				</div>

				<div data-step="2" v-bind="{ 'data-first-sub-step': user_data.gender == 2 ? 1 : 2 }" class="step">
					<div data-sub-step="1" class="sub_step sub_step--active" v-bind:class="{ 'sub_step--active': user_data.gender == 2 }">
						<h3 class="substep-title">{{ trans('flow.questions.2-1.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][1]" value="1" v-model="user_data.pregnant" v-on:click="nextStep();"/>
								<span class="icon icon-pregnant-yes"></span>
								<br/>{{ trans('flow.questions.2-1.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][1]" value="2" v-model="user_data.pregnant" v-on:click="nextStep();"/>
								<span class="icon icon-pregnant-no"></span>
								<br/>{{ trans('flow.questions.2-1.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{!! trans('flow.questions.2-1.text') !!}</p>
					</div>

					<div data-sub-step="2" class="sub_step" v-bind:class="{ 'sub_step--active': user_data.gender == 1 }">
						<h3 class="substep-title">{{ trans('flow.questions.2-2.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[2][2]" value="1" v-model="user_data.diet" v-on:click="nextStep();"/>
								<span class="icon icon-diet-pear"></span>
								<br/>{{ trans('flow.questions.2-2.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][2]" value="2" v-model="user_data.diet" v-on:click="nextStep();"/>
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
								<input type="radio" name="step[2][3]" value="1" v-model="user_data.sports" v-on:click="nextStep();"/>
								<span class="icon icon-activity-seldom"></span>
								<br/>{{ trans('flow.questions.2-3.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][3]" value="2" v-model="user_data.sports" v-on:click="nextStep();"/>
								<span class="icon icon-activity-once"></span>
								<br/>{{ trans('flow.questions.2-3.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[2][3]" value="3" v-model="user_data.sports" v-on:click="nextStep();"/>
								<span class="icon icon-activity-twice"></span>
								<br/>{{ trans('flow.questions.2-3.options.3') }}
							</label>
							<label>
								<input type="radio" name="step[2][3]" value="4" v-model="user_data.sports" v-on:click="nextStep();"/>
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
								<input type="radio" name="step[2][4]" value="1" v-model="user_data.stressed" v-on:click="nextStep();"/>
								<span class="icon icon-stress"></span>
								<br/>{{ trans('flow.questions.2-4.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][4]" value="2" v-model="user_data.stressed" v-on:click="nextStep();"/>
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
								<input type="radio" name="step[2][5]" value="1" v-model="user_data.lacks_energy" v-on:click="nextStep();"/>
								<span class="icon icon-tired"></span>
								<br/>{{ trans('flow.questions.2-5.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][5]" value="2" v-model="user_data.lacks_energy" v-on:click="nextStep();"/>
								<span class="icon icon-awake"></span>
								<br/>{{ trans('flow.questions.2-5.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[2][5]" value="3" v-model="user_data.lacks_energy" v-on:click="nextStep();"/>
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
								<input type="radio" name="step[2][6]" value="1" v-model="user_data.immune_system" v-on:click="nextStep();"/>
								<span class="icon icon-immune-boost"></span>
								<br/>{{ trans('flow.questions.2-6.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][6]" value="2" v-model="user_data.immune_system" v-on:click="nextStep();"/>
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
								<input type="radio" name="step[2][7]" value="1" v-model="user_data.smokes" v-on:click="nextStep();"/>
								<span class="icon icon-smoke"></span>
								<br/>{{ trans('flow.questions.2-7.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][7]" value="2" v-model="user_data.smokes" v-on:click="nextStep();"/>
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
								<input type="radio" name="step[2][8]" value="1" v-model="user_data.vegetarian" v-on:click="nextStep();"/>
								<span class="icon icon-vegetarian-yes"></span>
								<br/>{{ trans('flow.questions.2-8.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][8]" value="2" v-model="user_data.vegetarian" v-on:click="nextStep();"/>
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
								<input type="radio" name="step[2][9]" value="1" v-model="user_data.joints" v-on:click="nextStep();"/>
								<span class="icon icon-joint-yes"></span>
								<br/>{{ trans('flow.questions.2-9.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][9]" value="2" v-model="user_data.joints" v-on:click="nextStep();"/>
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
								<input type="radio" name="step[2][10]" value="1" v-on:click="nextStep();" v-model="user_data.supplements"/>
								<span class="icon icon-supplement-yes"></span>
								<br/>{{ trans('flow.questions.2-10.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[2][10]" value="2" v-on:click="nextStep();" v-model="user_data.supplements"/>
								<span class="icon icon-supplement-no"></span>
								<br/>{{ trans('flow.questions.2-10.options.2') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.2-10.text') }}</p>
					</div>
				</div>

				<div data-step="3" data-first-sub-step="1" class="step">
					<div data-sub-step="1" class="sub_step sub_step--active">
						<h3 class="substep-title">{{ trans('flow.questions.3-1.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][1]" value="1" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-1"></span>
								<br/>{{ trans('flow.questions.3-1.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="2" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-2"></span>
								<br/>{{ trans('flow.questions.3-1.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="3" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-3"></span>
								<br/>{{ trans('flow.questions.3-1.options.3') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="4" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-4"></span>
								<br/>{{ trans('flow.questions.3-1.options.4') }}</label>
							<label>
								<input type="radio" name="step[3][1]" value="5" v-model="user_data.foods.vegetables" v-on:click="nextStep();"/>
								<span class="icon icon-portion-vegetables-5"></span>
								<br/>{{ trans('flow.questions.3-1.options.5') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-1.text') }}</p>
					</div>

					<div data-sub-step="2" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-2.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="1" v-on:click="nextStep();"/>
								<span class="icon icon-portion-fruit-1"></span>
								<br/>{{ trans('flow.questions.3-2.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="2" v-on:click="nextStep();"/>
								<span class="icon icon-portion-fruit-2"></span>
								<br/>{{ trans('flow.questions.3-2.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][2]" v-model="user_data.foods.fruits" value="3" v-on:click="nextStep();"/>
								<span class="icon icon-portion-fruit-3"></span>
								<br/>{{ trans('flow.questions.3-2.options.3') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-2.text') }}</p>
					</div>

					<div data-sub-step="3" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-3.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][3]" value="1" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-1"></span>
								<br/>{{ trans('flow.questions.3-3.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="2" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-2"></span>
								<br/>{{ trans('flow.questions.3-3.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="3" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-3"></span>
								<br/>{{ trans('flow.questions.3-3.options.3') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="4" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-4"></span>
								<br/>{{ trans('flow.questions.3-3.options.4') }}</label>
							<label>
								<input type="radio" name="step[3][3]" value="5" v-model="user_data.foods.bread" v-on:click="nextStep();"/>
								<span class="icon icon-portion-bread-5"></span>
								<br/>{{ trans('flow.questions.3-3.options.5') }}</label>
						</div>

						<p class="substep-explanation">{!! trans('flow.questions.3-3.text') !!}</p>
					</div>

					<div data-sub-step="4" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-4.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][4]" value="1" v-model="user_data.foods.butter" v-on:click="nextStep();"/>
								<span class="icon icon-portion-butter-yes"></span>
								<br/>{{ trans('flow.questions.3-4.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[3][4]" value="2" v-model="user_data.foods.butter" v-on:click="nextStep();"/>
								<span class="icon icon-portion-butter-no"></span>
								<br/>{{ trans('flow.questions.3-4.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[3][4]" value="3" v-model="user_data.foods.butter" v-on:click="nextStep();"/>
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
								<input type="radio" name="step[3][5]" value="1" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-1"></span>
								<br/>{{ trans('flow.questions.3-5.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][5]" value="2" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-2"></span>
								<br/>{{ trans('flow.questions.3-5.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][5]" value="3" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-3"></span>
								<br/>{{ trans('flow.questions.3-5.options.3') }}</label>
							<label>
								<input type="radio" name="step[3][5]" value="4" v-model="user_data.foods.wheat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-pasta-4"></span>
								<br/>{{ trans('flow.questions.3-5.options.4') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-5.text') }}</p>
					</div>

					<div data-sub-step="6" class="sub_step">{{-- consider hide if vegeratian --}}
						<h3 class="substep-title">{{ trans('flow.questions.3-6.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][6]" value="1" v-model="user_data.foods.meat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-meat-1"></span>
								<br/>{{ trans('flow.questions.3-6.options.1') }}</label>
							<label>
								<input type="radio" name="step[3][6]" value="2" v-model="user_data.foods.meat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-meat-2"></span>
								<br/>{{ trans('flow.questions.3-6.options.2') }}</label>
							<label>
								<input type="radio" name="step[3][6]" value="3" v-model="user_data.foods.meat" v-on:click="nextStep();"/>
								<span class="icon icon-portion-meat-3"></span>
								<br/>{{ trans('flow.questions.3-6.options.3') }}</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-6.text') }}</p>
					</div>

					<div data-sub-step="7" class="sub_step">
						<h3 class="substep-title">{{ trans('flow.questions.3-7.title') }}</h3>
						<div class="sub_step_answers">
							<label>
								<input type="radio" name="step[3][7]" value="1" v-model="user_data.foods.fish" v-on:click="nextStep();"/>
								<span class="icon icon-portion-fish-1"></span>
								<br/>{{ trans('flow.questions.3-7.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[3][7]" value="2" v-model="user_data.foods.fish" v-on:click="nextStep();"/>
								<span class="icon icon-portion-fish-2"></span>
								<br/>{{ trans('flow.questions.3-7.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[3][7]" value="3" v-model="user_data.foods.fish" v-on:click="nextStep();"/>
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
								<input type="radio" name="step[3][8]" value="1" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
								<span class="icon icon-portion-milk-1"></span>
								<br/>{{ trans('flow.questions.3-8.options.1') }}
							</label>
							<label>
								<input type="radio" name="step[3][8]" value="2" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
								<span class="icon icon-portion-milk-2"></span>
								<br/>{{ trans('flow.questions.3-8.options.2') }}
							</label>
							<label>
								<input type="radio" name="step[3][8]" value="3" v-model="user_data.foods.dairy" v-on:click="nextStep();"/>
								<span class="icon icon-portion-milk-3"></span>
								<br/>{{ trans('flow.questions.3-8.options.3') }}
							</label>
						</div>

						<p class="substep-explanation">{{ trans('flow.questions.3-8.text') }}</p>
					</div>
				</div>

				<div data-step="4" data-first-sub-step="1" class="step">
					<div id="advises-loader" class="text-center">
						<div class="spinner" style="display: inline-block;">
							<div class="rect1"></div>
							<div class="rect2"></div>
							<div class="rect3"></div>
							<div class="rect4"></div>
							<div class="rect5"></div>
						</div>

						<h2>Vent venligst..</h2> {{-- todo translate --}}
						<p>Vent et øjeblik mens vi sammensætter den ideelle Takedaily pakke til dig</p> {{-- todo translate --}}
					</div>

					<div id="advises-block" class="text-left" style="display: none;">
						<h2>Dine anbefalinger</h2> {{-- todo translate --}}
						<div id="advises-content"></div>
						<button type="submit" class="button button--green button--medium button--full-mobile">{{ trans('flow.button-order-text') }}</button>
					</div>
					<textarea name="user_data" id="user_data_field" type="hidden" style="display: none;">@{{ $data.user_data | json }}</textarea>
				</div>

				{{ csrf_field() }}
				<input type="hidden" name="product_name" value="{{ Session::get('force_product_name', false) ? ( Session::get('product_name', 'subscription')) : 'subscription' }}"/>
			</form>
		</div>
	</div>

	@if( ! isset($_COOKIE['call-me-hidden'])  )
		<style>
			body { padding-bottom: 190px; }
		</style>
		<div class="call-cta" id="call-me-form-toggler">
			<div class="container">
				<span title="{{ trans('flow.call-me.deny') }}" id="call-me-form-hider" class="icon icon-cross-large pull-right"></span>
				<strong>{{ trans('flow.call-me.title') }}</strong>
				<span>{{ trans('flow.call-me.text') }}</span>
				<form method="post" action="/call-me" id="call-me-form">
					<input type="number" pattern="\d." maxlength="14" name="phone" class="input input--regular input--plain input--no-number input--spacing input--full-mobile m-t-10" placeholder="12 34 56 78" required="required"/>
					<select class="select select--regular select--spacing select--plain select--full-mobile m-t-10" name="period">
						@foreach(trans('flow.call-me.options') as $option)
							<option value="{{ $option }}">{{ $option }}</option>
						@endforeach
					</select>
					<div class="m-t-10">
						<button type="submit" class="button button--white button--large button--full-mobile">{{ trans('flow.call-me.button-text') }}</button>
					</div>
				</form>
			</div>
		</div>
	@endif
@endsection

@section('footer_scripts')
	<script type="text/javascript">

		var firstStep = $(".step.step--active");

		var newHeight = 1;
		firstStep.find(".sub_step").each(function() {
			if ($(this).height() > newHeight) {
				newHeight = $(this).height();
			}
		});

		firstStep.css("min-height", newHeight * 1.2);

		$("window").resize( function ()
		{
			var firstStep = $(".step.step--active");

			var newHeight = 1;
			firstStep.find(".sub_step").each(function() {
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
				temp_age: function ()
				{
					return this.getAge();
				}
			},
			methods: {
				nextStep: function ()
				{
					var currentStep = $(".step[data-step='" + this.step + "']");
					var nextStep = $(".step[data-step='" + (this.step + 1) + "']");
					var currentSubStep = currentStep.find(".sub_step[data-sub-step='" + this.sub_step + "']");
					var nextSubStep = currentStep.find(".sub_step[data-sub-step='" + (this.sub_step + 1) + "']");

					if (nextSubStep[0])
					{
						this.sub_step = nextSubStep.attr("data-sub-step") * 1;
						currentSubStep.removeClass("sub_step--active").removeClass('sub_step--active-animated').removeClass("sub_step--slideout-prev").removeClass("sub_step--prev").addClass("sub_step--out-animated");
						nextSubStep.addClass('sub_step--active').removeClass("sub_step--slideout-prev").removeClass("sub_step--prev").addClass('sub_step--active-animated').removeClass("sub_step--out-animated");

						return true;
					}

					this.step++;
					this.sub_step = nextStep.attr("data-first-sub-step") * 1;

					currentStep.removeClass("step--active");
					nextStep.addClass("step--active");

					var newHeight = 1;
					nextStep.find(".sub_step").each(function() {
						if ($(this).height() > newHeight) {
							newHeight = $(this).height();
						}
					});

					nextStep.css("min-height", newHeight * 1.2);

					this.checkIfShouldGetCombinations();

					return true;
				},

				getSubStepsForStep: function ()
				{
					return $(".step[data-step='" + this.step + "']").find(".sub_step").length;
				},

				checkIfShouldGetCombinations: function ()
				{
					if (this.step == 4)
					{
						var time = 0;

						$.ajax({
							url: '/flow/recommendations',
							method: 'POST',
							dataType: 'JSON',
							cache: true,
							data: {user_data: $("#user_data_field").val()},
							beforeSend: function ()
							{
								time = new Date();
							},
							success: function(response)
							{
								var curTime = new Date();

								var timeout = curTime.getTime() - time.getTime();

								if (timeout >= 3200)
								{
									timeout = 3199;
								}

								setTimeout( function () {
									$("#advises-loader").hide();
									$("#advises-block").fadeIn();
									$("#advises-content").html(response.advises);
								}, 3200 - timeout);
							}
						});
					}
					else
					{
						$("#advises-block").hide();
						$("#advises-loader").show();
					}
				},

				previousStep: function ()
				{
					if (this.sub_step == 1 && this.step == 1)
					{
						return false;
					}

					var currentStep = $(".step[data-step='" + this.step + "']");
					var previousStep = $(".step[data-step='" + (this.step - 1) + "']");

					if (this.sub_step > ( currentStep.attr('data-first-sub-step') * 1 ))
					{
						var currentSubStep = currentStep.find(".sub_step[data-sub-step='" + this.sub_step + "']");
						var previousSubStep = currentStep.find(".sub_step[data-sub-step='" + (this.sub_step - 1) + "']");

						if (previousSubStep[0])
						{
							this.sub_step = previousSubStep.attr("data-sub-step") * 1;
							currentSubStep.removeClass("sub_step--active").removeClass('sub_step--active-animated').addClass("sub_step--slideout-prev").addClass("sub_step--out-animated").removeClass("sub_step--prev");
							previousSubStep.addClass('sub_step--active').addClass("sub_step--prev").addClass('sub_step--active-animated').removeClass("sub_step--out-animated");

							return true;
						}
					}

					var numberOfSubStepsInPreviousStep = previousStep.find(".sub_step").length;

					this.step--;
					this.sub_step = numberOfSubStepsInPreviousStep;

					currentStep.removeClass("step--active");
					previousStep.addClass("step--active");

					this.checkIfShouldGetCombinations();

					return true;
				},

				getAge: function ()
				{
					if (this.user_data.birthdate === null)
					{
						return null;
					}

					var today = new Date();
					var birthDate = new Date(this.user_data.birthdate);
					var age = today.getFullYear() - birthDate.getFullYear();
					var m = today.getMonth() - birthDate.getMonth();
					if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate()))
					{
						age--;
					}

					if (age !== undefined && age > 0)
					{
						this.user_data.age = age;

						return this.user_data.age;
					}

					return false;
				},

				shouldJumpToNext: function (elementId, length, event)
				{
					if (length === false || event.target.value.length >= length)
					{
						$("#" + elementId).select();
						return true;
					}

					return false;
				}
			}
		});

		var $birthdayPicker = $("#birthdate-picker").pickadate({
			// Strings and translations
			monthsFull: [
				@foreach(trans('flow.datepicker.months_long') as $month)
					'{{ $month }}',
				@endforeach
			],
			monthsShort: [
				@foreach(trans('flow.datepicker.months_short') as $month)
					'{{ $month }}',
				@endforeach
			],
			weekdaysFull: [
				@foreach(trans('flow.datepicker.days_long') as $day)
					'{{ $day }}',
				@endforeach
			],
			weekdaysShort: [
				@foreach(trans('flow.datepicker.days_short') as $day)
					'{{ $day }}',
				@endforeach
			],
			today: false,
			clear: '{{ trans('flow.datepicker.buttons.clear') }}',
			close: '{{ trans('flow.datepicker.buttons.close') }}',
			labelMonthNext: '{{ trans('flow.datepicker.buttons.next-month') }}',
			labelMonthPrev: '{{ trans('flow.datepicker.buttons.prev-month') }}',
			labelMonthSelect: '{{ trans('flow.datepicker.buttons.select-month') }}',
			labelYearSelect: '{{ trans('flow.datepicker.buttons.select-year') }}',
			format: 'd mmmm, yyyy',
			selectYears: 100,
			selectMonths: true,
			firstDay: 1,
			min: new Date("{{ date('Y-m-d', strtotime('-100 years 1/1')) }}"),
			max: new Date("{{ date('Y-m-d', strtotime('-13 years 12/31')) }}"),
			closeOnClear: false,
			hiddenName: true,
			formatSubmit: 'yyyy-mm-dd',
			container: '#datepicker-container',
			onSet: function ()
			{
				app.user_data.birthdate = this.get('select', 'yyyy-mm-dd');
			}
		});
		
		$("#openPicker").click(function (e)
		{
			e.preventDefault();
			$birthdayPicker.pickadate('picker').open();
		});

		$("#flow-toggler").click(function (e)
		{
			$(".flow-progress").toggleClass('flow-progress--closed');
		});
	</script>
@endsection
